<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\JadwalPratikum;
use App\Models\Inventaris;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalAlat = Inventaris::count();
        
        // Count total peminjaman (schedules)
        $totalPeminjaman = JadwalPratikum::count();
        
        // For admin, maybe show pending requests count specifically
        $pendingRequests = 0;
        if (auth()->user()->role === 'admin') {
            $pendingRequests = JadwalPratikum::where('status', 'pending')->count();
        }

        // Fetch approved schedules for the calendar
        $schedules = JadwalPratikum::with('user')
            ->where('status', 'approved')
            ->orderBy('tanggal', 'asc')
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // Prepare events for a calendar view (if using a JS library)
        // or just list them for now. 
        // Let's assume we pass the collection and handle it in Blade or pass JSON.
        $events = $schedules->map(function ($schedule) {
            return [
                'title' => $schedule->kegiatan,
                'start' => $schedule->tanggal . 'T' . $schedule->waktu_mulai,
                'end' => $schedule->tanggal . 'T' . $schedule->waktu_selesai,
                'user' => $schedule->user ? $schedule->user->name : 'Unknown',
                'nama_dosen' => $schedule->nama_dosen,
            ];
        });

        // Get recent activities (e.g., latest 5 approved schedules)
        $upcomingSchedules = JadwalPratikum::with('user')
            ->where('status', 'approved')
            ->where('tanggal', '>=', Carbon::today())
            ->orderBy('tanggal', 'asc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUser', 
            'totalAlat', 
            'totalPeminjaman', 
            'pendingRequests',
            'schedules',
            'events',
            'upcomingSchedules'
        ));
    }
}
