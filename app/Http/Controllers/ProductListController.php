<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductListController extends Controller
{
    public function index()
    {

        return inertia('ProductList/Index', [
            'products' => Product::paginate(16)->through(fn($product) => [
                'id' => $product->id,
                'description' => $product->description
            ])
        ]);

    }
}