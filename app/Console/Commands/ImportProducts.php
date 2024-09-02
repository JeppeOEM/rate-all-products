<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Services\FileHandler\CsvFileHandler;
use App\Services\FileHandler\JsonFileHandler;
use App\Services\FileHandler\XmlFileHandler;

class ImportProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-products {file?} {--delimiter=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load product files from Storage/unimported, provide a filename. Use --delimiter= to specify non default CSV delimiter.';

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
            $file = $this->choice('Please choose a file to import', $files);
        }

        $mimeType = Storage::mimeType($file);
        $this->info("You have selected: $file");
        $fileHandler = $this->createFileHandler($mimeType, $delimiter);
        if ($delimiter) {
            $this->info("You have selected this delimiter: $delimiter");
        }
        if ($fileHandler) {
            dd($fileHandler->parseFile($file));
        } else {
            $this->error('Unsupported file type: ' . $mimeType);
        }
    }

    private function createFileHandler($mimetype, $delimiter)
    {
        switch ($mimetype) {
            case 'text/xml':
                return new XmlFileHandler();
            case 'text/csv':
                echo $delimiter;
                return $delimiter ? new CsvFileHandler($delimiter) : new CsvFileHandler();
            case 'application/json':
                return new JsonFileHandler();
            default:
                return null;
        }
    }
}
