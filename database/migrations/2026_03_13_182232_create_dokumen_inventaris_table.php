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
        Schema::create('dokumen_inventaris', function (Blueprint $table) {

        $table->id('id_dokumen_inventaris');

        $table->unsignedBigInteger('id_user');

        $table->string('nama_dokumen',150);

        $table->date('tanggal_dokumen');

        $table->string('file_path',255);

        $table->string('created_by',100);

        $table->tinyInteger('bulan')->nullable();
        $table->smallInteger('tahun')->nullable();

        $table->timestamps();

        $table->foreign('id_user')
            ->references('id_user')
            ->on('users');

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_inventaris');
    }
};
