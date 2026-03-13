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
        Schema::create('siswa', function (Blueprint $table) {

        $table->increments('id_siswa');

        $table->string('nis',30)->unique();
        $table->string('nisn',30)->nullable()->unique();
        $table->string('nik',30)->nullable();

        $table->string('nama_siswa',120);
        $table->date('tanggal_lahir')->nullable();
        $table->string('jenis_kelamin',20)->nullable();

        $table->string('alamat',255)->nullable();
        $table->string('email',120)->nullable();
        $table->string('no_hp',30)->nullable();

        $table->string('nama_ibu_kandung',120)->nullable();

        $table->string('foto_path',255)->nullable();

        $table->integer('id_kelas')->unsigned()->nullable();

        $table->boolean('is_active')->default(true);

        $table->timestamps();

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
        Schema::dropIfExists('siswa');
    }
};
