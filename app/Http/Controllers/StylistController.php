<?php

namespace App\Http\Controllers;

use App\Models\Stylist;
use Illuminate\Http\Request;


class StylistController extends Controller
{
    //
    public function showStylists() {
        $array = [['id'=>1, 'name'=>'test']];
        // var_dump($array);
        $stylists = Stylist::all();
        // dd($stylists);
        return view('reservations.stylist',compact('stylists'));
    }
}
