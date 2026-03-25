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
        Schema::create('dokumen_administrasi', function (Blueprint $table) {

        $table->id('id_dokumen_administrasi');

        $table->unsignedBigInteger('id_user');
        $table->string('nama_dokumen',150);
        $table->date('tanggal_dokumen');

        $table->unsignedBigInteger('id_jenis_dokumen_administrasi');

        $table->unsignedBigInteger('id_kelas')->nullable();

        $table->string('file_path',255);
        $table->string('created_by',100);

        $table->tinyInteger('bulan')->nullable();
        $table->smallInteger('tahun')->nullable();

        $table->timestamps();

        $table->foreign('id_user')
            ->references('id_user')
            ->on('users');

        $table->foreign('id_jenis_dokumen_administrasi')
            ->references('id_jenis_dokumen_administrasi')
            ->on('jenis_dokumen_administrasi');

        $table->foreign('id_kelas')
            ->references('id_kelas')
            ->on('kelas');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_administrasi');
    }
};
