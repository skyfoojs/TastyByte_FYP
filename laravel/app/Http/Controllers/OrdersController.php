<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function addOrderPost(Request $request) {
        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->route('order')->with('error', 'Cart is empty!');
        }

        $cartItems = session('cart');
        $userID = session('userID'); // Assuming the user is logged in
        $tableNo = session('tableNo') ?? null;
        //$remark = $request->input('remark', ''); // Get any remarks from the request
        $totalAmount = array_reduce($cartItems, function($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        try {
            DB::beginTransaction();

            // Create a new order
            $order = Orders::create([
                'userID' => $userID,
                'tableNo' => $tableNo,
                'remark' => 'Test',
                'status' => 'Pending', // Default status
                'totalAmount' => $totalAmount,
            ]);

            // Insert order items
            foreach ($cartItems as $cartItem) {
                $optionsJson = json_encode($cartItem['options']); // Store options as JSON

                OrderItems::create([
                    'productID' => Product::where('name', $cartItem['name'])->value('productID'),
                    'orderID' => $order->orderID,
                    'quantity' => $cartItem['quantity'],
                    'remark' => $optionsJson, // Save options as remarks
                ]);
            }

            DB::commit();

            // Clear cart session after placing order
            session()->forget('cart');
            session()->forget('tableNo');
            return redirect()->route('order')->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('order')->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

}