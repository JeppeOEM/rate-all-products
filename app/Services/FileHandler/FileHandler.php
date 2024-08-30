<?php 

namespace App\Services\FileHandler;

use Illuminate\Support\Facades\Storage;

abstract class FileHandler {
    
    public function getArchivedList() : array {
        $allFiles = Storage::allFiles('/archive');
        return $allFiles;
    }
    public function getUnimportedList() : array {
        $allFiles = Storage::allFiles('/unimported');
        return $allFiles;
    }
    protected function moveFile($filepath) : bool {
        if (strpos($filepath, 'unimported/') === false) {
            throw new \Exception("The file path does not contain '/unimported/': $filepath");
        }
        $newFilepath = str_replace('unimported/', 'archive/', $filepath);
        return Storage::move($filepath, $newFilepath);
    }
   
    abstract public function parseFile($filename);

  }

