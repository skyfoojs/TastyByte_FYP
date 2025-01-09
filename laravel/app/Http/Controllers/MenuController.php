<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function mainMenu() {
        return view('waiter.menu');
    }
}
