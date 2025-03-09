@extends('layouts.app')

@section('content')
    <h2>予約フォーム</h2>

    <form action="{{ route('reservations.create') }}" method="POST">
        @csrf
        
        <label for="date">予約日：</label>
        <input type="date" id="date" name="date" required>
        <br><br>

        <label for="time">予約時間：</label>
        <input type="time" id="time" name="time" required>
        <br><br>

        <button type="submit">予約する</button>
    </form>
@endsection

