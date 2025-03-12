<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Stylist;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ReservationController extends Controller
{
    ////////////////////////////////////////////////////////////////////////////////////////

    public function index(Request $request) {

        $stylists = Stylist::active()->get();
        // $customers = Customer::active()->select('id', 'name','email')->get();
        $customers = Customer::active(['id','name','email'])->get();
        $reservations = reservation::with(['stylist','customer'])->active()->get();

        // $date = $request->query('date');
        // $stylist_id = $request->query('stylist_id');

        $searchByStylistAndDate = null;

        if ($request->has('stylist_id')) {
              $validated = $request->validate([
                'date' => ['required','date'],
                'stylist_id' => ['required', 'integer', 'exists:stylists,id']
                ],
                [
                    'date.required' => '日付は必須です。',
                    'date.date' => '日付は0000-00-00のような形式で入力してください。',
                    'stylist_id.required' => 'スタイリストのIDを指定してください。',
                    'stylist_id.integer' => 'スタイリストのIDは数字で指定してください。',
                    'stylist_id.exists' => '存在しないスタイリストのIDです。',
                ]);

                //もう一つのバリデーションのやり方
                // $validator = Validator::make($request->all(), [
                //     'date' => ['required', 'date'],
                //     'stylist_id' => ['required', 'integer', 'exists:stylists,id'],
                // ]);
                // if ($validator->fails()) {
                //     return view('reservations.index', compact('reservations', 'customers', 'stylists', 'search_reservation_index'))
                //         ->withErrors($validator);
                // }

              $searchByStylistAndDate = $this->searchByStylistAndDate($validated);
        }
    
         //dd($searchByStylistAndDate);
        return view('reservations.index',compact('reservations','customers','stylists','searchByStylistAndDate'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////

    private function searchByStylistAndDate($validated) {
 
        $date = $validated['date'];
        $stylist_id = $validated['stylist_id'];
 
         $reservations_for_web = \App\Models\Reservation::with('stylist')
         ->whereDate('reservation_datetime',$date)
         ->where('stylist_id',$stylist_id)
         ->get();

         return $reservations_for_web;
 
     }

     ////////////////////////////////////////////////////////////////////////////////////////

     public function searchReservationJson(Request $request) {

        //下記のやり方でもバリデーション結果をページに返せる↓
        $validator = Validator::make($request->all(), [
            'date' => ['required', 'date'],
            'stylist_id' => ['required', 'integer', 'exists:stylists,id']
        ], [
            'date.required' => '日付は必須です。',
            'date.date' => '日付は0000-00-00のような形式で入力してください。',
            'stylist_id.required' => 'スタイリストのIDを指定してください。',
            'stylist_id.integer' => 'スタイリストのIDは数字で指定してください。',
            'stylist_id.exists' => '存在しないスタイリストのIDです。',
        ]);

        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400,[], JSON_UNESCAPED_UNICODE);
        }

        // $date = $validated['date'];
        // $stylist_id = $validated['stylist_id'];

        $date = $request->query('date');
        $stylist_id = $request->query('stylist_id');

        if(!$date || !$stylist_id){
            return response()->json(['error' => 'Missing parameters'],400);
        }

        $reservations = \App\Models\Reservation::with('stylist')
        ->whereDate('reservation_datetime',$date)
        ->where('stylist_id',$stylist_id)
        ->get();

        $response = $reservations->map(function ($reservation) {
            return [
                'reservation_datetime' => $reservation->reservation_datetime,
                'stylist_name' => $reservation->stylist->name,
            ];
        });

        return response() -> json($response);

    }

    ////////////////////////////////////////////////////////////////////////////////////////

    public function create(Request $request) {

        $stylists = Stylist::active()->get();

        if ($request->has('date')) {

        $validated = $request->validate([
            'date' => ['required','date'],
            'time' => ['required','date_format:H:i']
            ],
            [
                'date.required' => '日付は必須です。',
                'date.date' => '日付は0000-00-00のような形式で入力してください。',
                'time.required' => '時刻は必須です。',
                'time.time' => '時刻は00:00のような形式で入力してください。',
            ]);

            // return redirect()->route('reservations.create')->with('success','フォーマットは正常です。');
            $date = $validated['date'];
            $time = $validated['time'];
            // $reservation_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $validated['date'] . ' ' . $validated['time'] . ':00');
            $reservation_datetime = Carbon::createFromFormat('Y-m-d H:i:s',$date.' '.$time.':00');

            // 予約データをデータベースに保存
            Reservation::create([
                'reservation_datetime' => $reservation_datetime,
            ]);

        }

        return view('reservations.create',compact('stylists'));
    }

    ////////////////////////////////////////////////////////////////////////////////////////

    public function trash(Request $request) {
    //    $reservation_id  = $request->query('reservation_id');
    //    dd($reservation_id);
    //    exit;

    $validated = $request->validate([
        'reservation_id' => ['required', 'integer', 'exists:reservations,id']
    ],
    [
        'reservation_id.required' => '予約IDは必須です。',
        'reservation_id.integer' => '予約IDは数字で指定してください。',
        'reservation_id.exists' => '存在しない予約IDです。',
    ]);

        $reservation_id = $validated['reservation_id'];

        // if(!$reservation_id){
        //     return redirect()->route('reservations.index')->with('error','予約IDが指定されていません');
        // }

        $reservation = Reservation::find($reservation_id);
        if(!$reservation){
            return redirect()->route('reservations.index')->with('error','予約が見つかりません');
        }
        $reservation->delete_flg = true;
        $reservation->save();

        return redirect()->route('reservations.index')->with('success','予約をゴミ箱に入れました');
        
        
    }

    ////////////////////////////////////////////////////////////////////////////////////////

}
