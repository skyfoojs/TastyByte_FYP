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

        // Retrieve selected options and sort to avoid mismatch due to order
        $selectedOptions = $request->input('options', []);
        ksort($selectedOptions); // Sort to ensure order consistency

        // Generate a unique hash key based on product ID, takeaway status, and options
        $cartKey = md5($request->productID . json_encode($selectedOptions) . ($request->has('takeaway') ? '1' : '0'));

        // Retrieve the current cart from the session or initialize it
        $cart = session()->get('cart', []);

        $newCartItem = [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => 1,
            'image' => $request->input('image'),
            'takeaway' => $request->has('takeaway') ? true : false,
            'options' => $selectedOptions,
        ];

        // If the product with the same options exists, increase the quantity
        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity']++;
        } else {
            $cart[$cartKey] = $newCartItem;
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
