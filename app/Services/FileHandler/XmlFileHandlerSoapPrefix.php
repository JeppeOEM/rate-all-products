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

    private function productType(string $cost): string
    {
        $category = null;

        if (is_numeric($cost)){
        if ($cost === '0'){
            $category = 'subcategory';
        }
        else {
            $category = 'simple';
        }
        }

        return $category;

    }

    public function saveToDb(Collection $rows): bool
    {

        Log::Info("New saving files query initialized");
        $insertedCount = 0;
        $failedCount = 0;

        foreach ($rows['Vareoversigt'] as $row) {
            try {
                $product = Product::firstOrNew([
                    'sku' => $row['Key'],
                    'no' => $row['No']
                ]);

                $product->fill([
                    'product_type' => $this->productType($row['Unit_Cost']),
                    'parent_id' => null,
                    'shop_id' => $row['Vendor_No'] ?? null,
                    'description' => $row['Description'] ?? null,
                    'price' => $row['Unit_Price'] ?? null,
                    'cost_price' => $row['Unit_Cost'] ?? null,
                    'discount' => $row['Discount'] ?? 0,
                    'currency' => $row['Currency'] ?? 'DKK',
                    'visible' => $row['Visible_on_Web'] ?? false,
                ]);

                $product->save();
                $insertedCount++;
            } catch (Exception $e) {
                echo "An error occurred while saving the product: " . $e->getMessage();
                Log::error('Failed to save product', [
                    'error' => $e->getMessage(),
                    'product' => $row
                ]);
                $failedCount++;
            }
        }

        Log::info('Database save summary', [
            'inserted' => $insertedCount,
            'failed' => $failedCount
        ]);
        return $failedCount === 0;
    }
}
