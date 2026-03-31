<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users', 'id_user')
                ->cascadeOnDelete();
            $table->string('nama_pengguna');
            $table->string('modul');
            $table->string('aktivitas');
            $table->text('keterangan')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        if (Schema::hasTable('audit_log')) {
            $legacyLogs = DB::table('audit_log')->get();

            foreach ($legacyLogs as $legacyLog) {
                $legacyUser = null;

                if (!empty($legacyLog->id_user) && Schema::hasTable('users')) {
                    $legacyUser = DB::table('users')
                        ->where('id_user', $legacyLog->id_user)
                        ->first();
                }

                DB::table('audit_logs')->insert([
                    'user_id' => $legacyUser?->id_user,
                    'nama_pengguna' => $legacyUser->username ?? 'Sistem',
                    'modul' => $legacyLog->module,
                    'aktivitas' => $legacyLog->action,
                    'keterangan' => $legacyLog->description,
                    'created_at' => $legacyLog->created_at ?? now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
