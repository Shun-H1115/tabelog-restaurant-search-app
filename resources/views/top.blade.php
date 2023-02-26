@extends('layouts.app')
 
@section('content')
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <title>tabelog</title>
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    <div class="shops-link">
        <a href="{{ route('shops.index') }}" style="color:#ffffff">店舗一覧</a>
        <a href="{{ route('shops.ranking') }}" style="color:#ffffff">ランキング</a>
    </div>
</head>

<body>
</body>
@endsection