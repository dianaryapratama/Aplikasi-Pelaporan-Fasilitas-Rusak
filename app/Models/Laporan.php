<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB; // <-- WAJIB TAMBAHKAN INI

class Laporan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user', 'nama_fasilitas', 'jenis_kerusakan', 'deskripsi', 
        'foto_bukti', 'tgl_lapor', 'status', 'geom', 'tgl_pembaruan', 'catatan_petugas'
    ];

    // Menambahkan kolom virtual ini saat kita melakukan return JSON
    protected $appends = ['latitude', 'longitude'];

    // ACCESSSOR UNTUK LATITUDE (Y)
    public function getLatitudeAttribute()
    {
        if ($this->geom) {
            $result = DB::selectOne("SELECT ST_Y(geom::geometry) as lat FROM laporans WHERE id_laporan = ?", [$this->id_laporan]);
            return $result ? (float) $result->lat : null;
        }
        return null;
    }

    // ACCESSSOR UNTUK LONGITUDE (X)
    public function getLongitudeAttribute()
    {
        if ($this->geom) {
            $result = DB::selectOne("SELECT ST_X(geom::geometry) as lng FROM laporans WHERE id_laporan = ?", [$this->id_laporan]);
            return $result ? (float) $result->lng : null;
        }
        return null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}