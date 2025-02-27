<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index() {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        return view('waiter.table');
    }

    public function cashierIndex() {
        return view('cashier.table');
    }

    public function orderSummary(Request $request) {
        if (Auth::check()) {
            $role = session('role', Auth::user()->role); // Get role from session or authenticated user

            $query = Orders::with('orderItems.products');

            if ($request->has('orderID')) {
                $query->where('orderID', $request->orderID);
            }

            $orders = $query->get();

            if ($role === 'Cashier') {
                return view('cashier.order-summary', compact('orders'));
            } elseif ($role === 'Waiter') {
                return view('waiter.order-summary');
            } else {
                return view('404');
            }
        }

        // Redirect to login if not authenticated
        return redirect()->route('login')->with('error', 'Unauthorized access.');
    }



    public function trackOrder() {
        if (Auth::check()) {
            $role = session('role', Auth::user()->role);

            $orders = Orders::with('orderItems')->get();

            if ($role === 'Cashier') {
                return view('cashier.track-order', compact('orders'));
            } elseif ($role === 'Waiter') {
                return view('waiter.track-order', compact('orders'));
            } else {
                return view('404');
            }
        }

        return redirect()->route('login')->with('error', 'Unauthorized Access');
    }

    public function orderHistory(Request $request) {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $query = Orders::with('orderItems.products');

        if ($request->has('orderID')) {
            $query->where('orderID', $request->orderID);
        }

        $orders = $query->get();

        return view('waiter.order-history', compact('orders'));
    }


    public function storeTable(Request $request) {
        $request->validate([
            'table' => 'required|integer|min:1|max:20',
        ]);

        // Store the table number into a session global variable.
        session(['tableNo' => $request->input('table')]);

        // Determine redirection based on the source
        if ($request->input('source') === 'cashier') {
            return redirect()->route('cashier.order')->with('success', 'Table number stored in session!');
        }

        return redirect()->route('order');
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

        if ($request->route()->getName() === 'cashier.addToCart.post') {
            return redirect()->route('cashier.order')->with('success', 'Product added to cart!');
        } else if ($request->route()->getName() === 'addToCart.post'){
            return redirect()->route('order')->with('success', 'Product added to cart!');
        } else {
            return redirect()->route('404');
        }
    }

    public function viewCart() {
        $cart = session()->get('cart', []);
        return view('waiter.order', compact('cart'));
    }

    public function removeFromCart(Request $request) {
        $cart = session()->get('cart', []);

        if (isset($cart[$request->cartKey])) {
            unset($cart[$request->cartKey]); // Remove the specific item
            session()->put('cart', $cart); // Update the session
        }

        // If cart is empty, redirect to /order with success message
        if (empty($cart)) {
            session()->forget('cart'); // Clear session if empty
            session()->flash('success', 'Your cart is empty now!'); // Store message

            return response()->json(['success' => true, 'redirect' => route('order')]);
        }

        return response()->json(['success' => true]);
    }


    public function addOrderPost(Request $request) {
        if (!session()->has('cart') || empty(session('cart'))) {
            return redirect()->route('order')->with('error', 'Cart is empty!');
        }

        $cartItems = session('cart');
        $userID = session('userID'); // Assuming user is logged in
        $tableNo = session('tableNo') ?? null;

        // Calculate total amount
        $totalAmount = array_reduce($cartItems, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        try {
            DB::beginTransaction();

            // Create order
            $order = Orders::create([
                'userID' => $userID,
                'tableNo' => $tableNo,
                'remark' => 'Test',
                'status' => 'Pending', // Default status
                'totalAmount' => $totalAmount,
            ]);

            // Insert order items
            foreach ($cartItems as $cartItem) {
                $productID = Product::where('name', $cartItem['name'])->value('productID');

                if (!$productID) {
                    throw new \Exception("Product not found: " . $cartItem['name']);
                }

                OrderItems::create([
                    'productID' => $productID,
                    'orderID' => $order->orderID,
                    'quantity' => $cartItem['quantity'],
                    'remark' => json_encode([
                        'options' => $cartItem['options'], // Store options as JSON
                        'takeaway' => $cartItem['takeaway'] // Add takeaway information to the remark
                    ]),
                ]);
            }

            DB::commit();

            // Clear cart session
            session()->forget('cart');

            if ($request->route()->getName() === 'addOrder.post') {
                return redirect()->route('orderHistory', ['orderID' => $order->orderID])
                    ->with('success', 'Order placed successfully!');
            } elseif ($request->route()->getName() === 'cashier.addOrder.post') {
                return redirect()->route('orderSummary', ['orderID' => $order->orderID])
                    ->with('success', 'Order placed successfully!');
            } else {
                return redirect()->route('404');
            }


        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('order')->with('error', 'Failed to place order: ' . $e->getMessage());
        }
    }

    public function updateOrderStatusCompleted(Request $request) {
        $request->validate([
            'completedOrderID' => 'required|integer|exists:orders,orderID',
        ]);

        $order = Orders::findOrFail($request->completedOrderID);
        $order->status = 'Completed';
        $order->save();

        return redirect()->route('trackOrder')->with('success', 'Order marked as completed!');
    }

}
