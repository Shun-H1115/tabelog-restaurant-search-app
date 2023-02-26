@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/tabelog.css') }}" rel="stylesheet">
    <title>お気に入りリスト</title>
</head>
<body>
    <header>
        <h2>お気に入りリスト</h2>
    </header>  

    <main>
        @foreach($shops_lists as $shops_list)
        <article>
            <figure>
                <img src="{{ $shops_list['img_path'] }}">
            </figure>
            <div class="text_content">
                <h2>{{{ $shops_list['name'] }}}</h2>
                <p>住所：{{{ $shops_list['address'] }}}</p>
                <p>営業時間：{{{ $shops_list['open'] }}}</p>
                <p><a href="{{{ $shops_list['urls'] }}}">{{{ $shops_list['urls'] }}}</a></p>
            
                <form action="{{ route('reviews.show', $shops_list['shop_id']) }}" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shops_list['shop_id'] }}">
                    <input type="hidden" name="name" value="{{ $shops_list['name'] }}">
                    <input type="hidden" name="open" value="{{ $shops_list['open'] }}">
                    <input type="hidden" name="address" value="{{ $shops_list['address'] }}">
                    <input type="hidden" name="urls" value="{{ $shops_list['urls'] }}">
                    <input type="hidden" name="img_path" value="{{ $shops_list['img_path'] }}">
                    <button type="submit" class="btn btn-primary">詳細</button>
                </form>
                <form action="{{ route('unfavorite', $shops_list['id']) }}" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $shops_list['id'] }}">
                    <button type="submit" class="btn btn-primary">お気に入り削除</button>
                </form>
            </div>
        </article>
        @endforeach
        
    </main>

</body>
</html>
@endsection

