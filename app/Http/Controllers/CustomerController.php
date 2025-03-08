<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    //
    public function showCustomers() {
        // $customers = Customer::all();
        $customers = Customer::
        where('delete_flg',false)
        ->orderBy('created_at','desc')
        ->get();
        return view('reservations.customer',compact('customers'));
    }


    public function trash(Request $request) {
        
        $validated = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id']
        ],
        [
            'customer_id.required' => 'スタイリストIDは必須です。',
            'customer_id.integer' => 'スタイリストIDは数字で指定してください。',
            'customer_id.exists' => '存在しないスタイリストIDです。',
        ]);
    
            $customer_id = $validated['customer_id'];
    
            $customer = customer::find($customer_id);
    
            if(!$customer){
                return redirect()->route('reservations.customer')->with('error','お客様が見つかりません');
            }
    
            $customer->delete_flg = true;
            $customer->save();
    
            return redirect()->route('reservations.customer')->with('success','お客様をゴミ箱に入れました');
        }
}
