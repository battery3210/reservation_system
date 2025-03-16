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
        {{ session('success') }}
    </div>
    <br><br>
@endif


@if($searchByStylistAndDate)
@foreach($searchByStylistAndDate as $uu)
<div><font color = '#ff0000'>該当予約日時</font>：{{$uu->reservation_datetime}}</div>
<div><font color = '#ff0000'>該当日時担当スタイリスト</font>：{{$uu->stylist->name}}</div>
@endforeach
<br><br>
@endif


@foreach($reservations as $reservation)
    <div>予約日時：{{$reservation->reservation_datetime}}</div>
    <div>担当スタイリスト：{{$reservation->stylist->name}}</div>
    <div>お客様：{{$reservation->customer->name}}</div>
    <p>
            <a href="{{ route('reservations.trash', ['reservation_id' => $reservation->id]) }}" 
               onclick="return confirm('この予約をゴミ箱に入れますかneyo？')">ゴミ箱へ</a>
    </p>
@endforeach
<br><br>
@foreach($stylists as $aa)
    <div>スタイリストの名前: {{$aa->name}}</div>
@endforeach
<br><br>
@foreach($customers as $customer)
    <div>お客様の名前: {{$customer->name}}</div>
    <div>お客様のメアド: {{$customer->email}}</div><br>
@endforeach

@endsection

