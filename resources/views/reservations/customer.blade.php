test_customer
@foreach($customers as $customer)
    <p>名前：{{$customer->name}}</p>
    <p>担当スタイリスト：{{$customer->email}}</p>
@endforeach