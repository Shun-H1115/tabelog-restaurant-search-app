@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{{ $shops_info->name }}}レビュー投稿</title>
</head>
<body>
    <header>
        <h2>{{{ $shops_info->name }}}レビュー投稿</h2>
    </header>  
    
    <main>
        

        <!-- レビューの書き込み -->
        @auth
        <div>
            <form method="POST" action="{{ route('reviews.store') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <h4>タイトル</h4>
                    @error('title')
                        <strong>タイトルを入力してください</strong>
                    @enderror
                    <input id="title" type="text" name="title" class="form-control m-2">
                </div><br>
            
                <div>
                    <h4>評価</h4>
                    @error('five_star')
                        <strong>評価を選択してください</strong>
                    @enderror
                    <select id="five_star" name="five_star" class="form-control m-2">
                        <option value=0>☆☆☆☆☆</option>
                        <option value=1>★☆☆☆☆</option>
                        <option value=2>★★☆☆☆</option>
                        <option value=3>★★★☆☆</option>
                        <option value=4>★★★★☆</option>
                        <option value=5>★★★★★</option>
                    </select>
                </div><br>

                <div>
                    <h4>レビュー内容</h4>
                    @error('comment')
                        <strong>レビュー内容を入力してください</strong>
                    @enderror
                    <textarea id="comment" name="comment" class="form-control m-2"></textarea>
                </div>

                <div>
                    <h4>画像をアップロード</h4>
                    <input type="file" name="img">

                    <input type="hidden" name="shop_id" value="{{ $shops_info->id }}">
                    <button type="submit" class="btn tabelog-submit-button ml-2">レビューを投稿</button>
                </div>
            </form>
        </div>
        @endauth
    </main>

</body>
@endsection