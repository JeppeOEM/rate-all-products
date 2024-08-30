<?php



namespace App\Services\FileHandler;

class JsonFileHandler extends FileHandler {

    public function parseFile($file) {
        dd($file);
        $this->moveFile($file);
    }
}