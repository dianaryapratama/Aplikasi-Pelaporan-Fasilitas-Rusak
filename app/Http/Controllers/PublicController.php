<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;
use App\Models\Setting; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PublicController extends Controller
{
    public function showFormLapor()
    {
        // Ambil data poligon untuk batas wilayah desa
        $polygonData = DB::selectOne("SELECT ST_AsGeoJSON(batas_wilayah) as geojson FROM settings LIMIT 1");
        return view('lapor', compact('polygonData'));
    }

    public function storeLapor(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'jenis_kerusakan' => 'required|string',
            'deskripsi' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:4096'
        ]);

        $lat = (float) $request->latitude;
        $lng = (float) $request->longitude;

        // --- Logika Geofencing PostGIS ---
        $geofenceCheck = DB::selectOne("
            SELECT ST_Contains(
                (SELECT batas_wilayah FROM settings LIMIT 1), 
                ST_SetSRID(ST_MakePoint(?, ?), 4326)
            ) AS is_inside
        ", [$lng, $lat]);

        if (!$geofenceCheck || $geofenceCheck->is_inside === false) {
            return back()->withInput()->withErrors([
                'lokasi' => 'Mohon Maaf. Titik lokasi yang Anda pilih berada di luar wilayah pelayanan desa kami. Pastikan Anda menggeser pin merah ke dalam area garis biru.'
            ]);
        }

        // 2. Proses Simpan Data Laporan
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('laporan_foto', 'public');
        }

        Laporan::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'jenis_kerusakan' => $request->jenis_kerusakan,
            'deskripsi' => $request->deskripsi . " (via Website)",
            'foto_bukti' => $fotoPath,
            'status' => 'Menunggu',
            'tgl_lapor' => now(),
            'id_user' => Auth::id(), // Pastikan user sudah login agar ini tidak null
            'geom' => DB::raw("ST_SetSRID(ST_MakePoint($lng, $lat), 4326)"), 
        ]);

        // ========================================================
        // 3. LOGIKA NOTIFIKASI TELEGRAM OTOMATIS
        // ========================================================
        try {
            $setting = Setting::first();

            // Pastikan data setting, token, dan chat id tersedia
            if ($setting && $setting->telegram_token && $setting->telegram_chat_id) {
                
                $pesan = "🚨 *LAPORAN KERUSAKAN BARU* 🚨\n\n";
                $pesan .= "🏢 *Fasilitas:* " . $request->nama_fasilitas . "\n";
                $pesan .= "🔧 *Kerusakan:* " . $request->jenis_kerusakan . "\n";
                
                // Tangani nama pelapor
                $namaPelapor = Auth::check() ? Auth::user()->name : "Warga Anonim";
                $pesan .= "👤 *Pelapor:* " . $namaPelapor . "\n";
                $pesan .= "📝 *Deskripsi:* " . $request->deskripsi . "\n\n";
                
                // PERBAIKAN: Format link Google Maps yang standar
                $pesan .= "📍 *Lokasi:* [Buka di Google Maps](https://www.google.com/maps/place/{$lat},{$lng})\n\n";
                $pesan .= "⚠️ _Segera tinjau Dashboard Admin steamtek.id untuk tindak lanjut._";

                // PERBAIKAN: Tambahkan withoutVerifying() agar tidak error SSL di Localhost
                Http::withoutVerifying()->post("https://api.telegram.org/bot{$setting->telegram_token}/sendMessage", [
                    'chat_id' => $setting->telegram_chat_id,
                    'text' => $pesan,
                    'parse_mode' => 'Markdown',
                ]);
            } else {
                // Log jika token/chat ID kosong di database
                Log::warning("Telegram Gagal: Token atau Chat ID belum diisi di Pengaturan Admin.");
            }
        } catch (\Exception $e) {
            Log::error('Telegram Notif Error: ' . $e->getMessage());
        }

        // ========================================================
        // KEMBALI KE HALAMAN FORM DENGAN PESAN SUKSES
        // ========================================================
       return redirect()->back()->with('success', 'Terima Kasih telah melapor! Laporan Anda berhasil dikirim. Tim teknis desa akan segera meninjau dan menindaklanjuti kerusakan tersebut. Mari bersama bangun desa kita!');
    }
    public function dashboardWarga()
    {
        // Ambil data laporan khusus milik warga yang sedang login
        $laporans = \App\Models\Laporan::where('id_user', \Illuminate\Support\Facades\Auth::id())
                        ->orderBy('tgl_lapor', 'desc')
                        ->get();

        // Hitung statistik untuk kartu ringkasan
        $statMenunggu = $laporans->where('status', 'Menunggu')->count();
        $statProses = $laporans->where('status', 'Proses')->count();
        $statSelesai = $laporans->where('status', 'Selesai')->count();

        return view('warga.dashboard', compact('laporans', 'statMenunggu', 'statProses', 'statSelesai'));
    }
}