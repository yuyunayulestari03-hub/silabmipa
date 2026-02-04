@extends('layouts.master')
@section('title', 'Edit Jadwal Pratikum')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Edit Jadwal Pratikum</h1>
    <p style="color: var(--muted);">Perbarui informasi jadwal kegiatan laboratorium.</p>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto;">
    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Kegiatan</label>
            <input type="text" name="kegiatan" value="{{ $jadwal->kegiatan }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal</label>
            <input type="date" name="tanggal" value="{{ $jadwal->tanggal }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Waktu</label>
            <div style="display: flex; gap: 1rem;">
                <input type="time" name="waktu_mulai" value="{{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
                <span style="align-self: center;">s/d</span>
                <input type="time" name="waktu_selesai" value="{{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" required>
            </div>
        </div>

        <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 500; width: 100%;">
            Simpan Perubahan
        </button>
        <a href="{{ route('jadwal.index') }}" style="display: block; text-align: center; margin-top: 1rem; color: var(--muted); text-decoration: none;">Batal</a>
    </form>
</div>
@endsection