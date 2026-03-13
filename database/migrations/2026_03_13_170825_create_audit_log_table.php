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
        Schema::create('audit_log', function (Blueprint $table) {

        $table->increments('id_audit_log');

        $table->integer('id_user')->unsigned();

        $table->string('action',20);
        $table->string('module',50);

        $table->string('entity',50)->nullable();
        $table->integer('entity_id')->nullable();

        $table->string('description',255)->nullable();

        $table->timestamp('created_at');

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
        Schema::dropIfExists('audit_log');
    }
};
