@extends('layouts.master')
@section('title', 'Jadwal Pratikum')

@section('content')
<div class="dashboard-header" style="margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.8rem; font-weight: 700; color: var(--text);">Jadwal Pratikum</h1>
        <p style="color: var(--muted);">Jadwal penggunaan Laboratorium MIPA.</p>
    </div>
    <div style="display: flex; gap: 10px;">
        @if(auth()->user()->role === 'admin')
        <a href="{{ route('peminjaman.index') }}" class="btn btn-secondary" style="background: #6c757d; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500;">
            Pengajuan Masuk
        </a>
        <button onclick="openModal()" class="btn btn-primary" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; border: none; font-weight: 500; cursor: pointer;">
            Tambah Jadwal
        </button>
        @endif
        
        @if(auth()->user()->role === 'user')
        <a href="{{ route('peminjaman.create') }}" class="btn btn-primary" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: 500;">
            Ajukan Peminjaman
        </a>
        @endif
    </div>
</div>

@if(session('success'))
<div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
    {{ session('success') }}
</div>
@endif

@php \Carbon\Carbon::setLocale('id'); $today = \Carbon\Carbon::today(); @endphp

{{-- Calendar View --}}
<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text);">Kalender Mingguan</h2>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('jadwal.index', ['date' => $startOfWeek->copy()->subWeek()->format('Y-m-d')]) }}" style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 6px; text-decoration: none; color: var(--text);">&lt;</a>
            <span style="font-weight: 500;">{{ $startOfWeek->isoFormat('D MMM') }} - {{ $endOfWeek->isoFormat('D MMM Y') }}</span>
            <a href="{{ route('jadwal.index', ['date' => $startOfWeek->copy()->addWeek()->format('Y-m-d')]) }}" style="padding: 0.5rem 1rem; border: 1px solid #e5e7eb; border-radius: 6px; text-decoration: none; color: var(--text);">&gt;</a>
        </div>
    </div>

    <div style="overflow-x: auto; border: 1px solid #e5e7eb; border-radius: 12px; background: white;">
        <div style="min-width: 800px; display: flex;">
            <!-- Time Column -->
            <div style="width: 60px; flex-shrink: 0; border-right: 1px solid #e5e7eb; background: #f9fafb;">
                <!-- Header Spacer -->
                <div style="height: 3.5rem; border-bottom: 2px solid #d1d5db;"></div>
                
                <!-- Time Labels -->
                <div style="position: relative; height: {{ count($hours) * 60 }}px;">
                    @foreach($hours as $i => $hour)
                    <div style="position: absolute; top: {{ $i * 60 }}px; width: 100%; text-align: right; padding-right: 8px; transform: translateY(-50%); font-size: 0.75rem; color: #374151; font-weight: 700;">
                        {{ sprintf('%02d:00', $hour) }}
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Days Columns -->
            <div style="flex-grow: 1; display: flex; flex-direction: column;">
                <!-- Header -->
                <div style="display: flex; height: 3.5rem; border-bottom: 2px solid #d1d5db;">
                    @foreach($days as $day)
                    @php $isPast = $day->lt($today); @endphp
                    <div style="flex: 1; text-align: center; border-right: 1px solid #d1d5db; display: flex; flex-direction: column; justify-content: center; {{ $isPast ? 'background-color: #f3f4f6; opacity: 0.6;' : '' }}">
                        <div style="font-weight: 600; color: #111827;">{{ $day->isoFormat('dddd') }}</div>
                        <div style="font-size: 0.75rem; color: #4b5563;">{{ $day->format('d/m') }}</div>
                    </div>
                    @endforeach
                </div>

                <!-- Grid Body -->
                <div style="position: relative; flex-grow: 1; height: {{ count($hours) * 60 }}px;">
                    <!-- Background Grid Lines -->
                    <div style="position: absolute; inset: 0; z-index: 0; pointer-events: none;">
                        @foreach($hours as $i => $hour)
                        <div style="position: absolute; top: {{ $i * 60 }}px; width: 100%; border-top: 1px solid #e5e7eb;"></div>
                                                                                                                                                                                                                                                <div style="position: absolute; top: {{ ($i * 60) + 30 }}px; width: 100%; border-top: 1px dashed #e5e7eb; opacity: 0.5;"></div>
                        @endforeach
                    </div>

                    <!-- Day Columns with Events -->
                    <div style="display: flex; height: 100%; position: relative; z-index: 10;">
                        @foreach($days as $day)
                        @php 
                            $isPast = $day->lt($today);
                            $dateStr = $day->format('Y-m-d');
                            $dayJadwals = $weeklyJadwals->where('tanggal', $dateStr);
                        @endphp
                        <div class="day-column"
                             style="flex: 1; border-right: 1px solid #d1d5db; position: relative; {{ $isPast ? 'background-color: #f3f4f6; opacity: 0.7;' : '' }}"
                             @if(auth()->user()->role === 'admin' && !$isPast)
                                 ondragover="allowDrop(event)"
                                 ondrop="drop(event)"
                                 data-date="{{ $dateStr }}"
                             @endif
                        >
                            @foreach($dayJadwals as $jadwal)
                            @php
                                $startH = (int)substr($jadwal->waktu_mulai, 0, 2);
                                $startM = (int)substr($jadwal->waktu_mulai, 3, 2);
                                $endH = (int)substr($jadwal->waktu_selesai, 0, 2);
                                $endM = (int)substr($jadwal->waktu_selesai, 3, 2);

                                // Calculate position relative to 07:00
                                $startMinutes = ($startH - 7) * 60 + $startM;
                                $duration = (($endH * 60) + $endM) - (($startH * 60) + $startM);
                                
                                $isPending = $jadwal->status === 'pending';
                                
                                // Colors
                                $palettes = [
                                    ['bg' => '#e0f2fe', 'text' => '#0369a1', 'border' => '#0284c7'],
                                    ['bg' => '#dcfce7', 'text' => '#15803d', 'border' => '#16a34a'],
                                    ['bg' => '#f3e8ff', 'text' => '#7e22ce', 'border' => '#9333ea'],
                                    ['bg' => '#fce7f3', 'text' => '#be185d', 'border' => '#db2777'],
                                    ['bg' => '#fef9c3', 'text' => '#a16207', 'border' => '#ca8a04'],
                                    ['bg' => '#e0e7ff', 'text' => '#4338ca', 'border' => '#4f46e5'],
                                    ['bg' => '#fee2e2', 'text' => '#b91c1c', 'border' => '#dc2626'],
                                    ['bg' => '#ccfbf1', 'text' => '#0f766e', 'border' => '#0d9488'],
                                ];

                                if ($isPending) {
                                    $bgColor = '#fff7ed';
                                    $textColor = '#9a3412';
                                    $borderColor = '#ea580c';
                                } else {
                                    $colorIndex = $jadwal->id % count($palettes);
                                    $palette = $palettes[$colorIndex];
                                    $bgColor = $palette['bg'];
                                    $textColor = $palette['text'];
                                    $borderColor = $palette['border'];
                                }
                                
                                $isAdmin = auth()->user()->role === 'admin';
                            @endphp
                            <div 
                                @if($isAdmin && !$isPast)
                                    draggable="true"
                                    ondragstart="drag(event)"
                                    data-id="{{ $jadwal->id }}"
                                    style="position: absolute; top: {{ $startMinutes }}px; height: {{ $duration }}px; left: 4px; right: 4px; cursor: grab; background: {{ $bgColor }}; color: {{ $textColor }}; padding: 0.5rem; border-radius: 4px; border-left: 3px solid {{ $borderColor }}; box-shadow: 0 1px 2px rgba(0,0,0,0.1); font-size: 0.8rem; overflow: hidden; z-index: 20;"
                                @else
                                    style="position: absolute; top: {{ $startMinutes }}px; height: {{ $duration }}px; left: 4px; right: 4px; background: {{ $bgColor }}; color: {{ $textColor }}; padding: 0.5rem; border-radius: 4px; border-left: 3px solid {{ $borderColor }}; box-shadow: 0 1px 2px rgba(0,0,0,0.1); font-size: 0.8rem; overflow: hidden; z-index: 20;"
                                @endif
                            >
                                <div style="font-weight: 600; margin-bottom: 2px; line-height: 1.2;">
                                    {{ $jadwal->kegiatan }}
                                    @if($isPending)
                                        <span style="display: inline-block; font-size: 0.65rem; background: #ea580c; color: white; padding: 1px 4px; border-radius: 3px; margin-left: 4px; vertical-align: middle;">Menunggu</span>
                                    @endif
                                </div>
                                <div style="font-size: 0.7rem; opacity: 0.9;">
                                    {{ substr($jadwal->waktu_mulai, 0, 5) }} - {{ substr($jadwal->waktu_selesai, 0, 5) }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card" style="background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div style="margin-bottom: 1rem;">
        <h2 style="font-size: 1.25rem; font-weight: 600; color: var(--text);">Semua Jadwal</h2>
    </div>
    @if($jadwals->count() > 0)
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                    <th style="padding: 0.75rem; font-weight: 600; color: var(--text); width: 5%;">No</th>
                    <th style="padding: 0.75rem; font-weight: 600; color: var(--text);">Kegiatan</th>
                    <th style="padding: 0.75rem; font-weight: 600; color: var(--text);">Tanggal</th>
                    <th style="padding: 0.75rem; font-weight: 600; color: var(--text);">Waktu</th>
                    @if(auth()->user()->role === 'admin')
                    <th style="padding: 0.75rem; font-weight: 600; color: var(--text); text-align: right;">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $jadwal)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 0.75rem; color: var(--text);">{{ $loop->iteration + $jadwals->firstItem() - 1 }}</td>
                    <td style="padding: 0.75rem; color: var(--text);">{{ $jadwal->kegiatan }}</td>
                    <td style="padding: 0.75rem; color: var(--muted);">{{ \Carbon\Carbon::parse($jadwal->tanggal)->isoFormat('D MMMM Y') }}</td>
                    <td style="padding: 0.75rem; color: var(--muted);">
                        {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}
                    </td>
                    @if(auth()->user()->role === 'admin')
                    <td style="padding: 0.75rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 8px;">
                            <a href="{{ route('jadwal.edit', $jadwal->id) }}" style="background-color: #f59e0b; color: white; text-decoration: none; width: 32px; height: 32px; border-radius: 6px; border: none; display: inline-flex; align-items: center; justify-content: center;" title="Edit">
                                <i class="fas fa-pen-to-square" style="font-size: 14px;"></i>
                            </a>
                            
                            <form action="{{ route('jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background-color: #ef4444; color: white; border: none; width: 32px; height: 32px; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center;" title="Hapus">
                                    <i class="fas fa-trash" style="font-size: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
        {{ $jadwals->links('pagination::bootstrap-4') }}
    </div>
    @else
    <p style="text-align: center; color: var(--muted); padding: 2rem;">Belum ada jadwal pratikum.</p>
    @endif
