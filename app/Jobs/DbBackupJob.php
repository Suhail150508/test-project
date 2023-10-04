<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class DbBackupJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        try {
            Log::info('Job started');

            $projectPath = base_path();
            $command = 'php ' . $projectPath . '/artisan backup:run --only-db';

            $returnCode = 0;
            exec($command, $output, $returnCode);

            if ($returnCode === 0) {
                $backupPath = $this->getLatestBackupPath();
                Log::info('Backup created successfully. Path: ' . $backupPath);
                return $backupPath;
            } else {
                Log::error('Backup command failed. Return code: ' . $returnCode);
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
            // Handle the error if needed
        }

        abort(500, 'Failed to create the backup.');
    }

    protected function getLatestBackupPath()
    {
        $backupsDirectory = storage_path('app/1pv3NH0nzAIVhZmN3E7JE9ARgamS4sS4Y');
        $files = scandir($backupsDirectory, SCANDIR_SORT_DESCENDING);

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                return $backupsDirectory . '/' . $file;
            }
        }

        return null;
    }
}

