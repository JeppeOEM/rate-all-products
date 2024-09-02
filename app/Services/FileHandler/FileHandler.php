<?php 

namespace App\Services\FileHandler;

use Illuminate\Support\Facades\Storage;
use Exception;

class FileHandler {
    
    public function getArchivedList() : array {
        $allFiles = Storage::allFiles('/archive');
        return $allFiles;
    }
    public function getUnimportedList() : array {
        $allFiles = Storage::allFiles('/unimported');
        return $allFiles;
    }
    protected function moveFile(string $filepath) : bool {
        $folder = 'unimported/';
        if (strpos($filepath, $folder) === false) {
            throw new Exception("The file path does not contain '/unimported/': $filepath");
        }
        $timestamp=time();
        $fileName = str_replace($folder,'', $filepath);
        $newFilepath = "/archive/" . $timestamp . '_' . $fileName;
        return Storage::move($filepath, $newFilepath);
    }
   
  }

