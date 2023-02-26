<nav class="navbar navbar-expand-md navbar-light shadow-sm tabelog-header-container">
<link href="{{ asset('css/head.css') }}" rel="stylesheet">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{asset('css/images/logo.jpg')}}" width='150' height='40'>
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mr-5 mt-2">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <hr>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('login') }}"><i class="far fa-heart"></i></a>
                </li>
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-shopping-cart"></i></a>
                </li>
                @else
                <li class="nav-item mr-5">
                    <a class="nav-link" href="{{ route('mypage') }}">
                        @if ((optional($user)->img_path) != NULL)
                            <img src="{{ Storage::url($user->img_path) }}" width='35' height='35'>
                        @elseif ((optional($user)->img_path) == NULL)
                            <i class="fas fa-user mr-1"></i>
                        @endif
                        <label>マイページ</label>
                    </a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
