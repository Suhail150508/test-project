<?php

namespace App\Jobs;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class FileBackupJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Run the backup command
        $projectPath = base_path();
        $command = 'php ' . $projectPath . '/artisan backup:run';
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode === 0) {
            // Get the path to the latest backup file
            $backupPath = $this->getLatestBackupPath();
            return $backupPath;
        }

        abort(500, 'Failed to create the backup.');

        // Run the backup command
        /*$projectPath = base_path();
        $command = 'php ' . $projectPath . '/artisan backup:run';
        $returnCode = 0;
        exec($command, $output, $returnCode);

        if ($returnCode !== 0) {
            abort(500, 'Failed to create the backup.');
        }*/
    }

    protected function getLatestBackupPath()
    {
        // Get the path to the latest backup file
        $backupsDirectory = storage_path('app');
        $files = scandir($backupsDirectory, SCANDIR_SORT_DESCENDING);

        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                return $backupsDirectory . '/' . $file;
            }
        }

        return null;
    }
}
