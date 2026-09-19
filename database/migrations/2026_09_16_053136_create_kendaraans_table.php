<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->string('plat_nomor')->unique();
            $table->string('nama_pemilik');
            $table->string('no_hp');
            $table->string('merk_tipe'); // Contoh: Honda Vario 150 / Toyota Avanza
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};