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
        Schema::create('dokumen_penyuratan', function (Blueprint $table) {

        $table->id('id_dokumen_penyuratan');

        $table->unsignedBigInteger('id_user');

        $table->string('nama_dokumen',150);
        $table->string('no_surat',60)->unique();

        $table->date('tanggal_dokumen');

        $table->unsignedBigInteger('id_jenis_surat');

        $table->string('nama_pengirim_penerima',120)->nullable();

        $table->string('file_path',255);

        $table->string('created_by',100);

        $table->tinyInteger('bulan')->nullable();
        $table->smallInteger('tahun')->nullable();

        $table->timestamps();

        $table->foreign('id_user')
            ->references('id_user')
            ->on('users');

        $table->foreign('id_jenis_surat')
            ->references('id_jenis_surat')
            ->on('jenis_surat');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_penyuratan');
    }
};
