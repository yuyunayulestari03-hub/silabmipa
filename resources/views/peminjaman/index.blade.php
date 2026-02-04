@extends('layouts.master')

@section('title', 'Daftar Pengajuan Jadwal')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Daftar Pengajuan Jadwal</h1>
    <p style="color: var(--muted);">Kelola pengajuan peminjaman laboratorium dari user.</p>
</div>

@if (session('success'))
<div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text);">Pengajuan Masuk</h2>
    </div>

    @if($pengajuan->isEmpty())
        <p style="text-align: center; color: var(--muted); padding: 2rem;">Tidak ada pengajuan jadwal saat ini.</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">No</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Nama Pengaju</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Kegiatan</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Tanggal</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Waktu</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text); text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuan as $item)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem; color: var(--text);">{{ $loop->iteration }}</td>
                        <td style="padding: 1rem; color: var(--text);">{{ $item->user->name ?? 'User Tidak Ditemukan' }}</td>
                        <td style="padding: 1rem; color: var(--text);">{{ $item->kegiatan }}</td>
                        <td style="padding: 1rem; color: var(--muted);">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                        <td style="padding: 1rem; color: var(--muted);">{{ $item->waktu_mulai }} - {{ $item->waktu_selesai }}</td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                <form action="{{ route('peminjaman.approve', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Setujui pengajuan ini?')" style="background: #10b981; color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">Setujui</button>
                                </form>
                                <form action="{{ route('peminjaman.reject', $item->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" onclick="return confirm('Tolak pengajuan ini?')" style="background: #ef4444; color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">Tolak</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
