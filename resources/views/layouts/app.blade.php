<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '予約システムaacc')</title>
</head>
<body>

 @include('partials.header')  {{-- ←ここで共通メニューを読み込み --}}

 @yield('content')  {{-- 各ページ固有の内容がここに入る --}}

</body>
</html>
