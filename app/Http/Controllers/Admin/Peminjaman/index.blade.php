@extends('layouts.app')

@section('title', 'Manajemen Peminjaman')

@section('content')
<div class="dashboard-header">
    <h1><i class="fas fa-handshake"></i> Manajemen Peminjaman</h1>
    <p>Kelola semua peminjaman alat dan bahan laboratorium</p>
</div>

<div class="row">
    <!-- Stats Cards -->
    <div class="col-12">
        <div class="stats-grid">
            <div class="card stat-card">
                <div class="stat-number">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Peminjaman</div>
                <div class="stat-icon">
                    <i class="fas fa-list"></i>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-number">{{ $stats['menunggu'] }}</div>
                <div class="stat-label">Menunggu</div>
                <div class="stat-icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-number">{{ $stats['disetujui'] }}</div>
                <div class="stat-label">Disetujui</div>
                <div class="stat-icon">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-number">{{ $stats['selesai'] }}</div>
                <div class="stat-label">Selesai</div>
                <div class="stat-icon">
                    <i class="fas fa-check-double"></i>
                </div>
            </div>
            
            <div class="card stat-card">
                <div class="stat-number">{{ $stats['ditolak'] }}</div>
                <div class="stat-label">Ditolak</div>
                <div class="stat-icon">
                    <i class="fas fa-times"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-table"></i> Daftar Semua Peminjaman
        </h3>
        <div class="header-actions">
            <button class="btn btn-secondary" onclick="exportPeminjaman()">
                <i class="fas fa-download"></i> Export
            </button>
            <button class="btn btn-primary" onclick="refreshTable()">
                <i class="fas fa-sync"></i> Refresh
            </button>
        </div>
    </div>
    
    <div class="card-body">
        <!-- Filter Section -->
        <div class="filter-section mb-4">
            <form method="GET" action="" class="row g-3" id="filterForm">
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="disetujui" {{ request('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Jenis</label>
                    <select name="jenis" class="form-control">
                        <option value="">Semua Jenis</option>
                        <option value="alat" {{ request('jenis') == 'alat' ? 'selected' : '' }}>Alat</option>
                        <option value="bahan" {{ request('jenis') == 'bahan' ? 'selected' : '' }}>Bahan</option>
                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">User</label>
                    <select name="user_id" class="form-control">
                        <option value="">Semua User</option>
                        @isset($users)
    @foreach($users as $user)
        <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->name }} ({{ $user->nim_nip }})
        </option>
    @endforeach
@endisset

                    </select>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Hingga Tanggal</label>
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <button type="button" class="btn btn-secondary w-100" onclick="resetFilter()">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </form>
        </div>

        @if($peminjamans->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>User</th>
                            <th>Item</th>
                            <th>Jumlah</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($peminjamans as $peminjaman)
                        <tr class="{{ $peminjaman->status == 'menunggu' ? 'table-warning' : 
                                     ($peminjaman->status == 'disetujui' ? 'table-success' : 
                                     ($peminjaman->status == 'ditolak' ? 'table-danger' : 'table-info')) }}">
                            <td>
                                <strong>{{ $peminjaman->kode_peminjaman }}</strong>
                                <br>
                                <small class="text-muted">
                                    {{ $peminjaman->jenis == 'alat' ? 'Alat' : 'Bahan' }}
                                </small>
                            </td>
                            <td>
                                <strong>{{ $peminjaman->user->name }}</strong>
                                <br>
                                <small class="text-muted">{{ $peminjaman->user->nim_nip }}</small>
                            </td>
                            <td>
                                @if($peminjaman->jenis == 'alat' && $peminjaman->alat)
                                    {{ $peminjaman->alat->nama_alat }}
                                    <br>
                                    <small class="text-muted">{{ $peminjaman->alat->kode_alat }}</small>
                                @elseif($peminjaman->jenis == 'bahan' && $peminjaman->bahan)
                                    {{ $peminjaman->bahan->nama_bahan }}
                                    <br>
                                    <small class="text-muted">{{ $peminjaman->bahan->kode_bahan }}</small>
                                @else
                                    <span class="text-danger">Item tidak ditemukan</span>
                                @endif
                            </td>
                            <td>
                                {{ $peminjaman->jumlah }}
                                @if($peminjaman->jenis == 'bahan' && $peminjaman->bahan)
                                    {{ $peminjaman->bahan->satuan }}
                                @endif
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d/m/Y') }}
                                <br>
                                <small class="text-muted">
                                    sampai {{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d/m/Y') }}
                                </small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($peminjaman->status == 'menunggu')
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock"></i> Menunggu
                                        </span>
                                    @elseif($peminjaman->status == 'disetujui')
                                        <span class="badge bg-success">
                                            <i class="fas fa-check"></i> Disetujui
                                        </span>
                                    @elseif($peminjaman->status == 'ditolak')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times"></i> Ditolak
                                        </span>
                                    @else
                                        <span class="badge bg-info">
                                            <i class="fas fa-check-double"></i> Selesai
                                        </span>
                                    @endif
                                    
                                    @if($peminjaman->tanggal_kembali < now() && $peminjaman->status == 'disetujui')
                                        <span class="badge bg-danger" title="Terlambat">
                                            <i class="fas fa-exclamation-triangle"></i> Terlambat
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-info" 
                                            onclick="showPeminjamanDetail({{ $peminjaman->id }})"
                                            title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    
                                    @if($peminjaman->status == 'menunggu')
                                        <button class="btn btn-sm btn-success" 
                                                onclick="approvePeminjaman({{ $peminjaman->id }})"
                                                title="Setujui">
                                            <i class="fas fa-check"></i>
                                        </button>
                                        
                                        <button class="btn btn-sm btn-danger" 
                                                onclick="rejectPeminjaman({{ $peminjaman->id }})"
                                                title="Tolak">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                    
                                    @if($peminjaman->status == 'disetujui')
                                        <button class="btn btn-sm btn-primary" 
                                                onclick="completePeminjaman({{ $peminjaman->id }})"
                                                title="Tandai Selesai">
                                            <i class="fas fa-check-double"></i>
                                        </button>
                                    @endif
                                    
                                    <button class="btn btn-sm btn-warning" 
                                            onclick="editPeminjaman({{ $peminjaman->id }})"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $peminjamans->firstItem() }} - {{ $peminjamans->lastItem() }} dari {{ $peminjamans->total() }} peminjaman
                </div>
                <div>
                    {{ $peminjamans->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">Tidak ada peminjaman</h4>
                <p class="text-muted">Tidak ada data peminjaman yang sesuai dengan filter</p>
                <button class="btn btn-primary mt-3" onclick="resetFilter()">
                    <i class="fas fa-redo"></i> Reset Filter
                </button>
            </div>
        @endif
    </div>
</div>

<!-- Quick Stats -->
<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Distribusi Status
                </h3>
            </div>
            <div class="card-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-bar"></i> Peminjaman per Bulan
                </h3>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Peminjaman -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <!-- Content akan diisi via JavaScript -->
            </div>
        </div>
    </div>
</div>

<!-- Modal Approve -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Setujui Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="approveForm">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menyetujui peminjaman ini?</p>
                    <div class="form-group">
                        <label class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" name="catatan" rows="3" 
                                  placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Reject -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tolak Peminjaman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="rejectForm">
                @csrf
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menolak peminjaman ini?</p>
                    <div class="form-group">
                        <label class="form-label required">Alasan Penolakan</label>
                        <textarea class="form-control" name="catatan" rows="3" required
                                  placeholder="Berikan alasan penolakan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Tolak</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }
    
    .stat-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.3s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #1e3a8a;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 0.9rem;
        margin-top: 0.5rem;
    }
    
    .stat-icon {
        margin-top: 1rem;
        font-size: 2rem;
        color: #60a5fa;
    }
    
    .filter-section {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
    }
    
    .table-dark th {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }
    
    .table-hover tbody tr:hover {
        transform: scale(1.01);
        transition: transform 0.2s;
    }
    
    .header-actions {
        display: flex;
        gap: 10px;
    }
    
    .table-warning {
        background-color: rgba(255, 193, 7, 0.1);
    }
    
    .table-success {
        background-color: rgba(40, 167, 69, 0.1);
    }
    
    .table-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .table-info {
        background-color: rgba(23, 162, 184, 0.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    let currentPeminjamanId = null;
    
    // Tampilkan detail peminjaman
    function showPeminjamanDetail(id) {
        $.ajax({
            url: `/admin/peminjaman/${id}`,
            method: 'GET',
            success: function(response) {
                const data = response.data;
                let itemInfo = '';
                
                if (data.jenis === 'alat' && data.alat) {
                    itemInfo = `
                        <strong>Alat:</strong> ${data.alat.nama_alat}<br>
                        <strong>Kode:</strong> ${data.alat.kode_alat}<br>
                        <strong>Kondisi:</strong> ${data.alat.kondisi}<br>
                        <strong>Tersedia:</strong> ${data.alat.jumlah} unit
                    `;
                } else if (data.jenis === 'bahan' && data.bahan) {
                    itemInfo = `
                        <strong>Bahan:</strong> ${data.bahan.nama_bahan}<br>
                        <strong>Kode:</strong> ${data.bahan.kode_bahan}<br>
                        <strong>Satuan:</strong> ${data.bahan.satuan}<br>
                        <strong>Stok:</strong> ${data.bahan.stok} ${data.bahan.satuan}
                    `;
                }
                
                const modalContent = `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Kode Peminjaman:</strong><br>
                                <span class="badge bg-primary fs-6">${data.kode_peminjaman}</span>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Peminjam:</strong><br>
                                <strong>${data.user.name}</strong><br>
                                <small>${data.user.nim_nip} | ${data.user.email}</small>
                            </div>
                            
                            <div class="mb-3">
                                <strong>Jenis:</strong><br>
                                ${data.jenis === 'alat' ? 'Alat' : 'Bahan'}
                            </div>
                            
                            <div class="mb-3">
                                <strong>Status:</strong><br>
                                ${getStatusBadge(data.status)}
                                ${data.tanggal_kembali < new Date().toISOString().split('T')[0] && data.status === 'disetujui' 
                                    ? '<span class="badge bg-danger ms-2">Terlambat</span>' 
                                    : ''}
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>Tanggal Pinjam:</strong><br>
                                ${new Date(data.tanggal_pinjam).toLocaleDateString('id-ID')}
                            </div>
                            
                            <div class="mb-3">
                                <strong>Tanggal Kembali:</strong><br>
                                ${new Date(data.tanggal_kembali).toLocaleDateString('id-ID')}
                            </div>
                            
                            <div class="mb-3">
                                <strong>Jumlah:</strong><br>
                                ${data.jumlah} ${data.jenis === 'bahan' && data.bahan ? data.bahan.satuan : 'unit'}
                            </div>
                            
                            <div class="mb-3">
                                <strong>Dibuat:</strong><br>
                                ${new Date(data.created_at).toLocaleDateString('id-ID')}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Detail Item:</strong><br>
                            <div class="border rounded p-3 mt-2 bg-light">
                                ${itemInfo}
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Tujuan Peminjaman:</strong><br>
                            <div class="border rounded p-3 mt-2">
                                ${data.tujuan}
                            </div>
                        </div>
                    </div>
                    
                    ${data.catatan_admin ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <strong>Catatan Admin:</strong><br>
                            <div class="border rounded p-3 mt-2 bg-warning bg-opacity-10">
                                ${data.catatan_admin}
                            </div>
                        </div>
                    </div>
                    ` : ''}
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                ${data.status === 'menunggu' ? `
                                <button class="btn btn-success" onclick="approvePeminjaman(${data.id})">
                                    <i class="fas fa-check"></i> Setujui
                                </button>
                                <button class="btn btn-danger" onclick="rejectPeminjaman(${data.id})">
                                    <i class="fas fa-times"></i> Tolak
                                </button>
                                ` : ''}
                                
                                ${data.status === 'disetujui' ? `
                                <button class="btn btn-primary" onclick="completePeminjaman(${data.id})">
                                    <i class="fas fa-check-double"></i> Tandai Selesai
                                </button>
                                ` : ''}
                                
                                <button class="btn btn-warning" onclick="editPeminjaman(${data.id})">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                
                $('#detailContent').html(modalContent);
                $('#detailModal').modal('show');
            },
            error: function() {
                alert('Gagal mengambil data peminjaman');
            }
        });
    }
    
    function getStatusBadge(status) {
        const badges = {
            'menunggu': '<span class="badge bg-warning fs-6">Menunggu</span>',
            'disetujui': '<span class="badge bg-success fs-6">Disetujui</span>',
            'ditolak': '<span class="badge bg-danger fs-6">Ditolak</span>',
            'selesai': '<span class="badge bg-info fs-6">Selesai</span>'
        };
        return badges[status] || '<span class="badge bg-secondary fs-6">' + status + '</span>';
    }
    
    // Setujui peminjaman
    function approvePeminjaman(id) {
        currentPeminjamanId = id;
        $('#approveModal').modal('show');
    }
    
    $('#approveForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        $.ajax({
            url: `/admin/peminjaman/${currentPeminjamanId}/approve`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#approveModal').modal('hide');
                    showToast('success', 'Peminjaman berhasil disetujui!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert(response.message || 'Gagal menyetujui peminjaman');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menyetujui peminjaman');
            }
        });
    });
    
    // Tolak peminjaman
    function rejectPeminjaman(id) {
        currentPeminjamanId = id;
        $('#rejectModal').modal('show');
    }
    
    $('#rejectForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('_method', 'PUT');
        
        $.ajax({
            url: `/admin/peminjaman/${currentPeminjamanId}/reject`,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    $('#rejectModal').modal('hide');
                    showToast('success', 'Peminjaman berhasil ditolak!');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    alert(response.message || 'Gagal menolak peminjaman');
                }
            },
            error: function() {
                alert('Terjadi kesalahan saat menolak peminjaman');
            }
        });
    });
    
    // Tandai selesai
    function completePeminjaman(id) {
        if (confirm('Apakah Anda yakin ingin menandai peminjaman ini sebagai selesai?\n\nItem akan dikembalikan ke stok.')) {
            $.ajax({
                url: `/admin/peminjaman/${id}/complete`,
                method: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'PUT'
                },
                success: function(response) {
                    if (response.success) {
                        showToast('success', 'Peminjaman berhasil ditandai selesai!');
                        setTimeout(() => location.reload(), 1500);
                    } else {
                        alert(response.message || 'Gagal menandai selesai');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan');
                }
            });
        }
    }
    
    // Edit peminjaman
    function editPeminjaman(id) {
        window.location.href = `/admin/peminjaman/${id}/edit`;
    }
    
    // Export data
    function exportPeminjaman() {
        const params = new URLSearchParams(window.location.search);
        window.open(`/admin/peminjaman/export?${params.toString()}`, '_blank');
    }
    
    // Refresh table
    function refreshTable() {
        location.reload();
    }
    
    // Reset filter
    function resetFilter() {
        window.location.href = '{{ route("admin.peminjaman.index") }}';
    }
    
    // Chart.js initialization
    $(document).ready(function() {
        // Status Distribution Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'pie',
            data: {
                labels: ['Menunggu', 'Disetujui', 'Selesai', 'Ditolak'],
                datasets: [{
                    data: [
                        {{ $stats['menunggu'] }},
                        {{ $stats['disetujui'] }},
                        {{ $stats['selesai'] }},
                        {{ $stats['ditolak'] }}
                    ],
                    backgroundColor: [
                        '#ffc107',
                        '#28a745',
                        '#17a2b8',
                        '#dc3545'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        
        // Monthly Chart
        const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($monthlyStats['labels'] ?? []) !!},
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: {!! json_encode($monthlyStats['data'] ?? []) !!},
                    backgroundColor: '#1e3a8a'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    });
    
    // Toast notification
    function showToast(type, message) {
        const toast = $(`
            <div class="toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
        
        $('body').append(toast);
        const bsToast = new bootstrap.Toast(toast[0]);
        bsToast.show();
        
        setTimeout(() => toast.remove(), 3000);
    }
    
    // Auto-submit filter dengan delay
    let filterTimeout;
    $('.filter-section input, .filter-section select').on('change', function() {
        clearTimeout(filterTimeout);
        filterTimeout = setTimeout(() => {
            $('#filterForm').submit();
        }, 1000);
    });
</script>
@endpush
@endsection