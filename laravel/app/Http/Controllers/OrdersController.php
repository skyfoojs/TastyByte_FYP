<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index() {
        return view('waiter.table');
    }

    public function storeTable(Request $request) {
        $request->validate([
            'table' => 'required|integer|min:1|max:20',
        ]);

        // Store the table number into a session global variable.
        session(['tableNo' => $request->input('table')]);

        // Redirect to order page.
        return redirect()->route('order')->with('success', 'Table number stored in session!');
    }
}
