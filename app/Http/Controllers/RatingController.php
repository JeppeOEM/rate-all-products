<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:6',
            'comment' => 'string'
        ]);

        $rating = new Rating();
        $rating->rating = $request->input('rating');
        if ($request->has('comment')) {
            $rating->comment = $request->input('comment');
        }
        $rating->user_id = Auth::id();
        $rating->product_id = $product->id;
        $rating->save();

        return redirect()->route('product.show', $product->id)->with('success', 'Rating added successfully');
    }


    public function destroy(Rating $rating)
    {
        if ($rating->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $productId = $rating->product_id;
        $rating->delete();

        return redirect()->route('product.show', $productId)->with('success', 'Rating deleted successfully');
    }
}