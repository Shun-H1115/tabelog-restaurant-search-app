<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Favorite $favorites, Shop $shops)
    {
        $favorites_lists = Favorite::where('user_id', Auth::id())->get();
        $favorites_lists_shop_ids = $favorites_lists->pluck('shop_id')->toArray();
        $shops_lists = [[]];
        foreach ($favorites_lists_shop_ids as $key => $favorites_lists_shop_id){
            $shops_list = Shop::where('id', $favorites_lists_shop_id)->get()->toArray();
            $shops_lists = array_merge($shops_lists, $shops_list);
        }
        array_shift($shops_lists);

        $user = Auth::user();
        
        return view('favorites.index', compact('shops_lists', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $favorites = New Favorite();
        $shop_id = $request->shop_id;
        // dd($request);
        $favorites->shop_id = $shop_id;
        $favorites->user_id = Auth::user()->id;
        $favorites->save();
        $shop_shop_id = $request->shop_shop_id;

        return redirect()->route('reviews.show.get', $shop_shop_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Favorite  $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite, Request $request)
    {
        $shop_id = $request->shop_id;
        $favorites = Favorite::where('shop_id', $shop_id)->where('user_id', Auth::user()->id)->first();
        $favorites->delete();
        $shop_shop_id = $request->shop_shop_id;

        return redirect()->route('reviews.show.get', $shop_shop_id);
    }
}
