<header>
    <div class="header__inner">
        <div class="header__title"><a href="{{ route('reservations.index') }}" >Reservation System</a></div>
        <ul class="header__ul">
                <!-- <li><a href="{{ route('reservations.index') }}" >TOP</a></li> -->
                <li><a href="{{ route('reservations.create') }}" >予約する</a></li>
                <li><a href="{{ route('reservations.customer') }}" >お客様一覧</a></li>
                <li><a href="{{ route('reservations.stylist') }}" >スタイリスト一覧</a></li>
                @if (Auth::check())
                <li><a href="{{ route('logout') }}" >ログアウト</a></li>
                @else
                <li><a href="{{ route('reservations.auth.login') }}" >ログイン</a></li>
                <li><a href="{{ route('reservations.register') }}" >新規登録</a></li>
                @endif
        </ul>
    </div>
</header>