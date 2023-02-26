<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
use App\Models\GoodTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoodTagController extends Controller
{
    public function goodtag($review_id, Review $reviews, Request $request) {

        $goodtags = New GoodTag();
        $goodtags->review_id = $review_id;
        $goodtags->user_id = Auth::user()->id;
        $reviews = Review::where('id', $review_id)->first();
        $shops = Shop::where('id', $reviews->shop_id)->first();
        $goodtags->save();

        return redirect()->route('reviews.show.get', $shops->shop_id);
    }

    public function ungoodtag($review_id, Review $reviews, Request $request) {
        $user_id = Auth::user()->id;
        $goodtags = GoodTag::where('review_id', $review_id)->where('user_id', $user_id)->first();
        $reviews = Review::where('id', $review_id)->first();
        $shops = Shop::where('id', $reviews->shop_id)->first();
        $goodtags->delete();

        return redirect()->route('reviews.show.get', $shops->shop_id);
    }
}
