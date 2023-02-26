@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/tabelog.css') }}" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{{ $shops->name }}}</title>
</head>
<body>
    @if (session('flash_message'))
        <p>{{ session('flash_message')}}</p>
    @endif

    
    <article>
        <figure>
            <img src="{{ $shops->img_path }}">
        </figure>
        <div class="text_content">
            <h2>{{{ $shops->name }}}</h2>
            <p>住所：{{{ $shops->address }}}</p>
            <p>営業時間：{{{ $shops->open }}}</p>
            <p><a href="{{{ $shops->urls }}}">{{{ $shops->urls }}}</a></p>
        
            @if (in_array($shops->id, $favorites_shop_ids))
                <!-- 「お気に入り」取消用ボタンを表示 -->
                <form action="{{ route('unfavorite', $shops->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shops->id }}">
                    <input type="hidden" name="shop_shop_id" value="{{ $shops->shop_id }}">
                    <button type="submit" class="btn btn-primary">★ お気に入り</button>
                </form> 
            @else
                <!-- まだユーザーが「お気に入り」をしていなければ、「お気に入り」ボタンを表示 -->
                <form action="{{ route('favorite', $shops->id) }}" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shops->id }}">
                    <input type="hidden" name="shop_shop_id" value="{{ $shops->shop_id }}">
                    <button type="submit" class="btn btn-primary">☆ お気に入り</button>
                </form>
            @endif
        </div>

        <div>
            <iframe id="map" src="https://www.google.com/maps/embed/v1/place?key={{ config('googlemap.api_key_GM') }}&q={{{ $shops->address }}}" width='100%' height='238' frameborder='0'></iframe>
        </div>
    </article>


    <!-- レビューの表示 -->
    <div class="review-boxes">
        <h3>カスタマーレビュー</h3>
        <form action="{{ route('reviews.create') }}" method="post">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shops->id }}">
            <button type="submit" class="btn btn-primary">レビューを投稿する</button>
        </form>

        @foreach($reviews as $review)
        <div class="review-box">
            @if (optional($review)->five_star == '0')
                <h3>☆☆☆☆☆  {{ optional($review)->title }}</h3>
            @elseif (optional($review)->five_star == '1')
                <h3>★☆☆☆☆  {{ optional($review)->title }}</h3>
            @elseif (optional($review)->five_star == '2')
                <h3>★★☆☆☆  {{ optional($review)->title }}</h3>
            @elseif (optional($review)->five_star == '3')
                <h3>★★★☆☆  {{ optional($review)->title }}</h3>
            @elseif (optional($review)->five_star == '4')
                <h3>★★★★☆  {{ optional($review)->title }}</h3>
            @elseif (optional($review)->five_star == '5')
                <h3>★★★★★  {{ optional($review)->title }}</h3>
            @endif
            
            <p>{{ optional($review)->comment }}</p>
            @if ((optional($review)->img_path) != NULL)
                <figure><img src="{{ Storage::url($review->img_path) }}" width='238' height='auto' ></figure>
            @elseif ((optional($review)->img_path) == NULL)
            @endif               
        
            @if (in_array(($review)->id, $goodtag_review_ids))
                <!-- 「いいね」取消用ボタンを表示 -->
                <a href="{{ route('ungoodtag', $review->id) }}" class="btn btn-success btn-sm">
                    いいね
                    <!-- 「いいね」の数を表示 -->
                    <span class="badge"> 
                        {{ $review->goodtags->count() }}
                    </span>
                </a> 
            @else
                <!-- まだユーザーが「いいね」をしていなければ、「いいね」ボタンを表示 -->
                <a href="{{ route('goodtag', $review->id) }}" class="btn btn-secondary btn-sm">
                    いいね
                    <!-- 「いいね」の数を表示 -->
                    <span class="badge">
                        {{ $review->goodtags->count() }}
                    </span>
                </a>
            @endif
                </div>
        @endforeach
    </div>



</body>
</html>
@endsection

