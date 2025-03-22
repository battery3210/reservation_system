@extends('layouts.app')

@section('content')

<h1 class="m_top150">会員登録</h1>

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

<!-- 会員登録フォーム -->
<form action="{{ route('reservations.register') }}" method="POST" class="form_register">
        @csrf

        <div>
            <label for="name">名前</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">パスワード確認</label>
            <input type="password" id="password" name="password_confirmation" required>
        </div>

        <div>
            <button type="submit">登録</button>
        </div>
    </form>


@endsection