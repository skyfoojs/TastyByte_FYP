<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout(Request $request){
        if (Auth::check() || Auth::user()->role == 'Cashier') {

            //TODO: Change payment status to successfull
            return view('cashier.payment');
        }

        return redirect()->route('login')->with('error', 'Unauthorized Access');
    }
}
