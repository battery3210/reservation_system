<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Stylist;
use App\Models\Reservation;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    /////////index///////////////////////////////////////////////////////////////////////////////

    public function index(Request $request) {

        $stylists = Stylist::active()->get();
        // $customers = Customer::active()->select('id', 'name','email')->get();
        $customers = Customer::active(['id','name','email'])->get();
        $reservations = Reservation::getActiveAllReservations();

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

    //////////////index_END//////////////////////////////////////////////////////////////////////////

    //////////////searchByStylistAndDate//////////////////////////////////////////////////////////////////////////

    private function searchByStylistAndDate($validated) {
 
        $date = $validated['date'];
        $stylist_id = $validated['stylist_id'];
 
         $reservations_for_web = \App\Models\Reservation::with('stylist')
         ->whereDate('reservation_datetime',$date)
         ->where('stylist_id',$stylist_id)
         ->get();

         return $reservations_for_web;
 
     }

     ///////////////searchByStylistAndDate_END/////////////////////////////////////////////////////////////////////////

     ///////////////searchReservationJson/////////////////////////////////////////////////////////////////////////

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

    ///////////////////searchReservationJson_END/////////////////////////////////////////////////////////////////////

    ///////////////////create/////////////////////////////////////////////////////////////////////


    public function create(Request $request) {

        $reservations = Reservation::getActiveAllReservations();
        $stylists = Stylist::active()->get();

        if ($request->has('date')) {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:customers,email',
            'date' => ['required','date', 'after_or_equal:today'],
            'time' => ['required','date_format:H:i'],
            'stylist_id' => ['required','integer','exists:stylists,id'],
            ],
            [
                'name.required' => '名前は必須です。',
                'name.string' => '名前は文字列でお願いします。',
                'name.max' => '名前は255文字以内でお願いします。',
                'email.required' => 'EMAILは必須です。',
                'email.email' => '不正なメールアドレス形式です。',
                'email.max' => 'EMAILは255文字以内でお願いします。',
                'email.unique' => 'そのEMAILは既に存在します。',
                'date.required' => '日付は必須です。',
                'date.date' => '日付は0000-00-00のような形式で入力してください。',
                'date.after_or_equal' => '過去の日付が選択されています。',
                'time.required' => '時刻は必須です。',
                'time.time' => '時刻は00:00のような形式で入力してください。',
                'stylist_id.required' => 'スタイリストを選択して下さい。',
                'stylist_id.integer' => 'スタイリストを選択して下さい。',
                'stylist_id.exists' => '存在しないスタイリストです。',
            ]);

            // return redirect()->route('reservations.create')->with('success','フォーマットは正常です。');
            $date = $validated['date'];
            $time = $validated['time'];
            $name = $validated['name'];
            $email = $validated['email'];

            // $reservation_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $validated['date'] . ' ' . $validated['time'] . ':00');
            $reservation_datetime = Carbon::createFromFormat('Y-m-d H:i:s',$date.' '.$time.':00');

            $treatmentTime = 60; // 施術時間（分単位） → ここを可変にする

            $startTime = $reservation_datetime;
            $endTime = $startTime->copy()->addMinutes($treatmentTime); // 可変施術時間に対応
            $stylistId = $validated['stylist_id'];
            // $customerId = '1';

            $isReserved = Reservation::where('stylist_id', $stylistId) // 開始時間が範囲内
                ->whereBetween('reservation_datetime', [$startTime, $endTime])
                ->orWhere(function ($query) use ($startTime, $endTime, $stylistId, $treatmentTime) {
                    $query->where('stylist_id', $stylistId)
                        ->whereBetween(
                            DB::raw("DATE_ADD(reservation_datetime, INTERVAL $treatmentTime MINUTE)"), 
                            [$startTime, $endTime]
                        ); // 終了時間が範囲内
                })
                ->exists();


            if ($isReserved) {
                return redirect()->back()->withErrors(['time' => 'この時間は既に予約されています。別の時間を選択してください。'])->withInput();
            }

            DB::beginTransaction();  // トランザクション開始
            try{

                    $customer = Customer::firstOrCreate( //顧客が既にいるかチェック (firstOrCreate())
                        ['name' => $name ],
                        ['email' => $email ],
                    );

                    // 予約データをデータベースに保存
                    Reservation::create([
                        'customer_id' => $customer->id,
                        'reservation_datetime' => $reservation_datetime,
                        'stylist_id' => $validated['stylist_id'],
                    ]);

                    DB::commit();  // すべて成功した場合はコミット
                    return redirect()->back()->with('success','予約が完了しました。');

                } catch(\Exception $e) {

                    DB::rollBack();
                    return back()->with('error','予約の保存に失敗しました。');

                }

        }

        return view('reservations.create',compact('stylists','reservations'));
    }

    ///////////////////create_END////////////////////////////////////////////////////////////////////

    ///////////////////trash/////////////////////////////////////////////////////////////////////

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

    ///////////////////trash_END/////////////////////////////////////////////////////////////////////

}
