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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('nama_desa')->default('Desa SteamTek');
        $table->string('latitude_kantor')->default('3.5952'); // Default lokasi
        $table->string('longitude_kantor')->default('98.6722');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
