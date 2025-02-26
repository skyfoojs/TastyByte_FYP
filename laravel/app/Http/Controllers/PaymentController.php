<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Payment extends Controller
{
    public function checkout(Request $request){
        if (!Auth::check() || Auth::user()->role !== 'Cashier') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $tax = $subtotal * 0.06;
        $serviceCharge = $subtotal * 0.10;
        $total = $subtotal + $tax + $serviceCharge;

        return view('cashier.payment');
    }
}
