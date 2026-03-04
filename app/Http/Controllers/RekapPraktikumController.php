<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPratikum;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\PeminjamanInventaris;
use App\Models\Inventaris;


class RekapPraktikumController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        return view('admin.rekap-praktikum.index');
    }
    public function preview(Request $request)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $request->validate([
        'bulan' => 'required'
    ]);

    $start = Carbon::parse($request->bulan)->startOfMonth();
    $end   = Carbon::parse($request->bulan)->endOfMonth();

    // A. Rekap kegiatan praktikum
    $jadwal = JadwalPratikum::with('user')
        ->where('status', 'approved')
        ->whereBetween('tanggal', [$start, $end])
        ->orderBy('tanggal')
        ->get();

    // B. Rekap peminjaman inventaris
    $peminjamanInventaris = PeminjamanInventaris::with('inventaris')
    ->whereIn('status', ['approved', 'returned'])
    ->whereBetween('tanggal_pinjam', [$start, $end])
    ->get();

    // C. Rekap jumlah peminjaman per inventaris
$jumlahDipinjam = PeminjamanInventaris::select(
        'inventaris_id',
        \DB::raw('COUNT(*) as total_pinjam')
    )
    ->whereIn('status', ['approved', 'returned'])
    ->whereBetween('tanggal_pinjam', [$start, $end])
    ->groupBy('inventaris_id')
    ->with('inventaris')
    ->get();



    return view('admin.rekap-praktikum.index', [
    'jadwal' => $jadwal,
    'peminjamanInventaris' => $peminjamanInventaris,
    'jumlahDipinjam' => $jumlahDipinjam,
    'bulan' => $start->translatedFormat('F Y')
]);

}


   public function downloadPdf(Request $request)
{
    if (auth()->user()->role !== 'admin') {
        abort(403);
    }

    $request->validate([
        'bulan' => 'required'
    ]);

    $start = \Carbon\Carbon::parse($request->bulan)->startOfMonth();
    $end   = \Carbon\Carbon::parse($request->bulan)->endOfMonth();

    /* ===============================
       A. REKAP KEGIATAN PRAKTIKUM
    =============================== */
    $jadwal = \App\Models\JadwalPratikum::with('user')
        ->where('status', 'approved')
        ->whereBetween('tanggal', [$start, $end])
        ->orderBy('tanggal')
        ->get();

    /* ===============================
       B. REKAP PEMINJAMAN INVENTARIS
    =============================== */
    $peminjamanInventaris = PeminjamanInventaris::with(['inventaris', 'user'])
    ->whereIn('status', ['approved', 'returned'])
    ->whereBetween('tanggal_pinjam', [$start, $end])
    ->orderBy('tanggal_pinjam')
    ->get();

    $jumlahDipinjam = PeminjamanInventaris::select(
        'inventaris_id',
        \DB::raw('COUNT(*) as total_pinjam')
    )
    ->whereIn('status', ['approved', 'returned'])
    ->whereBetween('tanggal_pinjam', [$start, $end])
    ->groupBy('inventaris_id')
    ->with('inventaris')
    ->get();



    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView(
        'admin.rekap-praktikum.pdf',
        [
            'jadwal' => $jadwal,
            'peminjamanInventaris' => $peminjamanInventaris,
            'bulan' => $start->translatedFormat('F Y'),
            'tanggalCetak' => now()->format('d/m/Y')
        ]
    )->setPaper('A4', 'portrait');

    return $pdf->download(
        "Rekap-Laboratorium-{$start->format('Y-m')}.pdf"
    );
}
}
