<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('model_has_roles')) {
            Schema::create('model_has_roles', function (Blueprint $table) {
                $table->id('id_model_has_role');
                $table->unsignedBigInteger('id_user')->unique();
                $table->unsignedBigInteger('id_role');
                $table->timestamps();

                $table->foreign('id_user')
                    ->references('id_user')
                    ->on('users')
                    ->onDelete('cascade');

                $table->foreign('id_role')
                    ->references('id_role')
                    ->on('roles')
                    ->onDelete('cascade');
            });
        }

        DB::table('users')
            ->select('id_user', 'id_role')
            ->whereNotNull('id_role')
            ->orderBy('id_user')
            ->get()
            ->each(function ($user): void {
                DB::table('model_has_roles')->updateOrInsert(
                    ['id_user' => $user->id_user],
                    [
                        'id_role' => $user->id_role,
                        'updated_at' => now(),
                        'created_at' => now(),
                    ]
                );
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
