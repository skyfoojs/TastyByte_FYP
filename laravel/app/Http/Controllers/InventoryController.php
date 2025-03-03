<?php

namespace App\Http\Controllers;

use App\Models\Inventory;

use App\Models\Product;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function trackInventory(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 'Cashier') {
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $query = Inventory::query();

        if ($request->has('filterType') && $request->has('keywords')) {
            $filterType = $request->input('filterType');
            $keywords = $request->input('keywords');

            switch ($filterType) {
                case 'filterInventoryID':
                    $query->where('inventoryID', $keywords);
                    break;
                case 'filterCategoryName':
                    $query->where('name', 'LIKE', "%$keywords%");
                    break;
                case 'filterStockMoreThan':
                    $query->where('stockLevel', '>', (int)$keywords);
                    break;
                case 'filterStockLessThan':
                    $query->where('stockLevel', '<', (int)$keywords);
                    break;
            }
        }

        $inventory = $query->select('inventoryID', 'stockLevel', 'minLevel', 'name')->get();

        if ($request->ajax()) {
            return response()->json(['inventory' => $inventory]);
        }

        return view('cashier.track-inventory', compact('inventory'));
    }

    public function addInventoryPost(Request $request)
    {
        $request->validate([
            'inventory' => 'required|string',
            'stockLevel' => 'required|integer',
            'minLevel' => 'required|integer',
        ]);

        $inventory = Inventory::create([
            'name' => $request->inventory,
            'stockLevel' => $request->stockLevel,
            'minLevel' => $request->minLevel,
        ]);

        if (!$inventory) {
            return redirect()->route('cashier.track-inventory')->with('error', 'Error adding inventory.');
        }

        return redirect()->route('cashier.track-inventory')->with('success', 'Inventory added successfully!');
    }

    public function editInventoryPost(Request $request)
    {
        $request->validate([
            'inventoryID' => 'required|exists:inventory,inventoryID',
            'editInventory' => 'required|string',
            'editStockLevel' => 'required|integer',
            'editMinLevel' => 'required|integer',
        ]);

        $inventory = Inventory::find($request->inventoryID);

        if (!$inventory) {
            return redirect()->route('cashier.track-inventory')->with('error', 'Inventory not found.');
        }

        $inventory->name = $request->editInventory;
        $inventory->stockLevel = $request->editStockLevel;
        $inventory->minLevel = $request->editMinLevel;

        if ($inventory->save()) {
            return redirect()->route('cashier.track-inventory')->with('success', 'Inventory updated successfully!');
        } else {
            return redirect()->route('cashier.track-inventory')->with('error', 'Error updating inventory.');
        }
    }
}
