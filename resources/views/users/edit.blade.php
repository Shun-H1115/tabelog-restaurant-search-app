@extends('layouts.app')
 
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <span>
                <a href="{{ route('mypage') }}">マイページ</a> > 会員情報の編集
            </span>

            <h1 class="mt-3 mb-3">会員情報の編集</h1>
            <hr>

            <form method="POST" action="{{ route('mypage.update') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="name" class="text-md-left tabelog-edit-user-info-label">氏名</label>
                    </div>
                    <div class="collapse show editUserName">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus placeholder="侍 太郎">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>氏名を入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="email" class="text-md-left tabelog-edit-user-info-label">メールアドレス</label>
                    </div>
                    <div class="collapse show editUserMail">
                        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email" autofocus placeholder="samurai@samurai.com">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>メールアドレスを入力してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                <div class="form-group">
                <div class="d-flex justify-content-between">
                        <label for="img" class="text-md-left tabelog-edit-user-info-label">画像</label>
                    </div>
                    <div class="collapse show editUserImg">
                        <input id="img" type="file" class="form-control @error('img') is-invalid @enderror" name="img" value="{{ $user->img_path }}" required autocomplete="img" autofocus placeholder="XXX-XXXX">
                        @error('img')
                        <span class="invalid-feedback" role="alert">
                            <strong>アイコン画像を選択してください</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <br>

                
                <hr>
                <button type="submit" class="btn tabelog-submit-button mt-3 w-25">
                    保存
                </button>
            </form>
        </div>
    </div>
</div>
@endsection