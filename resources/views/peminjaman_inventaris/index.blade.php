@extends('layouts.master')

@section('title', 'Daftar Peminjaman Barang')

@section('content')

@if (session('success'))
<div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

@if (session('error'))
<div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
    {{ session('error') }}
</div>
@endif

<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div style="margin-bottom: 1.5rem; border-bottom: 1px solid #e5e7eb; padding-bottom: 1rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text);">Status Peminjaman</h2>
    </div>

    @if($peminjaman->isEmpty())
        <p style="text-align: center; color: var(--muted); padding: 2rem;">Tidak ada data peminjaman.</p>
    @else
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">No</th>
                        @if(auth()->user()->role === 'admin')
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Nama Peminjam</th>
                        @endif
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Barang</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Jumlah</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Tgl Pinjam</th>
                        <th style="padding: 1rem; font-weight: 600; color: var(--text);">Status</th>
                        @if(auth()->user()->role === 'admin')
                        <th style="padding: 1rem; font-weight: 600; color: var(--text); text-align: right;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($peminjaman as $item)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem; color: var(--text);">{{ $loop->iteration }}</td>
                        @if(auth()->user()->role === 'admin')
                        <td style="padding: 1rem; color: var(--text);">{{ $item->user->name ?? 'User Hapus' }}</td>
                        @endif
                        <td style="padding: 1rem; color: var(--text);">{{ $item->inventaris->nama_barang ?? 'Barang Hapus' }}</td>
                        <td style="padding: 1rem; color: var(--text);">{{ $item->jumlah }}</td>
                        <td style="padding: 1rem; color: var(--muted);">{{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') }}</td>
                        <td style="padding: 1rem;">
                            @if($item->status == 'pending')
                                <span style="background: #fef3c7; color: #d97706; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Menunggu</span>
                            @elseif($item->status == 'approved')
                                <span style="background: #d1fae5; color: #059669; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Dipinjam</span>
                            @elseif($item->status == 'returned')
                                <span style="background: #dbeafe; color: #2563eb; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Dikembalikan</span>
                            @elseif($item->status == 'rejected')
                                <span style="background: #fee2e2; color: #dc2626; padding: 4px 8px; border-radius: 4px; font-size: 0.8rem;">Ditolak</span>
                            @endif
                        </td>
                        @if(auth()->user()->role === 'admin')
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                @if($item->status == 'pending')
                                    <form action="{{ route('peminjaman-inventaris.approve', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Setujui peminjaman ini?')" style="background: #10b981; color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">Setujui</button>
                                    </form>
                                    <form action="{{ route('peminjaman-inventaris.reject', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Tolak peminjaman ini?')" style="background: #ef4444; color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">Tolak</button>
                                    </form>
                                @elseif($item->status == 'approved')
                                    <form action="{{ route('peminjaman-inventaris.return', $item->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" onclick="return confirm('Tandai barang sudah dikembalikan?')" style="background: #3b82f6; color: white; border: none; padding: 4px 12px; border-radius: 4px; cursor: pointer; font-size: 0.875rem;">Kembalikan</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
       @if ($peminjaman->hasPages())
    <ul class="pagination">
        
        @if ($peminjaman->onFirstPage())
            <li><span>&lsaquo;</span></li>
        @else
            <li>
                <a href="{{ $peminjaman->previousPageUrl() }}">&lsaquo;</a>
            </li>
        @endif

        @for ($i = 1; $i <= $peminjaman->lastPage(); $i++)
            @if ($i == $peminjaman->currentPage())
                <li class="active"><span>{{ $i }}</span></li>
            @else
                <li>
                    <a href="{{ $peminjaman->url($i) }}">{{ $i }}</a>
                </li>
            @endif
        @endfor

        @if ($peminjaman->hasMorePages())
            <li>
                <a href="{{ $peminjaman->nextPageUrl() }}">&rsaquo;</a>
            </li>
        @else
            <li><span>&rsaquo;</span></li>
        @endif

    </ul>
@endif
    @endif
</div>
@endsection
