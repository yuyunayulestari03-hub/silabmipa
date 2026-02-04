<?php

namespace App\Http\Controllers;

use App\Models\JadwalPratikum;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        // Calculate week range
        $date = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now();
        $startOfWeek = $date->copy()->startOfWeek();
        $endOfWeek = $date->copy()->endOfWeek();

        // Get schedules for this week (Approved and Pending)
        $weeklyJadwals = JadwalPratikum::whereIn('status', ['approved', 'pending'])
            ->whereBetween('tanggal', [$startOfWeek->format('Y-m-d'), $endOfWeek->format('Y-m-d')])
            ->get();

        // Prepare calendar grid data
        $calendar = [];
        foreach ($weeklyJadwals as $jadwal) {
            $d = $jadwal->tanggal;
            $h = (int) substr($jadwal->waktu_mulai, 0, 2);
            $endH = (int) substr($jadwal->waktu_selesai, 0, 2);
            if (substr($jadwal->waktu_selesai, 3, 2) > 0) $endH++; // Round up if minutes > 0
            
            $duration = max(1, $endH - $h);
            
            // Check if slot is already occupied by an APPROVED schedule
            // If current schedule is pending and slot is occupied, skip pending
            // If current is approved and slot is occupied by pending, overwrite
            
            $isOccupied = false;
            if (isset($calendar[$d][$h]) && is_array($calendar[$d][$h])) {
                 // If existing is approved, don't overwrite
                 if ($calendar[$d][$h]['jadwal']->status === 'approved') {
                     continue;
                 }
            }
            
            // Also check subsequent slots for overlaps
            // This simple logic might not be perfect for all overlaps but works for basic cases
            
            $calendar[$d][$h] = [
                'jadwal' => $jadwal,
                'duration' => $duration
            ];
            
            // Mark subsequent slots as 'occupied'
            for ($i = 1; $i < $duration; $i++) {
                $calendar[$d][$h + $i] = 'occupied';
            }
        }

        // Time slots 07:00 to 18:00
        $hours = range(7, 18);
        $days = [];
        $tempDate = $startOfWeek->copy();
        for ($i = 0; $i < 7; $i++) {
            $days[] = $tempDate->copy();
            $tempDate->addDay();
        }

        // Existing full list for table below
        $jadwals = JadwalPratikum::where('status', 'approved')
            ->orderBy('tanggal', 'desc')
            ->orderBy('waktu_mulai', 'asc')
            ->paginate(10);
            
        return view('jadwal.index', compact('jadwals', 'weeklyJadwals', 'calendar', 'hours', 'days', 'startOfWeek', 'endOfWeek'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        JadwalPratikum::create(array_merge($request->all(), ['status' => 'approved', 'user_id' => auth()->id()]));

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = JadwalPratikum::findOrFail($id);
        return view('jadwal.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ]);

        $jadwal = JadwalPratikum::findOrFail($id);
        $jadwal->update($request->all());

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diperbarui!');
    }

    public function move(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'tanggal' => 'required|date',
            'hour' => 'required|integer|min:0|max:23',
            'minute' => 'nullable|integer|min:0|max:59',
        ]);

        // Validate date is not in the past (allow today)
        if (Carbon::parse($request->tanggal)->lt(Carbon::today())) {
            return response()->json([
                'success' => false, 
                'message' => 'Tidak dapat memindahkan jadwal ke hari yang sudah lewat.'
            ], 422);
        }

        $jadwal = JadwalPratikum::findOrFail($id);

        // Calculate duration
        $start = Carbon::parse($jadwal->waktu_mulai);
        $end = Carbon::parse($jadwal->waktu_selesai);
        $durationMinutes = $start->diffInMinutes($end);

        // Set new start time
        $newStartH = $request->hour;
        $newStartM = $request->minute ?? 0;
        
        $newStartTime = Carbon::createFromTime($newStartH, $newStartM, 0);
        $newEndTime = $newStartTime->copy()->addMinutes($durationMinutes);

        $jadwal->update([
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $newStartTime->format('H:i'),
            'waktu_selesai' => $newEndTime->format('H:i'),
        ]);

        return response()->json([
            'success' => true,
            'waktu_mulai' => $newStartTime->format('H:i'),
            'waktu_selesai' => $newEndTime->format('H:i'),
        ]);
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $jadwal = JadwalPratikum::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
