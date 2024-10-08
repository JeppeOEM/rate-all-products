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
    public function moveFile(string $filepath) : void {
        $folder = 'unimported/';
        if (strpos($filepath, $folder) === false) {
            throw new Exception("The file path does not contain '/unimported/': $filepath");
        }
        $timestamp=time();
        $fileName = str_replace($folder,'', $filepath);
        $newFilepath = "/archive/" . $timestamp . '_' . $fileName;
        Storage::move($filepath, $newFilepath);
    }
   
  }

