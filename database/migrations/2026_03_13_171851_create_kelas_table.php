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
        Schema::create('kelas', function (Blueprint $table) {

        $table->increments('id_kelas');

        $table->smallInteger('tingkat');
        $table->char('fase',1);
        $table->smallInteger('rombel');

        $table->char('peminatan',3)->default('P');

        $table->string('nama_kelas',20)->unique();

        $table->timestamps();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
