<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Stylist;
use App\Models\Reservation;

class ReservationController extends Controller
{
    //
    public function index(Request $request) {
        $customers = Customer::all();
        $stylists = Stylist::all();
        $reservations = Reservation::with(['stylist','customer'])->get();
// echo "successss";
        $search_reservation_index = $this->search_reservation_index($request);
    //    echo "<br>";
    //    echo $customers;
        

        return view('reservations.index',compact('reservations','customers','stylists','search_reservation_index'));
    }

    public function search_reservation_index(Request $request) {

        $date = $request->query('date');
         $stylist_id = $request->query('stylist_id');
 
         if(!$date || !$stylist_id){
             return [];
         }
 
         $reservations_for_web = \App\Models\Reservation::with('stylist')
         ->whereDate('reservation_datetime',$date)
         ->where('stylist_id',$stylist_id)
         ->get();
 
        // $response = $reservations_for_web->map(function ($for_web) {
        //      return [
        //          'reservation_datetime' => $for_web->reservation_datetime,
        //          'stylist_name' => $for_web->stylist->name,
        //      ];
        //  });

         return $reservations_for_web;
 
     }

    public function search_reservation(Request $request) {

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

}
