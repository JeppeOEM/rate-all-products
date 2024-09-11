<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Response;
class ProductController extends Controller
{


    public function index(Request $request) : Response
    {
        $products = Product::query()
            ->where('product_type', 'simple')
            ->when($request->input('search'), function ($query, $search) {
                $query->where('description', 'like', "%{$search}%");
            })
            ->paginate(16)
            ->appends($request->query());

        return inertia('Product/ProductList', [
            'products' => $products->through(fn($product) => [
                'id' => $product->id,
                'description' => $product->description,
                'price' => $product->price,
                'shop_id' => $product->shop_id,
                'currency' => $product->currency
            ])
        ]);
    }

    # Sending the model via route model binding
    public function show(Product $product) : Response
    {

        $product->load('ratings');
        return inertia('Product/SingleProduct', [
            'product' => $product,
            'ratings' => $product->ratings
        ]);
    }
}
