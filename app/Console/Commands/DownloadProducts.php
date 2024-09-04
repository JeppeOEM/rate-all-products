<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\FileHandler\CsvFileHandler;
use App\Services\FileHandler\JsonFileHandler;
use App\Services\FileHandler\XmlFileHandler;

class DownloadProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-products {file?} {--delimiter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load products from file to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $delimiter = $this->option('delimiter');
        $file = $this->argument('file');

        if ($file) {
            $file = 'unimported/' . $file;
            if (!Storage::exists($file)) {
                $this->error("File $file does not exist.");
                return;
            }
        } else {
            $files = Storage::files('unimported');
            if (empty($files)) {
                $this->info('No files found in the unimported folder.');
                return;
            }
            $file = $this->choice('Please choose a XML file to import', $files);
        }

        $mimeType = Storage::mimeType($file);
        $this->info("You have selected: $file");
        $fileHandler = $this->createFileHandler($mimeType, $delimiter);

        if ($fileHandler) {
            $fileHandler->parseFileSoap($file);
        } else {
            $this->error('Unsupported file type: ' . $mimeType);
        }
    }

    private function createFileHandler($mimetype, $delimiter)
    {
        switch ($mimetype) {
            case 'text/xml':
            case 'application/xml':
                return new XmlFileHandler();
            }
    }
}

