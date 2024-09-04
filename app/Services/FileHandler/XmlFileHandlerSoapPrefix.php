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
        $responseArray = json_decode(json_encode($xml));
        return collect($responseArray);
    }


    public function saveToDb(Collection $rows): void
    {
        foreach ($rows as $row) {
            try {
                Product::create([
                    'sku' => $row['No'] ?? null,
                    'no' => $row['No'] ?? null,
                    'product_type' => $row['Product_Type'] ?? 'simple',
                    'parent_id' => $row['Parent_Id'] ?? null,
                    'shop_id' => $row['Shop_Id'] ?? 1,
                    'description' => $row['Description'] ?? '',
                    'price' => $row['Unit_Price'] ?? 0,
                    'cost_price' => $row['Unit_Cost'] ?? 0,
                    'discount' => $row['Discount'] ?? 0,
                    'currency' => $row['Currency'] ?? 'USD',
                    'visible' => isset($row['Visible_on_Web']) ? $row['Visible_on_Web'] === 'true' : false,
                    'created_at' => $row['Created_At'] ?? now(),
                    'updated_at' => $row['Updated_At'] ?? now(),
                ]);
            } catch (Exception $e) {
                echo "An error occurred while saving the product: " . $e->getMessage();
                Log::error('Failed to save product', [
                    'error' => $e->getMessage(),
                    'product' => $row
                ]);
            }
        }
    }
}
