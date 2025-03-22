@extends('layouts.app')

@section('content')

<div class="m_top150">
@foreach($stylists as $stylist)
    <div>名前：{{$stylist->name}}</div>
    <div>
            <a href="{{ route('stylists.trash', ['stylist_id' => $stylist->id]) }}" 
               onclick="return confirm('この予約をゴミ箱に入れますか？')">ゴミ箱へ</a>
    </div>
@endforeach
</div>
@endsection