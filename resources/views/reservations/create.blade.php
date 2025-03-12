@extends('layouts.app')

@section('content')

@if($errors->any())
    <div class = 'alert-danger'>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    <br><br>
@endif

@if(session('error'))
    <div class="alert-danger">
        {{ session('error') }}
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
        
        <label for="date">予約日：</label>
        <input type="date" id="date" name="date" value="{{ old('date') }}" required>
        <br>

        <label for="time">予約時間：</label>
        <input type="time" id="time" name="time"value="{{ old('time') }}" required>
        <br>

        <label for="date">スタイリスト：</label>
        <select id='stylist' name='stylist_id' required>
                <option>選択して下さい</option>
            @foreach($stylists as $stylist)
                <option value="{{ $stylist->id }}" >
                    {{ $stylist->name }}
                </option>
            @endforeach
        </select>
        <br><br>
        <button type="submit">予約する</button>
    </form>
@endsection

