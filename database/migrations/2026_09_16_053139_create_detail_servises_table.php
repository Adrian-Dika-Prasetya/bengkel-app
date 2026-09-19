<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_servises', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel servises dan spareparts
            $table->foreignId('servis_id')->constrained('servises')->onDelete('cascade');
            $table->foreignId('sparepart_id')->constrained('spareparts')->onDelete('cascade');
            
            $table->integer('jumlah');
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_servises');
    }
};