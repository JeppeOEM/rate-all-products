<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Inertia\Response;

class ProductController extends Controller
{


    public function index(Request $request): Response
    {
        $products = Product::query()
            ->where('product_type', 'simple')
            ->where('price', '>', 0) 
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


    public function show(Product $product): Response
    {

        $product->load('ratings');


        $firstWord = strtok($product->description, ' ');

        $relatedProducts = Product::query()
            ->where('shop_id', $product->shop_id)
            ->where('product_type', 'simple')
            ->where('id', '!=', $product->id)
            ->whereRaw('substr(description, 1, instr(description || " ", " ") - 1) = ?', [$firstWord])
            ->get();

        return inertia('Product/SingleProduct', [
            'product' => $product,
            'ratings' => $product->ratings,
            'avg_rating' => $product->getAverageRating(),
            'related_products' => $relatedProducts
        ]);
    }
}
