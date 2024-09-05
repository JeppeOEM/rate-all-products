<?php

namespace App\Services\FileHandler;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Exception;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class XmlFileHandlerSoapPrefix extends FileHandler implements FileHandlerInterface
{
    public function parseFile(string $file): Collection
    {
        $xml = Storage::get($file);
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
        $xml = simplexml_load_string($xml);
        $xml = $xml->SoapBody->ReadMultiple_Result->ReadMultiple_Result;
        $responseArray = json_decode(json_encode($xml), true);
        return collect($responseArray);
    }

    private function productType(string $stringBool): string
    {
        switch ($stringBool) {
            case 'true':
                return 'simple';
            case 'false':
                return 'subcategory';
        }
    }

    public function saveToDb(Collection $rows): bool
    {

        Log::Info("New saving files query initialized");
        $insertedCount = 0;
        $failedCount = 0;

        foreach ($rows['Vareoversigt'] as $row) {
            try {
                Product::create([
                    'sku' => $row['Key'],
                    'no' => $row['No'],
                    'product_type' => $this->productType($row['Own_Item']),
                    'parent_id' => null,
                    'shop_id' => $row['Vendor_No'],
                    'description' => $row['Description'],
                    'price' => $row['Unit_Price'],
                    'cost_price' => $row['Unit_Cost'],
                    'discount' => $row['Discount'] ?? 0,
                    'currency' => $row['Currency'] ?? 'DKK',
                    'visible' => $row['Visible_on_Web'] ?? false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $insertedCount++;
            } catch (Exception $e) {
                echo "An error occurred while saving a product: " . $e->getMessage();
                $failedCount++;
                Log::error('Failed to save product', [
                    'error' => $e->getMessage(),
                    'product' => $row
                ]);
            }
        }

        echo "\nInserted $insertedCount products.\n";
        if ($failedCount > 0) {
            echo "Failed to insert $failedCount products.\n";
        } 
        
        
        Log::info('Database save summary', [
            'inserted' => $insertedCount,
            'failed' => $failedCount
        ]);
        return $failedCount === 0;
    }
}
