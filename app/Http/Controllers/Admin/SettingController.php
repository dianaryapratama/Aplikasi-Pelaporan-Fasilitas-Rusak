<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Ambil data pertama. Jika tabel kosong, buat data default otomatis.
        $setting = Setting::firstOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Kantor Desa SteamTek',
                'latitude_kantor' => '3.5952',
                'longitude_kantor' => '98.6722'
            ]
        );

        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request)
{
    $request->validate([
        'nama_desa' => 'required|string|max:255',
        'latitude_kantor' => 'required|string',
        'longitude_kantor' => 'required|string',
        'telegram_bot_token' => 'nullable|string',
        'telegram_chat_id' => 'nullable|string',
    ]);

    // Proses penyimpanan data pertama atau update
    $setting = Setting::first();
    if ($setting) {
        $setting->update($request->all());
    } else {
        Setting::create($request->all());
    }

    return back()->with('success', 'Pengaturan sistem berhasil diperbarui.');
}
}