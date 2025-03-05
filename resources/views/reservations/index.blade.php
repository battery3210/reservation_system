
test

<br><br>
@foreach($search_reservation_index as $uu)
<p>該当予約日時：{{$uu->reservation_datetime}}</p>
<p>該当日時担当スタイリスト：{{$uu->stylist->name}}</p>
@endforeach

<br><br>
@foreach($reservations as $reservation)
    <p>予約日時：{{$reservation->reservation_datetime}}</p>
    <p>担当スタイリスト：{{$reservation->stylist->name}}</p>
    <p>お客様：{{$reservation->customer->name}}</p>
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