</div>
@endsection

{{-- Create Schedule Modal --}}
<div id="createScheduleModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 50; justify-content: center; align-items: center;">
    <div style="background: white; border-radius: 12px; padding: 2rem; width: 100%; max-width: 500px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--text);">Tambah Jadwal</h2>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; cursor: pointer; color: var(--muted);">&times;</button>
        </div>

        <form action="{{ route('jadwal.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text);">Nama Kegiatan</label>
                <input type="text" name="kegiatan" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box;" placeholder="Contoh: Pratikum Kimia Dasar" required>
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text);">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box;" required min="{{ date('Y-m-d') }}">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 500; color: var(--text);">Waktu</label>
                <div style="display: flex; gap: 1rem; align-items: center;">
                    <input type="time" name="waktu_mulai" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box;" required>
                    <span style="color: var(--muted);">s/d</span>
                    <input type="time" name="waktu_selesai" class="form-control" style="width: 100%; padding: 0.75rem; border: 1px solid #e2e8f0; border-radius: 6px; box-sizing: border-box;" required>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeModal()" style="padding: 0.75rem 1.5rem; border: 1px solid #e2e8f0; border-radius: 6px; background: white; color: var(--text); font-weight: 500; cursor: pointer;">Batal</button>
                <button type="submit" style="background: var(--primary); color: white; border: none; padding: 0.75rem 1.5rem; border-radius: 6px; cursor: pointer; font-weight: 500;">Simpan Jadwal</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function openModal() {
        document.getElementById('createScheduleModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('createScheduleModal').style.display = 'none';
    }

    // Close modal when clicking outside
    document.getElementById('createScheduleModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });

    // Global variables for Drag and Drop Ghost effect
    let draggedItem = null;
    let ghostElement = null;

    function cleanupGhost() {
        if (ghostElement && ghostElement.parentNode) {
            ghostElement.parentNode.removeChild(ghostElement);
        }
        ghostElement = null;
    }

    document.addEventListener('dragend', cleanupGhost);

    function allowDrop(ev) {
        ev.preventDefault();
        
        var column = ev.target.closest('.day-column');
        if (!column || !draggedItem) return;

        // Create ghost if needed
        if (!ghostElement) {
            ghostElement = document.createElement('div');
            ghostElement.style.position = 'absolute';
            ghostElement.style.left = '4px';
            ghostElement.style.right = '4px';
            ghostElement.style.backgroundColor = 'rgba(59, 130, 246, 0.2)'; // Blue-500 with opacity
            ghostElement.style.border = '2px dashed #2563eb'; // Blue-600
            ghostElement.style.borderRadius = '4px';
            ghostElement.style.zIndex = '15'; 
            ghostElement.style.pointerEvents = 'none'; 
            ghostElement.style.height = draggedItem.style.height;
        }

        // Append to this column if moved
        if (ghostElement.parentNode !== column) {
            column.appendChild(ghostElement);
        }

        // Calculate Position
        var rect = column.getBoundingClientRect();
        var relativeY = ev.clientY - rect.top;
        
        // Snap to nearest 30 minutes
        var minutesFromStart = relativeY;
        var snappedMinutes = Math.round(minutesFromStart / 30) * 30;
        
        // Clamp logic
        var hourIndex = Math.floor(snappedMinutes / 60);
        var targetHour = 7 + hourIndex;
        
        if (targetHour < 7) {
            snappedMinutes = 0;
        } else if (targetHour > 18) {
            snappedMinutes = (18 - 7) * 60;
        }

        ghostElement.style.top = snappedMinutes + 'px';
    }

    function drag(ev) {
        ev.dataTransfer.setData("text", ev.target.getAttribute('data-id'));
        draggedItem = ev.target;
        cleanupGhost();
    }

    function drop(ev) {
        ev.preventDefault();
        cleanupGhost();
        var dataId = ev.dataTransfer.getData("text");
        
        // Find the closest day column (target could be the column or an event inside it)
        var column = ev.target.closest('.day-column');
        if (!column) return;

        var targetDate = column.getAttribute('data-date');
        
        if (!targetDate) {
            return;
        }

        // Calculate hour based on Y position relative to the column
        var rect = column.getBoundingClientRect();
        var relativeY = ev.clientY - rect.top;
        
        // Calculate total minutes from start (07:00)
        // Snap to nearest 30 minutes
        var minutesFromStart = relativeY;
        var snappedMinutes = Math.round(minutesFromStart / 30) * 30;
        
        var hourIndex = Math.floor(snappedMinutes / 60);
        var minuteRemainder = snappedMinutes % 60;
        
        var targetHour = 7 + hourIndex;

        // Clamp values just in case
        if (targetHour < 7) {
            targetHour = 7;
            minuteRemainder = 0;
        }
        if (targetHour > 18) {
            targetHour = 18;
            minuteRemainder = 0;
        }

        fetch(`/jadwal/${dataId}/move`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                tanggal: targetDate,
                hour: targetHour,
                minute: minuteRemainder
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Find the dragged element using the data-id
                const element = document.querySelector(`div[data-id="${dataId}"]`);
                
                if (element && column) {
                    // Update the element's position in the DOM
                    
                    // If moving to a different day, append to new column
                    if (element.parentElement !== column) {
                        column.appendChild(element);
                    }
                    
                    // Update top position
                    // We need to calculate pixels based on new start time
                    // The backend snapped to hour/minute
                    const newTop = ((targetHour - 7) * 60) + minuteRemainder;
                    element.style.top = `${newTop}px`;
                    
                    // Update time text
                    // Find the time div inside the element (it's the second div)
                    const timeDiv = element.children[1];
                    if (timeDiv) {
                        timeDiv.textContent = `${data.waktu_mulai} - ${data.waktu_selesai}`;
                    }
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Gagal memindahkan jadwal.',
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Terjadi kesalahan sistem.',
            });
        });
    }
</script>
@endpush