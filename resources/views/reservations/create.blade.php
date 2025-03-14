@extends('layouts.app')

@section('content')

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

    <h2>予約フォーム</h2>

    <br>
    <form action="{{ route('reservations.create') }}" method="POST">
        @csrf

        <label for="name">お名前:</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        <br>
        <label for="email">Email: </label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        <br><br>
        <label for="date">予約日：</label>
        <input type="date" id="date" name="date" value="{{ old('date') }}" required>
        <br>

        <label for="time">予約時間：</label>
        <!-- <input type="time" id="time" name="time"value="{{ old('time') }}" step="1800" min="10:00" max="20:00" required >
        <br> -->

        <!--datalistを使う方法:しかし手入力出来てしまう <input type="time" id="time" name="time" list="time-list"
            value="{{ old('time') }}" required>

        <datalist id="time-list">
            @for ($hour = 10; $hour <= 20; $hour++)
                <option value="{{ $hour }}:00"></option>
                <option value="{{ $hour }}:30"></option>
            @endfor
        </datalist> -->

        <select id="time" name="time" required>
            <option value = "">選択して下さい</option>
            @for ($hour=10; $hour<20; $hour++)
                <option value = "{{ $hour }}:00">{{ $hour }}:00</option>
                <option value = "{{ $hour }}:30">{{ $hour }}:30</option>
            @endfor
        </select>


        <br>

        <label for="date">スタイリスト：</label>
        <select id='stylist' name='stylist_id' required>
                <option>選択して下さい</option>
            @foreach($stylists as $stylist)
            <option value="{{ $stylist->id }}" {{ old('stylist_id') == $stylist->id ? 'selected' : ''  }} >
                    {{ $stylist->name }}
                </option>
            @endforeach
                <option value='88'>ダミースタイリスト</option>
        </select>
        <br><br>
        <button type="submit">予約する</button>
    </form>

    <br><br>

    @foreach($reservations as $reservation)
    <div>予約日時：{{$reservation->reservation_datetime}}</div>
    <div>担当スタイリスト：{{$reservation->stylist->name}}</div>
    <div>お客様：{{$reservation->customer->name}}</div>
    <p>
            <a href="{{ route('reservations.trash', ['reservation_id' => $reservation->id]) }}" 
               onclick="return confirm('この予約をゴミ箱に入れますか？')">ゴミ箱へ</a>
    </p>
    @endforeach
<br><br>
@endsection

