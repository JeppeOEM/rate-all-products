<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class CsvFileHandler extends FileHandler
{
    private $delimiter;

    public function __construct($delimiter = ';')
    {
        if (strlen($delimiter) !== 1) {
            throw new \InvalidArgumentException("Delimiter must be a single character.");
        }
        $this->delimiter = $delimiter;
    }

    public function parseFile($file) : array
    {
        $filePath = Storage::path($file);
        $fileHandle = fopen($filePath, 'r');

        if ($fileHandle === false) {
            throw new FileNotFoundException("Unable to open file: $file");
        }

        $rows = collect();
        $header = fgetcsv($fileHandle,0, $this->delimiter);
        $header = collect($header);

        while (($row = fgetcsv($fileHandle,0, $this->delimiter)) !== false) {
            $rows->push($row);
        }

        fclose($fileHandle);

        $headerCount = $header->count();
        foreach ($rows as $row) {
            if (count($row) !== $headerCount) {
                throw new ValidationException("The number of columns in the header does not match the number of columns in the row.");
            }
        }

        $this->moveFile($file);

        dd($rows, $header);


        return [$rows, $header];
    }
}
