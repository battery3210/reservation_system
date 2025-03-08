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
        // $stylists = Stylist::all();
        $stylists = stylist::
        where('delete_flg',false)
        ->orderBy('created_at','desc')
        ->get();
        // dd($stylists);
        return view('reservations.stylist',compact('stylists'));
    }

    public function trash(Request $request) {
        
        $validated = $request->validate([
            'stylist_id' => ['required', 'integer', 'exists:stylists,id']
        ],
        [
            'stylist_id.required' => 'スタイリストIDは必須です。',
            'stylist_id.integer' => 'スタイリストIDは数字で指定してください。',
            'stylist_id.exists' => '存在しないスタイリストIDです。',
        ]);
    
            $stylist_id = $validated['stylist_id'];
    
            $stylist = stylist::find($stylist_id);
    
            if(!$stylist){
                return redirect()->route('reservations.stylist')->with('error','スタイリストが見つかりません');
            }
    
            $stylist->delete_flg = true;
            $stylist->save();
    
            return redirect()->route('reservations.stylist')->with('success','スタイリストをゴミ箱に入れました');
        }
}
