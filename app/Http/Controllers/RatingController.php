<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    /** wc
     * Store a newly created rating in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:6',
            'comment' => 'string'
        ]);

        $product = Product::findOrFail($productId);

        $rating = new Rating();
        $rating->rating = $request->input('rating');
        if ($request->has('comment')) {
            $rating->comment = $request->input('comment');
        }
        $rating->user_id = Auth::id();
        $rating->product_id = $product->id;
        $rating->save();

        return response()->json(['message' => 'Rating added successfully'], 201);
    }

    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);

        if ($rating->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $rating->delete();

        return response()->json(['message' => 'Rating deleted successfully'], 200);
    }

}