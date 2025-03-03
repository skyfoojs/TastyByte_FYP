<?php

namespace App\Http\Controllers;

use App\Models\Inventory;

use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function trackInventory(Request $request)
    {
        if (Auth::check() || Auth::user()->role == 'Cashier') {
            $inventory = Inventory::with('product')->select('inventoryID', 'productID', 'stockLevel', 'minLevel', 'name')->get();

            if ($request->ajax()) {
                return response()->json(['inventory' => $inventory]);
            }

            return view('cashier.track-inventory', compact('inventory'));
        }

        return redirect()->route('login')->with('error', 'Unauthorized Access');
    }

    public function addInventoryPost(Request $request) {
        $request->validate([
            'inventory' => 'required',
            'product' => 'required',
            'stockLevel' => 'required',
            'minLevel' => 'required',
        ]);

        $inventory = Inventory::create([
            'name' => $request->inventory,
            'productID' => $request->product,
            'stockLevel' => $request->stockLevel,
            'minLevel' => $request->minLevel,
        ]);

        if (!$inventory) {
            return redirect()->route('admin-inventory')->with('error', 'Error adding inventory.');
        }

        return redirect()->route('admin-inventory')->with('success', 'Inventory added successfully!');
    }
}
