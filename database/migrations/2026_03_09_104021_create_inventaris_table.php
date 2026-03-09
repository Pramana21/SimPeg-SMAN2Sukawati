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
    Schema::create('inventaris', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->string('kode_barang')->unique();
        $table->integer('jumlah');
        $table->string('kondisi');
        $table->string('lokasi');
        $table->date('tanggal_input')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
