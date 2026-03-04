<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Praktikum</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 10px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
        }
        th {
            background: #f3f4f6;
        }
    </style>
</head>
<body>

<h2>REKAP KEGIATAN PRAKTIKUM</h2>
<p style="text-align:center;">Bulan: {{ $bulan }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Kegiatan</th>
            <th>Nama Dosen</th>
            <th>Tanggal</th>
            <th>Waktu</th>
            <th>Peminjam</th>
        </tr>
    </thead>
    <tbody>
        @forelse($jadwal as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->kegiatan }}</td>
            <td>{{ $item->nama_dosen }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
            <td>{{ substr($item->waktu_mulai,0,5) }} - {{ substr($item->waktu_selesai,0,5) }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="6">Tidak ada kegiatan</td>
        </tr>
        @endforelse
    </tbody>
</table>
<hr style="margin: 25px 0;">

<h3>REKAP PEMINJAMAN ALAT & BAHAN</h3>
<p>Per tanggal cetak: {{ $tanggalCetak }}</p>

<table>
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
        @forelse($peminjamanInventaris as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->inventaris->nama_barang ?? '-' }}</td>
            <td>{{ $item->jumlah }}</td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }}</td>
            <td>
                {{ $item->tanggal_kembali
                    ? \Carbon\Carbon::parse($item->tanggal_kembali)->format('d/m/Y')
                    : '-' }}
            </td>
            <td>{{ ucfirst($item->status) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="7">Tidak ada peminjaman inventaris</td>
        </tr>
        @endforelse
    </tbody>
</table>



</body>
</html>
