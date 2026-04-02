@extends('layouts.master')
@section('title', 'Inventaris Alat dan Bahan')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Inventaris Alat dan Bahan</h1>
        <p style="color: var(--muted);">Daftar alat dan bahan yang tersedia di Laboratorium.</p>
    </div>
    @if(auth()->user()->role === 'admin')
    <div>
        <a href="{{ route('inventaris.create') }}" class="btn btn-primary" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-weight: 500; cursor: pointer; text-decoration: none;">
            Tambah Inventaris
        </a>
    </div>
    @endif
</div>



<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    @if($inventaris->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; border: 1px solid #000;">
            <thead>
                <tr style="background-color: #f3f4f6;">
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">No</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Kode</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Nama Alat dan Bahan</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Lokasi</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Jumlah Total</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Jumlah Tersedia</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Kondisi</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Keterangan</th>
                    <th style="padding: 1rem; text-align: center; color: var(--text); font-weight: 600; border: 1px solid #000;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($inventaris as $index => $item)
                <tr style="border-bottom: 1px solid #000;">
    {{-- No --}}
    <td style="padding: 1rem; text-align: center; border: 1px solid #000;">
        {{ $inventaris->firstItem() + $index }}
    </td>

    {{-- Kode --}}
    <td style="padding:1rem; text-align:center; border:1px solid #000;">
        {{ $item->kode_barang }}
    </td>

    {{-- Nama --}}
    <td style="padding: 1rem; text-align: center; border: 1px solid #000;">
        {{ $item->nama_barang }}
    </td>

    {{-- Lokasi --}}
    <td style="padding:1rem; text-align:center; border:1px solid #000;">
        {{ $item->lokasi }}
    </td>

    {{-- Jumlah Total --}}
    <td style="padding: 1rem; text-align: center; border: 1px solid #000;">
        {{ $item->jumlah_total }}
    </td>

    {{-- Jumlah Tersedia --}}
    <td id="jumlah-tersedia-{{ $item->id }}"
        style="padding: 1rem; text-align: center; border: 1px solid #000;">
        {{ $item->jumlah_tersedia }}
    </td>

    {{-- Kondisi --}}
    <td style="padding: 1rem; text-align: center; border: 1px solid #000;">
        @if(auth()->user()->role === 'admin')
            <select onchange="updateKondisi({{ $item->id }}, this.value)">
                <option value="baik" {{ $item->kondisi === 'baik' ? 'selected' : '' }}>Baik</option>
                <option value="rusak" {{ $item->kondisi === 'rusak' ? 'selected' : '' }}>Rusak</option>
                <option value="habis" {{ $item->kondisi === 'habis' ? 'selected' : '' }}>Habis</option>
            </select>
        @else
            {{ ucfirst($item->kondisi) }}
        @endif
    </td>

    {{-- Keterangan --}}
    <td style="padding:1rem; text-align:center; border:1px solid #000;">
        {{ $item->keterangan }}
    </td>

    {{-- Aksi --}}
   <td style="padding: 1rem; text-align: center; border: 1px solid #000;">
    @if(auth()->user()->role === 'admin')
        <div style="display:flex; justify-content:center; gap:14px;">
            {{-- Edit --}}
            <a href="{{ route('inventaris.edit', $item->id) }}"
               title="Edit"
               style="color:#2563eb; font-size:18px; text-decoration:none;">
                <i class="fas fa-pen-to-square"></i>
            </a>

            {{-- Hapus --}}
            <button type="button"
                onclick="confirmDelete({{ $item->id }})"
                title="Hapus"
                style="background:none; border:none; color:#dc2626; font-size:18px; cursor:pointer;">
                <i class="fas fa-trash-can"></i>
            </button>

            <form id="delete-form-{{ $item->id }}"
                action="{{ route('inventaris.destroy', $item->id) }}"
                method="POST"
                style="display:none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    @else
        @if($item->kondisi === 'baik' && $item->jumlah_tersedia > 0)
            <button
                onclick="openPinjamModal(
                    {{ $item->id }},
                    '{{ $item->nama_barang }}',
                    {{ $item->jumlah_tersedia }}
                )"
                style="background:var(--primary); color:white; border:none; padding:6px 10px; border-radius:4px;">
                Pinjam
            </button>
        @else
            <span style="color:#999;">Tidak Tersedia</span>
        @endif
    @endif
</td>

</tr>

                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
        {{ $inventaris->links('pagination::bootstrap-4') }}
    </div>
    @else
    <p style="text-align: center; color: var(--muted); padding: 2rem;">Data inventaris belum tersedia.</p>
    @endif
</div>

{{-- Modal Peminjaman --}}
<div id="pinjamModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; justify-content: center; align-items: center;">
   <div style="
    background: white;
    border-radius: 12px;
    padding: 2rem;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    position: relative;
">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text);">Pinjam Barang</h2>
            <button onclick="closePinjamModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--muted);">&times;</button>
        </div>

        <form action="{{ route('peminjaman-inventaris.store') }}" method="POST">
            @csrf
            <input type="hidden" name="inventaris_id" id="pinjam_inventaris_id">
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Nama Barang</label>
                <input type="text" id="pinjam_nama_barang" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; background: #f3f4f6;" readonly>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Jumlah (Maks: <span id="pinjam_max_qty">0</span>)</label>
                <input type="number" name="jumlah" id="pinjam_jumlah" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" min="1" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal Pinjam</label>
                <input type="date" name="tanggal_pinjam" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Tanggal Kembali (Rencana)</label>
                <input type="date" name="tanggal_kembali" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" min="{{ date('Y-m-d') }}">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500;">Keterangan / Keperluan</label>
                <textarea name="keterangan" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px;" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem; background: var(--primary); color: white; border: none; border-radius: 6px; font-weight: 600; cursor: pointer;">
                Ajukan Peminjaman
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openPinjamModal(id, name, maxQty) {
        document.getElementById('pinjam_inventaris_id').value = id;
        document.getElementById('pinjam_nama_barang').value = name;
        document.getElementById('pinjam_max_qty').textContent = maxQty;
        document.getElementById('pinjam_jumlah').max = maxQty;
        document.getElementById('pinjamModal').style.display = 'flex';
    }

    function closePinjamModal() {
        document.getElementById('pinjamModal').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('pinjamModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePinjamModal();
        }
    });
    function confirmDelete(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }

    function updateKondisi(id, kondisi) {
        fetch(`/inventaris/${id}/kondisi`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ kondisi: kondisi })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update jumlah tersedia
                if (document.getElementById(`jumlah-tersedia-${id}`)) {
                    document.getElementById(`jumlah-tersedia-${id}`).textContent = data.jumlah_tersedia;
                }
                
                // Show success toast
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
                
                Toast.fire({
                    icon: 'success',
                    title: data.message
                });
            } else {
                Swal.fire('Error', data.message || 'Gagal memperbarui kondisi', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
        });
    }
</script>
@endpush
@endsection
