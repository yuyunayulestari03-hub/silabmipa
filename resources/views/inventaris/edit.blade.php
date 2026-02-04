@extends('layouts.master')
@section('title', 'Edit Inventaris')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Edit Inventaris</h1>
    <p style="color: var(--muted);">Perbarui data alat atau bahan inventaris.</p>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto;">
    <form action="{{ route('inventaris.update', $inventaris->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kode Barang <span style="color: red;">*</span></label>
                <input type="text" name="kode_barang" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" value="{{ old('kode_barang', $inventaris->kode_barang) }}" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Barang <span style="color: red;">*</span></label>
                <input type="text" name="nama_barang" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" value="{{ old('nama_barang', $inventaris->nama_barang) }}" required>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kategori <span style="color: red;">*</span></label>
                <select name="kategori" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
                    <option value="alat" {{ old('kategori', $inventaris->kategori) == 'alat' ? 'selected' : '' }}>Alat</option>
                    <option value="bahan" {{ old('kategori', $inventaris->kategori) == 'bahan' ? 'selected' : '' }}>Bahan</option>
                </select>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Kondisi <span style="color: red;">*</span></label>
                <select name="kondisi" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
                    <option value="baik" {{ old('kondisi', $inventaris->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                    <option value="rusak" {{ old('kondisi', $inventaris->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="habis" {{ old('kondisi', $inventaris->kondisi) == 'habis' ? 'selected' : '' }}>Habis</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jumlah <span style="color: red;">*</span></label>
                <input type="number" name="jumlah" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" min="0" value="{{ old('jumlah', $inventaris->jumlah) }}" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Satuan <span style="color: red;">*</span></label>
                <input type="text" name="satuan" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" value="{{ old('satuan', $inventaris->satuan) }}" required>
            </div>
        </div>

        <div style="margin-bottom: 1rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Lokasi</label>
            <input type="text" name="lokasi" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" value="{{ old('lokasi', $inventaris->lokasi) }}">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Keterangan</label>
            <textarea name="keterangan" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" rows="3">{{ old('keterangan', $inventaris->keterangan) }}</textarea>
        </div>

        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('inventaris.index') }}" style="flex: 1; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; text-align: center; text-decoration: none; color: var(--text); background: white;">Batal</a>
            <button type="submit" style="flex: 2; background: var(--primary); color: white; border: none; padding: 0.75rem; border-radius: 6px; cursor: pointer; font-weight: 500;">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
