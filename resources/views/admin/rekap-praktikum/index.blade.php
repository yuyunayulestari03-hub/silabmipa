@extends('layouts.master')
@section('title', 'Rekap Kegiatan Praktikum')

@section('content')

{{-- WRAPPER KHUSUS REKAP (TANPA SENTUH MASTER) --}}
<div style="
    mmargin-left: 260px;
    padding: 32px 40px;
    padding-top: 96px;
    box-sizing: border-box;
    background-color: #f8fafc;
    min-height: 100vh;
">

    {{-- HEADER --}}
    <div class="dashboard-header" style="margin-bottom: 32px;">
        <h1 style="font-size: 1.8rem; font-weight: 700;">Rekap Kegiatan Praktikum</h1>
        <p style="color: var(--muted);">Unduh rekap kegiatan praktikum maksimal 1 bulan.</p>
    </div>

    {{-- FORM PILIH BULAN --}}
    <div class="card" style="max-width:400px; margin-bottom:20px;">
        <form method="POST" action="{{ route('rekap-praktikum.preview') }}">
            @csrf
            <label>Pilih Bulan</label>
            <input type="month" name="bulan" required>
            <button type="submit">Tampilkan Rekap</button>
        </form>
    </div>

    {{-- REKAP PRAKTIKUM --}}
    @if(isset($jadwal))
    <div class="card" style="margin-bottom:20px;">
        <h4>Rekap Kegiatan Praktikum ({{ $bulan }})</h4>

        <div style="overflow-x:auto;">
            <table border="1" width="100%" cellpadding="6">
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Peminjam</th>
                </tr>
                @foreach($jadwal as $i => $j)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $j->kegiatan }}</td>
                    <td>{{ \Carbon\Carbon::parse($j->tanggal)->format('d/m/Y') }}</td>
                    <td>{{ $j->waktu_mulai }} - {{ $j->waktu_selesai }}</td>
                    <td>{{ $j->user->name ?? '-' }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endif

    {{-- REKAP INVENTARIS --}}
@if(isset($peminjamanInventaris) && $peminjamanInventaris->count())
<div class="card">
    <h4>Rekap Inventaris</h4>

    <div style="overflow-x:auto;">
        <table border="1" width="100%" cellpadding="6">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nama Barang</th>
                    <th>Jumlah Dipinjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($peminjamanInventaris as $i => $item)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->inventaris->nama_barang ?? '-' }}</td>
                    <td style="text-align:center;">
                        {{ $item->jumlah }}
                    </td>

                    <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
                    <td>
                        {{ $item->tanggal_kembali
                            ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y')
                            : '-' }}
                    </td>
                    <td>{{ ucfirst($item->status) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- DOWNLOAD --}}
    <form method="POST" action="{{ route('rekap-praktikum.download') }}" style="margin-top:12px;">
        @csrf
        <input type="hidden" name="bulan" value="{{ request('bulan') }}">
        <button type="submit">Download PDF</button>
    </form>
</div>
@endif


</div>
@endsection
