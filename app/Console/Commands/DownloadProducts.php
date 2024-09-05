<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use App\Services\FileHandler\XmlFileHandlerSoapPrefix;

class DownloadProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:download-products';

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


            $files = Storage::files('unimported');
            if (empty($files)) {
                $this->info('No files found in the unimported folder.');
                return;
            }
            $file = $this->choice('Please choose a XML file to import', $files);
        

        $mimeType = Storage::mimeType($file);
        $this->info("You have selected: $file");
        $fileHandler = $this->createFileHandler($mimeType);

        if ($fileHandler) {
            $rows = $fileHandler->parseFile($file);
            $fileHandler->saveToDb($rows);
        } else {
            $this->error('Unsupported file type: ' . $mimeType);
        }
    }

    private function createFileHandler($mimetype)
    {
        switch ($mimetype) {
            case 'text/xml':
            case 'application/xml':
                return new XmlFileHandlerSoapPrefix();
            }
    }
}

