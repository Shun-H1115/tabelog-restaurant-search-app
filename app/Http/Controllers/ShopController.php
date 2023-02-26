<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Review;
use App\Models\GoodTag;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\response
     */

    // HTTPリクエストを送るURL
    private const REQUEST_URL_HP = 'http://webservice.recruit.co.jp/hotpepper/gourmet/v1/';

    // APIキー
    private $api_key_HP;

    public function index(Request $request)
    {
        // インスタンス生成
        $client = new Client();

        // HTTPリクエストメソッド
        $method = 'GET';

        // APIキーを取得
        $this->api_key_HP = config('hotpepper.api_key_HP');

        // APIキーや検索ワードなどの設定を記述
        $options = [
            'query' => [
                'key' => config('hotpepper.api_key_HP'),
                'keyword' => $request->input1 ?? '新宿',
                'count' => 50,
                'format' => 'json',
            ],
        ];

        // HTTPリクエストを送信
        $response_HP = $client->request($method, self::REQUEST_URL_HP, $options);
        $shops = json_decode($response_HP->getBody(), true)['results'];
        
        $user = Auth::user();

        // index.blade.phpを表示する
        return view('shops.index', compact('shops', 'user'));

    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\response
     */
    public function show(Request $request,Review $reviews, Shop $shops, Favorite $favorites)
    {
        $shop_id = $request->input('shop_id');
        $shops_old = Shop::where('shop_id', $shop_id)->first();
        // dd($request);
        if ($shops_old==NULL){
            $shops = new Shop();
            $shops->shop_id = $shop_id;
            $shops->name = $request->input('name');
            $shops->open = $request->input('open');
            $shops->address = $request->input('address');
            $shops->urls = $request->input('urls');
            $shops->img_path = $request->input('img_path');

            $shops->save();
        }else{
            $shops = $shops_old;
        }

        $shops = Shop::where('shop_id', $shop_id)->first();

        $reviews = Review::where('shop_id', $shops->id)->get();
        
        
        if(empty($reviews)){
            $goodtag = [];
        }else{
            $goodtag = GoodTag::where('user_id', Auth::id())->get();
        }
        
        $goodtag_review_ids = $goodtag->pluck('review_id')->toArray();

        $favorites = Favorite::where('user_id', Auth::id())->first();
        if ($favorites==NULL){
            $favorites_shop_ids = [];
        }else{
            $favorites_shop_ids = $favorites->pluck('shop_id')->toArray();
        }
        
        $user = Auth::user();
        // $reviews = $restaurants->reviews()->get(); 
        // var_dump($request->input1);

        // show.blade.phpを表示する
        return view('shops.show', compact('reviews', 'shops', 'goodtag', 'goodtag_review_ids', 'favorites_shop_ids', 'user'));
    }

    public function show_v2(Request $request,Review $reviews, Shop $shops, Favorite $favorites, $shop_shop_id)
    {
        $shops = Shop::where('shop_id', $shop_shop_id)->first();

        $reviews = Review::where('shop_id', $shops->id)->get();
        
        
        if(empty($reviews)){
            $goodtag = [];
        }else{
            $goodtag = GoodTag::where('user_id', Auth::id())->get();
        }
        
        $goodtag_review_ids = $goodtag->pluck('review_id')->toArray();

        $favorites = Favorite::where('user_id', Auth::id())->first();
        if ($favorites==NULL){
            $favorites_shop_ids = [];
        }else{
            $favorites_shop_ids = $favorites->pluck('shop_id')->toArray();
        }
        
        $user = Auth::user();
        // $reviews = $restaurants->reviews()->get(); 
        // var_dump($request->input1);

        // show.blade.phpを表示する
        return view('shops.show', compact('reviews', 'shops', 'goodtag', 'goodtag_review_ids', 'favorites_shop_ids', 'user'));
    }

    public function store(Request $request, Shop $shops, $shop_shop_id)
    {
        $shop_id = $request->input('shop_id');
        $shops_old = Shop::where('shop_id', $shop_id)->first();
        if ($shops_old==NULL){
            $shops = new Shop();
            $shops->shop_id = $shop_id;
            $shops->name = $request->input('name');
            $shops->open = $request->input('open');
            $shops->address = $request->input('address');
            $shops->urls = $request->input('urls');
            $shops->img_path = $request->input('img_path');
            
            $shops->save();
        }else{
            $shops = $shops_old;
        }

        return redirect()->route('reviews.show', $shop_id);
    }
    
    public function ranking(Shop $shops, Review $reviews){
        $reviews = Review::all()->toArray();
        $reviews_shopids = array_column($reviews, 'shop_id');
        $reviews_shopids_list = array_unique($reviews_shopids);
        $ranking_lists = [[]];
        foreach ($reviews_shopids_list as $reviews_shopid){
            $reviews_clip = Review::where('shop_id', $reviews_shopid)->get()->toArray();
            $five_stars = array_column($reviews_clip, 'five_star');
            $five_stars_avg = array_sum($five_stars) / count($five_stars);
            $shops_lists = Shop::where('id', $reviews_shopid)->first();
            $ranking_list['five_star_avg'] = $five_stars_avg;
            $ranking_list['five_star_avg_int'] = round($five_stars_avg);
            $ranking_list['shop_id_fk'] = $reviews_shopid;
            $ranking_list['shop_id'] = $shops_lists->shop_id;
            $ranking_list['name'] = $shops_lists->name;
            $ranking_list['open'] = $shops_lists->open;
            $ranking_list['address'] = $shops_lists->address;
            $ranking_list['urls'] = $shops_lists->urls;
            $ranking_list['img_path'] = $shops_lists->img_path;
            $ranking_lists[] = $ranking_list;
        }

        array_shift($ranking_lists);
        array_multisort(array_column($ranking_lists, 'five_star_avg'), SORT_DESC, $ranking_lists);

        for($i=0; $i<count($reviews_shopids_list); $i++ ){
            $ranking_lists[$i]['rank'] = $i+1;
        }

        $user = Auth::user();

        return view('shops.ranking', compact('ranking_lists', 'user'));
    }

}
