@extends('layouts.master')
@section('title', 'Dashboard Laboratorium')

@push('styles')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<style>
    .fc-event {
        cursor: pointer;
        background-color: var(--primary);
        border-color: var(--primary);
    }
    .fc-toolbar-title {
        font-size: 1.25rem !important;
    }
    .fc-button {
        font-size: 0.875rem !important;
    }
    
    .calendar-wrapper {
        display: grid;
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (min-width: 1024px) {
        .calendar-wrapper {
            grid-template-columns: 1fr 350px;
        }
    }
    @media (max-width: 1023px) {
        .calendar-wrapper {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px;">
    <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Dashboard Laboratorium</h1>
    <p style="color: var(--muted);">Selamat datang di Sistem Informasi Peminjaman Laboratorium MIPA.</p>
</div>

<!-- Welcome Card -->
<div class="card" style="margin-bottom: 32px; border-left: 5px solid var(--primary);">
    <div style="display: flex; align-items: center; gap: 20px;">
        <div class="avatar-placeholder" style="width: 64px; height: 64px; background: var(--panel-2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary); font-size: 1.5rem; font-weight: 700;">
            {{ substr(auth()->user()->name, 0, 1) }}
        </div>
        <div>
            <h2 style="font-size: 1.25rem; margin: 0 0 4px;">Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p style="margin: 0; color: var(--muted);">
                Role: <span style="text-transform: capitalize; font-weight: 600;">{{ auth()->user()->role }}</span>
            </p>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <!-- Total Peminjaman -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #eff6ff; color: #3b82f6; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <span style="color: var(--muted); font-weight: 500;">Total Peminjaman</span>
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">{{ $totalPeminjaman }}</div>
        <div style="font-size: 0.875rem; color: var(--muted); margin-top: 4px;">Seluruh Waktu</div>
    </div>

    <!-- Total Alat -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #f0f9ff; color: #0ea5e9; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-flask"></i>
            </div>
            <span style="color: var(--muted); font-weight: 500;">Total Alat</span>
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">{{ $totalAlat }}</div>
        <div style="font-size: 0.875rem; color: var(--muted); margin-top: 4px;">Inventaris Lab</div>
    </div>

    <!-- Total Pengguna -->
    <div class="card">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #dcfce7; color: #16a34a; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-users"></i>
            </div>
            <span style="color: var(--muted); font-weight: 500;">Total Pengguna</span>
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">{{ $totalUser }}</div>
        <div style="font-size: 0.875rem; color: var(--muted); margin-top: 4px;">Terdaftar</div>
    </div>

    @if(auth()->user()->role === 'admin')
    <!-- Pending Requests (Admin Only) -->
    <div class="card" style="border: 1px solid {{ $pendingRequests > 0 ? '#fca5a5' : 'transparent' }};">
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 12px;">
            <div style="width: 40px; height: 40px; background: #fef2f2; color: #ef4444; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-clock"></i>
            </div>
            <span style="color: var(--muted); font-weight: 500;">Menunggu Persetujuan</span>
        </div>
        <div style="font-size: 1.5rem; font-weight: 700;">{{ $pendingRequests }}</div>
        <div style="font-size: 0.875rem; color: var(--muted); margin-top: 4px;">
            @if($pendingRequests > 0)
                <a href="{{ route('peminjaman.index') }}" style="color: #ef4444; text-decoration: none; font-weight: 600;">Lihat Pengajuan &rarr;</a>
            @else
                Tidak ada pengajuan baru
            @endif
        </div>
    </div>
    @endif
</div>

<div class="calendar-wrapper">
    <!-- Calendar Section -->
    <div class="card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
            <i class="fa-regular fa-calendar-days" style="color: var(--primary);"></i>
            Jadwal Pemakaian Laboratorium
        </h3>
        <div id="calendar" style="min-height: 500px;"></div>
    </div>

    <!-- Side Panel -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Quick Actions -->
        <div class="card">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 16px;">Aksi Cepat</h3>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <a href="{{ route('peminjaman.create') }}" class="btn btn-primary" style="background: var(--primary); color: white; text-decoration: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; justify-content: center;">
                    <i class="fa-solid fa-plus"></i>
                    Buat Peminjaman
                </a>
                @if(auth()->user()->role === 'admin')
                <a href="{{ route('users.index') }}" class="btn btn-outline" style="border: 1px solid var(--border); color: var(--text); text-decoration: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; justify-content: center;">
                    <i class="fa-solid fa-user-gear"></i>
                    Kelola Pengguna
                </a>
                <a href="{{ route('inventaris.index') }}" class="btn btn-outline" style="border: 1px solid var(--border); color: var(--text); text-decoration: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; justify-content: center;">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    Kelola Inventaris
                </a>
                @endif
                 <a href="{{ route('jadwal.index') }}" class="btn btn-outline" style="border: 1px solid var(--border); color: var(--text); text-decoration: none; padding: 10px 20px; border-radius: 8px; display: flex; align-items: center; gap: 10px; justify-content: center;">
                    <i class="fa-solid fa-list"></i>
                    Lihat Semua Jadwal
                </a>
            </div>
        </div>

        <!-- Upcoming List -->
        <div class="card">
            <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 16px;">Jadwal Terdekat</h3>
            @if($upcomingSchedules->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($upcomingSchedules as $schedule)
                    <div style="padding: 12px; border-radius: 8px; background: var(--bg); border-left: 3px solid var(--primary);">
                        <div style="font-weight: 600; font-size: 0.9rem;">{{ $schedule->kegiatan }}</div>
                        <div style="font-size: 0.8rem; color: var(--muted); margin-top: 4px;">
                            <i class="fa-regular fa-clock"></i> 
                            {{ \Carbon\Carbon::parse($schedule->tanggal)->format('d M') }}, {{ substr($schedule->waktu_mulai, 0, 5) }} - {{ substr($schedule->waktu_selesai, 0, 5) }}
                        </div>
                        <div style="font-size: 0.8rem; color: var(--muted);">
                            <i class="fa-regular fa-user"></i> {{ $schedule->user->name ?? 'Pengguna Tidak Dikenal' }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p style="color: var(--muted); font-size: 0.9rem; text-align: center;">Tidak ada jadwal dalam waktu dekat.</p>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            locale: 'id',
            buttonText: {
                today: 'Hari Ini',
                month: 'Bulan',
                week: 'Minggu',
                day: 'Hari',
                list: 'List'
            },
            events: @json($events),
            eventClick: function(info) {
                // Parse dates for better display
                const startDate = new Date(info.event.start);
                const endDate = info.event.end ? new Date(info.event.end) : null;
                
                const dateStr = startDate.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                const timeStartStr = startDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                const timeEndStr = endDate ? endDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '-';

                Swal.fire({
                    title: info.event.title,
                    html: `
                        <div style="text-align: left; margin-top: 10px;">
                            <p style="margin-bottom: 5px;"><i class="fa-regular fa-calendar" style="width: 20px;"></i> <strong>Tanggal:</strong> ${dateStr}</p>
                            <p style="margin-bottom: 5px;"><i class="fa-regular fa-clock" style="width: 20px;"></i> <strong>Waktu:</strong> ${timeStartStr} - ${timeEndStr}</p>
                            <p style="margin-bottom: 5px;"><i class="fa-regular fa-user" style="width: 20px;"></i> <strong>Peminjam:</strong> ${info.event.extendedProps.user}</p>
                        </div>
                    `,
                    icon: 'info',
                    confirmButtonText: 'Tutup'
                });
            }
        });
        calendar.render();
    });
</script>
@endpush
