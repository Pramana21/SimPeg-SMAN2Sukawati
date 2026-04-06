<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dokumen_administrasi', function (Blueprint $table) {
            $table->string('kelas', 10)->nullable()->after('created_by');
            $table->string('kategori_kelas', 20)->nullable()->after('kelas');
        });
    }

    public function down(): void
    {
        Schema::table('dokumen_administrasi', function (Blueprint $table) {
            $table->dropColumn(['kelas', 'kategori_kelas']);
        });
    }
};
