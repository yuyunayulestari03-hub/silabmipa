<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPratikum;

class PeminjamanController extends Controller
{
    public function index()
    {
        // Only admin can view all pending applications
        if (auth()->user()->role === 'admin') {
            $pengajuan = JadwalPratikum::where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->get();
            return view('peminjaman.index', compact('pengajuan'));
        }

        // User can view their own history? For now redirect or show empty
        return redirect()->route('jadwal.index');
    }

    public function create()
    {
        return view('peminjaman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        JadwalPratikum::create([
            'user_id' => auth()->id(),
            'kegiatan' => $request->kegiatan,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'status' => 'pending',
        ]);

        return redirect()->route('jadwal.index')->with('success', 'Peminjaman berhasil diajukan! Menunggu persetujuan admin.');
    }

    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = JadwalPratikum::findOrFail($id);
        $jadwal->update(['status' => 'approved']);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan disetujui!');
    }

    public function reject($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = JadwalPratikum::findOrFail($id);
        $jadwal->update(['status' => 'rejected']);

        return redirect()->route('peminjaman.index')->with('success', 'Pengajuan ditolak!');
    }
}
