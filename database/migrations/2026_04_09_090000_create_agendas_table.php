<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->date('tanggal');
            $table->string('waktu_kegiatan', 100)->nullable();
            $table->string('lokasi', 150)->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('dibuat_oleh', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
