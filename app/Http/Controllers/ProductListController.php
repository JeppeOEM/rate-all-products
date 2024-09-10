<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductListController extends Controller
{
    public function index(Request $request)
    {
        return inertia('ProductList/Index', [
            'products' => Product::query()
                ->when($request->input('search'), function ($query, $search) {
                    $query->where('description', 'like', "%{$search}%");
                })->paginate(16)
                ->withQueryString()
                ->through(fn($product) => [
                    'id' => $product->id,
                    'description' => $product->description,
                    'price' => $product->price,
                    'shop_id' => $product->shop_idname,
                ])
        ]);
    }
}

