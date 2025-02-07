<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index() {
        return view('waiter.table');
    }

    public function orderSummary() {
        return view('waiter.order-summary');
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

    public function addToCartPost(Request $request) {
        $request->validate([
            'productID' => 'required|integer',
            'takeaway' => 'nullable',
        ]);

        // Retrieve selected options properly
        $selectedOptions = $request->input('options', []); // Gets all selected options by category

        // Retrieve the current cart from the session or initialize it
        $cart = session()->get('cart', []);

        // Check if the product already exists in the cart
        if(isset($cart[$request->productID])) {
            // Increment the quantity if it already exists
            $cart[$request->productID]['quantity']++;
        } else {
            // Add the product to the cart with a quantity of 1
            $cart[$request->productID] = [
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'quantity' => 1,
                'image' => $request->input('image'),
                'takeaway' => $request->has('takeaway') ? true : false,
                'options' => $selectedOptions, // Store selected options properly
            ];
        }

        // Save the updated cart back to the session
        session()->put('cart', $cart);

        return redirect()->route('order')->with('success', 'Product added to cart!');
    }

    public function viewCart() {
        $cart = session()->get('cart', []);
        return view('waiter.order', compact('cart'));
    }
}
