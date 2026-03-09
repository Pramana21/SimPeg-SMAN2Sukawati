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
    Schema::create('dokumen_pegawai', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pegawai_id')->constrained()->cascadeOnDelete();
        $table->string('nama_dokumen');
        $table->string('file_dokumen');
        $table->date('tanggal_upload')->nullable();
        $table->text('keterangan')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_pegawai');
    }
};
