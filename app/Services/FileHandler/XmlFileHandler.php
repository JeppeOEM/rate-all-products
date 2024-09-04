<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Exception;

class XmlFileHandler extends FileHandler implements FileHandlerInterface
{

    public function parseFile(string $file): Collection
    {
        try {
            $filePath = Storage::path($file);
            $xmlObject = simplexml_load_file($filePath);
            $xmlJson = json_encode($xmlObject);
            $xmlArray = json_decode($xmlJson, true);
            $xmlCollection = collect($xmlArray);
            $this->moveFile($file);
            return $xmlCollection;
        } catch (Exception $e) {
            echo "An error occurred while parsing the XML file: " . $e->getMessage();

        }
    }






}
