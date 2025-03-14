<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title', '予約システムaacc')</title>
</head>
<body>
    <div class="container">

        @include('partials.header')  {{-- ←ここで共通メニューを読み込み --}}
        <div class="content_wrap">
            <div class="all_content">
                @yield('content')  {{-- 各ページ固有の内容がここに入る --}}
            </div>
        </div>

    </div>
</body>
</html>
