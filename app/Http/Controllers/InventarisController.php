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
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|in:baik,rusak,habis',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        Inventaris::create($request->all());

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
            'jumlah' => 'required|integer|min:0',
            'satuan' => 'required|string',
            'kondisi' => 'required|in:baik,rusak,habis',
            'lokasi' => 'nullable|string',
            'keterangan' => 'nullable|string',
        ]);

        $inventaris = Inventaris::findOrFail($id);
        $inventaris->update($request->all());

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
        $inventaris->update(['kondisi' => $request->kondisi]);

        // Calculate available amount
        $jumlahTersedia = $inventaris->kondisi == 'baik' ? $inventaris->jumlah : 0;

        return response()->json([
            'success' => true,
            'message' => 'Kondisi berhasil diperbarui!',
            'jumlah_tersedia' => $jumlahTersedia
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
