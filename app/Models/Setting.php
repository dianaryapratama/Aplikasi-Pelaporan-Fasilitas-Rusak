<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
    'nama_desa', 
    'latitude_kantor', 
    'longitude_kantor',
    'telegram_bot_token',  // Tambahkan ini
    'telegram_chat_id'     // Tambahkan ini
];
}