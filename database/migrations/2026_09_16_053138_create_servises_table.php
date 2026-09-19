<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servises', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique();

            // Relasi ke tabel kendaraans dan users (mekanik)
            $table->foreignId('kendaraan_id')->constrained('kendaraans')->onDelete('cascade');
            $table->foreignId('mekanik_id')->nullable()->constrained('users')->onDelete('set null');

            $table->text('keluhan');
            $table->decimal('biaya_jasa', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->enum('status', ['antre', 'proses', 'selesai', 'batal'])->default('antre');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servises');
    }
};
