<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PeminjamanInventaris;
use App\Models\Inventaris;
use Illuminate\Support\Facades\DB;

class PeminjamanInventarisController extends Controller
{
    public function index()
    {
        $query = PeminjamanInventaris::with(['user', 'inventaris']);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('peminjaman_inventaris.index', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'inventaris_id' => 'required|exists:inventaris,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'nullable|date|after_or_equal:tanggal_pinjam',
            'keterangan' => 'nullable|string',
        ]);

        $item = Inventaris::findOrFail($request->inventaris_id);

        if ($item->jumlah < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        // Logic: Should we reduce stock immediately or only upon approval?
        // Usually, we reserve it or check availability. For simplicity here, we check availability but don't reduce until approval,
        // OR we reduce immediately. Let's stick to "reduce upon approval" logic to avoid phantom bookings, 
        // BUT for a simple system, reducing on approval is safer.
        // However, to prevent overbooking while pending, we should probably check "Available = Total - (Borrowed + Pending)".
        // For now, let's just create the request.

        PeminjamanInventaris::create([
            'user_id' => auth()->id(),
            'inventaris_id' => $request->inventaris_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Pengajuan peminjaman berhasil dibuat.');
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        DB::transaction(function () use ($id) {
            $peminjaman = PeminjamanInventaris::lockForUpdate()->findOrFail($id);
            $item = Inventaris::lockForUpdate()->findOrFail($peminjaman->inventaris_id);

            if ($peminjaman->status !== 'pending') {
                throw new \Exception('Status peminjaman tidak valid.');
            }

            if ($item->jumlah < $peminjaman->jumlah) {
                throw new \Exception('Stok barang tidak mencukupi.');
            }

            // Reduce stock
            $item->decrement('jumlah', $peminjaman->jumlah);
            
            $peminjaman->update(['status' => 'approved']);
        });

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $peminjaman = PeminjamanInventaris::findOrFail($id);
        $peminjaman->update(['status' => 'rejected']);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function returnItem($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        DB::transaction(function () use ($id) {
            $peminjaman = PeminjamanInventaris::lockForUpdate()->findOrFail($id);
            $item = Inventaris::lockForUpdate()->findOrFail($peminjaman->inventaris_id);

            if ($peminjaman->status !== 'approved') {
                throw new \Exception('Status peminjaman tidak valid.');
            }

            // Return stock
            $item->increment('jumlah', $peminjaman->jumlah);
            
            $peminjaman->update(['status' => 'returned', 'tanggal_kembali' => now()]);
        });

        return back()->with('success', 'Barang telah dikembalikan.');
    }
}
