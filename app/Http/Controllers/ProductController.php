<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        $products = Product::query()
            ->where('product_type', 'simple')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->paginate(16)
            ->appends($request->query());

        return inertia('ProductList/Index', [
            'products' => $products->through(fn($product) => [
                'id' => $product->id,
                'description' => $product->description,
                'price' => $product->price,
                'shop_id' => $product->shop_id,
                'currency' => $product->currency
            ])
        ]);
    }
}

    // public function show(Product $product)
    // {
    //     return view('products.show', compact('product'));
    // }
