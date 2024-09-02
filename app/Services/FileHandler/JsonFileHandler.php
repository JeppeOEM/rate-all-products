<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Exception;
class JsonFileHandler extends FileHandler implements FileHandlerInterface {

    public function parseFile(string $file) : Collection {
        try {
            $filePath = Storage::path($file);
            $jsonString = file_get_contents($filePath);
            $jsonArray = json_decode($jsonString, true);
            $jsonCollection = collect($jsonArray);
            $this->moveFile($file);
            return $jsonCollection;
        } catch (Exception $e) {
            echo "An error occurred while parsing the JSON file: " . $e->getMessage();
        }
    }
}