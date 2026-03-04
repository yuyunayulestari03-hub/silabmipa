<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    public function index()
    {
        $inventaris = Inventaris::orderBy('created_at', 'desc')->paginate(10);
        return view('inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }
        return view('inventaris.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'kode_barang' => 'required|string|unique:inventaris',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:alat,bahan',
            'jumlah_total' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|in:baik,rusak,habis',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Inventaris::create([
    'kode_barang'     => $request->kode_barang,
    'nama_barang'     => $request->nama_barang,
    'kategori'        => $request->kategori,
    'jumlah_total'    => $request->jumlah_total,
    'jumlah_tersedia' => $request->jumlah_total, // 🔑 PENTING
    'satuan'          => $request->satuan,
    'kondisi'         => $request->kondisi,
    'lokasi'          => $request->lokasi,
    'keterangan'      => $request->keterangan,
]);


        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $inventaris = Inventaris::findOrFail($id);
        return view('inventaris.edit', compact('inventaris'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'kode_barang' => 'required|string|unique:inventaris,kode_barang,' . $id,
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:alat,bahan',
            'jumlah_total' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|in:baik,rusak,habis',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update([
    'kode_barang'  => $request->kode_barang,
    'nama_barang'  => $request->nama_barang,
    'kategori'     => $request->kategori,
    'kondisi'      => $request->kondisi,
    'jumlah_total' => $request->jumlah_total,

    // 🔒 JAGA KONSISTENSI STOK
    'jumlah_tersedia' => min(
        $inventaris->jumlah_tersedia,
        $request->jumlah_total
    ),

    'satuan'     => $request->satuan,
    'lokasi'     => $request->lokasi,
    'keterangan' => $request->keterangan,
]);


        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil diperbarui!');
    }

    public function updateKondisi(Request $request, $id)
{
    if (auth()->user()->role !== 'admin') {
        return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
    }

    $request->validate([
        'kondisi' => 'required|in:baik,rusak,habis',
    ]);

    $inventaris = Inventaris::findOrFail($id);

    $inventaris->update([
        'kondisi' => $request->kondisi,
        'jumlah_tersedia' => $request->kondisi === 'baik'
            ? $inventaris->jumlah_tersedia
            : 0,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Kondisi berhasil diperbarui!',
        'jumlah_tersedia' => $inventaris->jumlah_tersedia
    ]);
}


    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->delete();

        return redirect()->route('inventaris.index')->with('success', 'Data inventaris berhasil dihapus!');
    }
}
