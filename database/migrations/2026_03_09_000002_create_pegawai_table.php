<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pegawai', function (Blueprint $table) {

        $table->id('id_pegawai');

        $table->string('nip_nippk',40)->unique()->nullable();
        $table->string('nik',30)->unique()->nullable();
        $table->string('nuptk',40)->unique()->nullable();

        $table->string('nama_pegawai',120);
        $table->date('tanggal_lahir')->nullable();
        $table->string('jenis_kelamin',20)->nullable();

        $table->enum('status_pegawai',[
            'Honor',
            'PNS',
            'PKKK',
            'Kontrak Provinsi',
            'OJTM'
        ]);

        $table->string('pendidikan_terakhir',80)->nullable();
        $table->string('alamat',255)->nullable();
        $table->string('email',120)->nullable();
        $table->string('no_hp',30)->nullable();

        $table->string('foto_path',255)->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();

    });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawai');
    }
};