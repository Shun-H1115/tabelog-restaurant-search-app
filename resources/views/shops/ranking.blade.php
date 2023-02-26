@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/tabelog.css') }}" rel="stylesheet">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ランキング</title>
</head>
<body>
    <header>
        <h2>ランキング</h2>
    </header>  

    <main>
        <div>
            <table border="1">
                <tr>
                    <th>ランキング</th>
                    <th>平均評価</th>
                    <th>店舗</th>
                </tr>

                @foreach($ranking_lists as $ranking_list)
                <tr>
                    <td><h2 text_align='center'>{{{ $ranking_list['rank'] }}}</h2></td>
                    @if ($ranking_list['five_star_avg_int'] == '0')
                        <td>☆☆☆☆☆ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @elseif ($ranking_list['five_star_avg_int'] == '1')
                        <td>★☆☆☆☆ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @elseif ($ranking_list['five_star_avg_int'] == '2')
                        <td>★★☆☆☆ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @elseif ($ranking_list['five_star_avg_int'] == '3')
                        <td>★★★☆☆ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @elseif ($ranking_list['five_star_avg_int'] == '4')
                        <td>★★★★☆ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @elseif ($ranking_list['five_star_avg_int'] == '5')
                        <td>★★★★★ {{{ $ranking_list['five_star_avg'] }}}</td>
                    @endif
                    
                    <td>
                    <article>
                        <figure>
                            <img src="{{ $ranking_list['img_path'] }}">
                        </figure>
                        <div class="text_content">
                            <h2>{{{ $ranking_list['name'] }}}</h2>
                            <p>住所：{{{ $ranking_list['address'] }}}</p>
                            <p>営業時間：{{{ $ranking_list['open'] }}}</p>
                            <p><a href="{{{ $ranking_list['urls'] }}}">{{{ $ranking_list['urls'] }}}</a></p>
                        
                            <form action="{{ route('reviews.show', $ranking_list['shop_id']) }}" method="post">
                                @csrf
                                <input type="hidden" name="shop_id" value="{{ $ranking_list['shop_id'] }}">
                                <input type="hidden" name="name" value="{{ $ranking_list['name'] }}">
                                <input type="hidden" name="open" value="{{ $ranking_list['open'] }}">
                                <input type="hidden" name="address" value="{{ $ranking_list['address'] }}">
                                <input type="hidden" name="urls" value="{{ $ranking_list['urls'] }}">
                                <input type="hidden" name="img_path" value="{{ $ranking_list['img_path'] }}">
                                <button type="submit" class="btn btn-primary">詳細</button>
                            </form>
                        </div>
                    </article>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
        
    </main>

</body>
</html>
@endsection

