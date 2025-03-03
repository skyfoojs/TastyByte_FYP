<?php

namespace App\Http\Controllers;

use App\Models\Inventory;

use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function trackInventory(Request $request){
        if (Auth::check() || Auth::user()->role == 'Cashier'){
            $query = Vouchers::with('product');

            $inventory = $query->get();

            return view('kitchen.track-inventory', compact('inventory'));
        }
        return redirect()->route('login')->with('error', 'Unauthorized Access');
    }
}
