<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // Menampilkan halaman detail
    public function show($id)
    {
        $laporan = Laporan::with('user')
        ->select('*')
        ->addSelect(DB::raw('ST_X(geom) as longitude'))
        ->addSelect(DB::raw('ST_Y(geom) as latitude'))
        ->findOrFail($id);

    return view('admin.laporan_detail', compact('laporan'));
    }

    // Memproses update status dan catatan dari admin
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'catatan_petugas' => 'nullable|string'
        ]);

        $laporan = Laporan::findOrFail($id);
        $laporan->update([
            'status' => $request->status,
            'catatan_petugas' => $request->catatan_petugas,
            'tgl_pembaruan' => now() // Set tanggal update saat itu juga
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Status laporan berhasil diperbarui!');
    }

   
}
