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
        Schema::create('jenis_dokumen_administrasi', function (Blueprint $table) {

        $table->id('id_jenis_dokumen_administrasi');

        $table->unsignedBigInteger('id_kategori_administrasi');

        $table->string('nama_jenis',80);

        $table->foreign('id_kategori_administrasi')
            ->references('id_kategori_administrasi')
            ->on('kategori_administrasi');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_dokumen_administrasi');
    }
};
