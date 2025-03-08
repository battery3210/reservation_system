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
<p>該当予約日時：{{$uu->reservation_datetime}}</p>
<p>該当日時担当スタイリスト：{{$uu->stylist->name}}</p>
@endforeach
<br><br>
@endif


@foreach($reservations as $reservation)
    <p>予約日時：{{$reservation->reservation_datetime}}</p>
    <p>担当スタイリスト：{{$reservation->stylist->name}}</p>
    <p>お客様：{{$reservation->customer->name}}</p>
    <p>
            <a href="{{ route('reservations.trash', ['reservation_id' => $reservation->id]) }}" 
               onclick="return confirm('この予約をゴミ箱に入れますか？')">ゴミ箱へ</a>
    </p>
@endforeach
<br><br>
@foreach($stylists as $aa)
    <p>スタイリストの名前一覧{{$aa->name}}</p>
@endforeach
<br><br>
@foreach($customers as $customer)
    <p>お客様の名前一覧{{$customer->name}}</p>
    <p>お客様のメアド一覧{{$customer->email}}</p>
@endforeach

@endsection

