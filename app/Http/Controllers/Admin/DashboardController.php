<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama
        $totalLaporan = Laporan::count();
        $menunggu = Laporan::where('status', 'Menunggu')->count();
        $proses = Laporan::where('status', 'Proses')->count();
        $selesai = Laporan::where('status', 'Selesai')->count();
        
        // 2. Data untuk tabel (Paginasi)
        $laporans = Laporan::with('user')->orderBy('created_at', 'desc')->paginate(5);

        // 3. DATA BARU: Tren Pelaporan Bulanan (Tahun Berjalan)
        $trendData = Laporan::selectRaw('EXTRACT(MONTH FROM created_at) as bulan, count(*) as jumlah')
                        ->whereYear('created_at', date('Y'))
                        ->groupBy('bulan')
                        ->orderBy('bulan')
                        ->get();

        $bulanLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        $trendJumlah = array_fill(0, 12, 0); // Isi default angka 0 untuk 12 bulan

        foreach ($trendData as $data) {
            $trendJumlah[$data->bulan - 1] = $data->jumlah; // Index array mulai dari 0
        }
        
        $chartTren = [
            'labels' => $bulanLabels,
            'data' => $trendJumlah
        ];

        // 4. Data untuk Chart Kategori Kerusakan
        $kategoriData = Laporan::selectRaw('jenis_kerusakan as kategori, count(*) as jumlah')
                        ->groupBy('jenis_kerusakan')
                        ->get();

        $chartKategori = [
            'labels' => $kategoriData->pluck('kategori')->toArray(),
            'data' => $kategoriData->pluck('jumlah')->toArray(),
        ];

        return view('admin.dashboard', compact(
            'totalLaporan', 'menunggu', 'proses', 'selesai', 'laporans', 'chartKategori', 'chartTren'
        ));
    }
}