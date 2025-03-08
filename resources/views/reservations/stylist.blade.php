@extends('layouts.app')

@section('content')

test_stylist
@foreach($stylists as $stylist)
    <p>名前：{{$stylist->name}}</p>
@endforeach

@endsection