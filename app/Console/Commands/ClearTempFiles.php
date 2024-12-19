<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ClearTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:temp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old files from public/storage/temp directory';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $publicstorage = Storage::disk('public');
        // "public" disk üzerinden "temp" klasöründeki tüm dosyaları al
        $files = $publicstorage->files('temp');

        foreach ($files as $file) {
            // Dosyanın son değişiklik zaman damgasını al
            $lastModified = $publicstorage->lastModified($file);

            // Dosya 1 saatten (3600 saniye) daha eski ise sil
            if (time() - $lastModified > 3600) {
                $publicstorage->delete($file);
            }
        }

        $this->info('Old temp files have been cleared successfully.');
        return Command::SUCCESS;
    }
}
