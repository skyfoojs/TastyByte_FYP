<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function mainMenu() {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        return view('waiter.menu');
    }
}
