@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/tabelog.css') }}" rel="stylesheet">
    <title>食べログ</title>
</head>
<body>
    <header>
        <h1 class="headline">
            <a>店舗一覧</a>
        </h1>

        <a href="{{ route('shops.ranking') }}" style="color:#000000">口コミランキング</a>

    </header>

    <main>
        <!-- 検索フォーム -->
        <form id="basicSearchForm" action="{{ route('shops.index') }}" method="get" class>
			<input type="text" name="input1" size="40">
            <input type="submit" value="検索">
            @csrf 
        </form>


        <!-- 店舗情報 -->
        
        
        <!-- テーブルに店舗情報を記載＃店舗名＃URL（＃☆☆☆☆☆＃口コミ） -->
        <?php for ($i = 0; $i < $shops['results_returned']; $i++) : ?>
            <article>
                <figure>
                    <img src="{{ $shops['shop'][$i]['photo']['pc']['l'] }}">
                </figure>
                <div class="text_content">
                    <h2>{{{ $shops['shop'][$i]['name'] }}}</h2>
                    <p>住所：{{{ $shops['shop'][$i]['address'] }}}</p>
                    <p>営業時間：{{{ $shops['shop'][$i]['open'] }}}</p>
                    <p><a href="{{{ $shops['shop'][$i]['urls']['pc'] }}}">{{{ $shops['shop'][$i]['urls']['pc'] }}}</a></p>
                
                    <form action="{{ route('reviews.show', $shops['shop'][$i]['id']) }}" method="post">
                        @csrf
                        <input type="hidden" name="shop_id" value="{{ $shops['shop'][$i]['id'] }}">
                        <input type="hidden" name="name" value="{{ $shops['shop'][$i]['name'] }}">
                        <input type="hidden" name="open" value="{{ $shops['shop'][$i]['open'] }}">
                        <input type="hidden" name="address" value="{{ $shops['shop'][$i]['address'] }}">
                        <input type="hidden" name="urls" value="{{ $shops['shop'][$i]['urls']['pc'] }}">
                        <input type="hidden" name="img_path" value="{{ $shops['shop'][$i]['photo']['pc']['l'] }}">
                        <button type="submit" class="btn btn-primary">詳細</button>
                    </form>
                </div>
            </article>
        <?php endfor; ?>

    </main>
</body>
</html>
@endsection
