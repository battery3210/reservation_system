<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;


class CustomerController extends Controller
{
    //
    public function showCustomers() {
        $customers = Customer::all();
        return view('reservations.customer',compact('customers'));
    }
}
