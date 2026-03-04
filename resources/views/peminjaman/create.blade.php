@extends('layouts.master')
@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Ajukan Booking Jadwal</h1>
    <p style="color: var(--muted);">Isi formulir untuk mengajukan booking jadwal praktikum.</p>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('peminjaman.store') }}" method="POST">
        @csrf
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Kegiatan</label>
            <input type="text" name="kegiatan" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" placeholder="Contoh: Pratikum Kimia Dasar">
        </div>
<div style="margin-bottom: 1.5rem;">
    <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">
        Nama Dosen
    </label>
    <input 
        type="text" 
        name="nama_dosen" 
        class="form-control"
        style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;"
        placeholder="Contoh: Dr. Ahmad Fauzi, M.Pd"
        required
    >
</div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Waktu</label>
            <div style="display: flex; gap: 1rem;">
                <input type="time" name="waktu_mulai" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
                <span style="align-self: center;">s/d</span>
                <input type="time" name="waktu_selesai" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;">
            </div>
        </div>

        <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 500; width: 100%;">
            Kirim Pengajuan
        </button>
        <a href="{{ route('jadwal.index') }}" style="display: block; text-align: center; margin-top: 1rem; color: var(--muted); text-decoration: none;">Batal</a>
    </form>
</div>
@endsection