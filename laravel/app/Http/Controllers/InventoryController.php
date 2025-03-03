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
            return redirect()->route('cashier.track-inventory')->with('error', 'Error adding inventory.');
        }

        return redirect()->route('admin-inventory')->with('success', 'Inventory added successfully!');
    }

    public function editInventoryPost(Request $request) {
        $request->validate([
            'inventoryID' => 'required',
            'editInventory' => 'required',
            'editProduct' => 'required',
            'editStockLevel' => 'required',
            'editMinLevel' => 'required',
        ]);

        $inventory = Inventory::find($request->inventoryID);

        if (!$inventory) {
            return redirect()->route('cashier.track-inventory')->with('error', 'Inventory not found.');
        }

        $inventory->name = $request->editInventory;
        $inventory->productID = $request->editProduct;
        $inventory->stockLevel = $request->editStockLevel;
        $inventory->minLevel = $request->editMinLevel;

        if ($inventory->save()) {
            return redirect()->route('cashier.track-inventory')->with('success', 'Inventory updated successfully!');
        } else {
            return redirect()->route('cashier.track-inventory')->with('error', 'Error updating inventory.');
        }
    }

    public function getFilteredInventories(Request $request)
    {
        $request->validate([
            'filterType' => 'required|string|in:filterInventoryID,filterCategoryName,filterProductName,filterStockMoreThan,filterStockLessThan',
            'keywords' => 'required|string',
        ]);

        $query = Inventory::query();

        $filterType = $request->input('filterType');
        $keywords = $request->input('keywords');

        // Apply filtering based on filter type
        switch ($filterType) {
            case 'filterInventoryID':
                $query->where('inventoryID', $keywords);
                break;
            case 'filterCategoryName':
                $query->where('name', 'LIKE', "%$keywords%");
                break;
            case 'filterProductName':
                $query->whereHas('product', function ($q) use ($keywords) {
                    $q->where('name', 'LIKE', "%$keywords%");
                });
                break;
            case 'filterStockMoreThan':
                $query->where('stockLevel', '>', (int)$keywords);
                break;
            case 'filterStockLessThan':
                $query->where('stockLevel', '<', (int)$keywords);
                break;
        }

        $totalInventory = Inventory::count();
        $limit = 6;
        $totalPages = ceil($totalInventory / $limit);
        $inventory = $query->paginate($limit);

        $product = Product::all();

        return view('cashier.track-inventory', compact('inventory', 'totalPages', 'product'));
    }
}
