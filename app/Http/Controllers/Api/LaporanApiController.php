<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class LaporanApiController extends Controller
{
    // 1. Fungsi Create Laporan (dengan Lokasi GPS & Foto)
    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string',
            'jenis_kerusakan' => 'required|string',
            'deskripsi' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto_bukti' => 'nullable|image|mimes:jpeg,png,jpg|max:5120' // Maks 5MB
        ]);

        // Proses penyimpanan file foto jika ada yang diupload
        $fotoPath = null;
        if ($request->hasFile('foto_bukti')) {
            $fotoPath = $request->file('foto_bukti')->store('laporan_fotos', 'public');
        }

        // ANTI SQL INJECTION: Paksa input menjadi tipe data float murni
        $lat = floatval($request->latitude);
        $lng = floatval($request->longitude);

        $laporan = Laporan::create([
            'id_user' => $request->user()->id, 
            'nama_fasilitas' => $request->nama_fasilitas,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi,
            'foto_bukti' => $fotoPath,
            'status' => 'Menunggu',
            // Gunakan ST_MakePoint & SetSRID yang lebih aman dan terstandarisasi
            'geom' => DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)")
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil dikirim ke server!',
            'data' => $laporan
        ], 201);
    }

    // 2. Fungsi Lihat Riwayat Laporan (Untuk ditampilkan di aplikasi warga)
    public function riwayat(Request $request)
    {
        // Ambil laporan dan ekstrak kolom geom menjadi latitude & longitude
        $laporans = Laporan::where('id_user', $request->user()->id)
            ->select(
                '*', 
                // Mengekstrak Titik Y (Latitude) dan Titik X (Longitude) dari PostGIS
                DB::raw('ST_Y(geom::geometry) AS latitude'),
                DB::raw('ST_X(geom::geometry) AS longitude')
            )
            ->orderBy('tgl_lapor', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $laporans
        ]);
    }

    // 3. Fungsi "Up Laporan" (Mengingatkan Petugas)
    public function upLaporan(Request $request, $id)
    {
        // Cari laporan milik user tersebut
        $laporan = Laporan::where('id_user', $request->user()->id)->findOrFail($id);

        // Cek apakah status masih 'Menunggu'
        if ($laporan->status !== 'Menunggu') {
            return response()->json([
                'status' => 'error',
                'message' => 'Laporan sudah diproses atau selesai, tidak bisa di-Up lagi.'
            ], 400);
        }

        // Logika "Up": Perbarui tanggal pembaruan agar naik ke atas
        $laporan->update([
            'updated_at' => now(), // Laravel standar menggunakan updated_at
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Laporan berhasil di-Up! Notifikasi prioritas telah dikirim ke petugas.'
        ]);
    }

    public function getPolygon()
    {
        // Ambil data poligon dari tabel setting (Sama seperti PublicController web)
        $polygonData = DB::selectOne("SELECT ST_AsGeoJSON(batas_wilayah) as geojson FROM settings LIMIT 1");

        if (!$polygonData || !$polygonData->geojson) {
            return response()->json([
                'status' => 'error',
                'message' => 'Batas wilayah belum diatur oleh Admin.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            // Kita decode agar Flutter menerimanya sebagai Object JSON asli, bukan String
            'data' => json_decode($polygonData->geojson) 
        ]);
    }
}