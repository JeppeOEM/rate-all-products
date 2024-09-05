<?php

namespace App\Console\Commands;

use App\Services\FileHandler\FileHandler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

use App\Services\FileHandler\XmlFileHandlerSoapPrefix;
use League\CommonMark\Util\Xml;
use Exception;

class DownloadProducts extends Command
{
    protected $signature = 'app:download-products';
    protected $description = 'Load products from file to database';

    public function handle(): void
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
        $rows = $fileHandler->parseFile($file);
        $fileHandler->saveToDb($rows);
        $fileHandler->moveFile($file);
    }

    private function createFileHandler($mimetype): XmlFileHandlerSoapPrefix
    {
        switch ($mimetype) {
            case 'text/xml':
            case 'application/xml':
                return new XmlFileHandlerSoapPrefix();
            default:
                throw new Exception('Unsupported file type: ' . $mimetype);
        }
    }
}
