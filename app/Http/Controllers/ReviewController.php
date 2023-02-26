<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Shop;
use App\Models\GoodTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // HTTPリクエストを送るURL
    private const REQUEST_URL = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';

    // APIキー
    private $api_key;

    public function index(Shop $shops, Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Shop $shops, Request $request)
    {
        $shops_info = new Shop();
        $shops_info->id = $request->input('shop_id');
        $shops_list = Shop::where('id', $request->input('shop_id'))->first();
        $shops_info->name = $shops_list->name;

        $user = Auth::user();
        
        return view('reviews.create', compact('shops_info', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Shop $shops, Review $reviews)
    {
        $request->validate([
            'title' => 'required',
            'comment' => 'required',
            'five_star' => 'required',
        ]);

        $flash_message = 'レビューを投稿しました。';

        $shops_info = new Shop();
        $shop_id = $request->input('shop_id');
        $shops_info = Shop::where('id', $request->input('shop_id'))->first();
        $shop_id2 = $shops_info->shop_id;
        $reviews_id = Review::max('id') + 1;

        $reviews = new Review();
        $reviews->title = $request->input('title');
        $reviews->comment = $request->input('comment');
        $reviews->five_star = $request->input('five_star');
        $reviews->shop_id = $shop_id;
        $reviews->user_id = Auth::user()->id;

        if($request->img){
            if($request->img->extension() == 'jpeg' || $request->img->extension() == 'jpg' || $request->img->extension() == 'png'){
                $request->file('img')->storeAs('public/img/reviews', $reviews_id.'.'.$request->img->extension());
                $reviews->img_path = 'public/img/reviews/'.$reviews_id.'.'.$request->img->extension();
            }else{
                $flash_message = '投稿可能なファイルは jpeg / jpg / png のみです。';
                $reviews->img_path = NULL;
            }
        }

        $reviews->save();

        return redirect()->route('reviews.show.get', $shop_id2)->with('flash_message');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review, Shop $shops)
    {
        $request->validate([
            'title' => 'required',
            'comment' => 'required',
            'five_star' => 'required',
        ]);

        $flash_message = 'レビューを修正しました。';

        $shops_info = new Shop();
        $shops_info = Shop::where('id', $request->input('shop_id'))->first();
        $shop_id2 = $shops_info->shop_id;


        $reviews->title = $request->input('title');
        $reviews->comment = $request->input('comment');
        $reviews->five_star = $request->input('five_star');

        if($request->img){
            if($request->img->extension() == 'jpeg' || $request->img->extension() == 'jpg' || $request->img->extension() == 'png'){
                $request->file('img')->storeAs('public/img/reviews', $reviews->id.'.'.$request->img->extension());
                $reviews->img_path = 'public/img/reviews/'.$reviews->id.'.'.$request->img->extension();
            }else{
                $flash_message = '投稿可能なファイルは jpeg / jpg / png のみです。';
            }
        }

        $reviews->save();

        return redirect()->route('reviews.show.get', $shop_id2)->with('flash_message');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review, Shop $shops)
    {
        $review->delete();

        $shops_info = new Shop();
        $shops_info = Shop::where('id', $request->input('shop_id'))->first();
        $shop_id2 = $shops_info->shop_id;

        return redirect()->route('reviews.show.get', $shop_id2)->with('flash_message',  '投稿を削除しました。');
    }
}
