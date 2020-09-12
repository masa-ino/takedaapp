<?php

use App\Http\Controllers\User;
use App\Http\Controllers\Admin;
?>

<!DOCTYPE html>

<html lang="ja">

<head>
  <meta charset="utf-8">
  <meta name="author" content="">
  <title>武田塾特訓管理</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="icon" href="assets/img/black.png">
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">

  <!-- CSS -->

  <!-- Font Awesome Icons -->
  <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">

  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
  <link rel="stylesheet" href="{{ asset('css/uikit.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <!-- JavaScript -->
  <script src="{{ asset('/js/jquery-3.5.0.min.js') }}"></script>
  <script src="{{ asset('/js/uikit.min.js') }}"></script>
  <script src="{{ asset('/js/uikit-icons.min.js') }}"></script>
  <script src="{{ asset('/js/main.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

</head>

<body>
  <!-- HEADER
    ================================================== -->
  <header>
    <nav class="uk-navbar-container uk-margin header_nav" uk-navbar>
      <div class="uk-navbar-left">

        <a class="uk-navbar-item uk-logo" href="#">武田塾特訓管理アプリ</a>
      </div>
      <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          @if((Auth::guard('user')->check()))
          <li><a href="{{ url('/user/home') }}">ホーム</a></li>
          <li><a href="{{ route('user.logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

          </li>
          @elseif((Auth::guard('admin')->check()))
          <li><a href="{{ url('/admin/home') }}">ホーム</a></li>
          <li><a href="{{ route('admin.logout') }}" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">ログアウト</a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
              @csrf
            </form>

          </li>
          @else
          <li><a href="{{route('admin.login')}}">管理者ログイン</a></li>
          <li><a href="{{route('user.login')}}">講師ログイン</a></li>
          @endif
        </ul>
      </div>
    </nav>
  </header>
  @yield('content')


  <footer>
  </footer>
</body>

</html>