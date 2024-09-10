<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {

        return inertia('ProductList/Index', [
            'products' => Product::paginate(16)->through(fn($product) => [
                'id' => $product->id,
                'description' => $product->description,
               'price' => $product->price,
               'shop_id' => $product->shop_id,
            ])
        ]);

    }


    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }



}