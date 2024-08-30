<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Facades\Storage;

class XmlFileHandler extends FileHandler {

    public function parseFile($file) {
        $filePath = Storage::path($file);
        $xmlObject = simplexml_load_file($filePath);
        $xmlJson = json_encode($xmlObject); 
        $xmlArray = json_decode($xmlJson, true);
        $xmlCollection = collect($xmlArray);
        $this->moveFile($file);
        dd($xmlCollection);
        return $xmlCollection;
    }
}