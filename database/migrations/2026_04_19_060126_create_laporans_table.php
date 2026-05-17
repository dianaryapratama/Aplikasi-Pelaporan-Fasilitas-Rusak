<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('laporans', function (Blueprint $table) {
        $table->id('id_laporan'); 
        // Relasi ke tabel users (siapa yang melapor)
        $table->foreignId('id_user')->constrained('users')->onDelete('cascade'); 
        
        $table->string('nama_fasilitas');
        $table->string('jenis_kerusakan'); 
        $table->text('deskripsi');
        $table->string('foto_bukti')->nullable();
        $table->timestamp('tgl_lapor')->useCurrent();
        $table->enum('status', ['Menunggu', 'Proses', 'Selesai'])->default('Menunggu');
        
        // Kolom geom untuk PostGIS (menyimpan koordinat map)
        $table->geometry('geom')->nullable(); 
        
        $table->timestamp('tgl_pembaruan')->nullable();
        $table->text('catatan_petugas')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
