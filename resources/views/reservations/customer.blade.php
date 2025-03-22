
@extends('layouts.app')

@section('content')


test_customer<br><br>
@foreach($customers as $customer)
    <div>名前：{{$customer->name}}</div>
    <div>EMAL：{{$customer->email}}</div>
    <div>
            <a href="{{ route('customers.trash', ['customer_id' => $customer->id]) }}" 
               onclick="return confirm('この予約をゴミ箱に入れますか？')">ゴミ箱へ</a>
    </div><br>
@endforeach

@endsection