<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use Illuminate\Console\Command;

class CleanAuditLog extends Command
{
    protected $signature = 'clean:audit-log';

    protected $description = 'Hapus audit log yang lebih lama dari 30 hari';

    public function handle()
    {
        AuditLog::where('created_at', '<', now()->subDays(30))->delete();

        $this->info('Audit log lama berhasil dibersihkan');

        return self::SUCCESS;
    }
}
