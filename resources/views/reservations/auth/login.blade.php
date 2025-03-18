@extends('layouts.app')

@section('content')

<h1>ログイン</h1>

@if($errors->any())
    <div class = 'alert-danger'>
        <ul>
            @foreach ($errors->all() as $error)
            <font color="red"> <li>{{ $error }}</li> </font>
            @endforeach
        </ul>
    </div>
    <br><br>
@endif

@if(session('error'))
    <div class="alert-danger">
    <font color="red"> {{ session('error') }} </font>
    </div>
    <br><br>
@endif

@if(session('success'))
    <div class="alert-success">
       <font color="green"> {{ session('success') }} </font>
    </div>
    <br><br>
@endif

<!-- ログインフォーム -->
<form action="{{ route('reservations.auth.login') }}" method="POST">
        @csrf

        <div>
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">ログイン情報を記憶する</label>
        </div>

        <div>
            <button type="submit">ログイン</button>
        </div>
    </form>

@endsection