<?php

namespace App\Services\FileHandler;

use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;


class CsvFileHandler extends FileHandler implements FileHandlerInterface
{
    private $delimiter;

    public function __construct(string $delimiter = ';')
    {
        if (strlen($delimiter) !== 1) {
            echo $delimiter;
            throw new ValidationException("Delimiter must be a single character.");
        }
        $this->delimiter = $delimiter;
    }

    public function parseFile(string $file) : Collection
    {
        try {
        $filePath = Storage::path($file);
        $openFile = fopen($filePath, 'r');
        $rows = collect();
        $header = fgetcsv($openFile,0, $this->delimiter);
        $header = collect($header);

        while (($row = fgetcsv($openFile,0, $this->delimiter)) !== false) {
            $rows->push($row);
        }
        fclose($openFile);
        $headerColumns = $header->count();
        foreach ($rows as $row) {
            if (count($row) !== $headerColumns) {
                throw new Exception("The number of columns in the header does not match the number of columns in the row.");
            }
        }

        $result = collect([
            'rows' => $rows,
            'header' => $header
        ]);
        $this->moveFile($file);
        return $result; 
        }
            catch (Exception $e) {
            echo "An error occurred while parsing the CSV file: " . $e->getMessage();

        } 
    }
}