<?php

namespace App\Http\Controllers;

use App\Models\OrderItems;
use App\Models\Orders;
use App\Models\Payment;
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

    public function kitchenIndex() {
        return view('kitchen.order-items');
    }

    public function orderSummary(Request $request) {
        if (Auth::check()) {
            $role = session('role', Auth::user()->role); // Get role from session or authenticated user

            $query = Orders::with('orderItems.products', 'payments');

            if ($request->has('orderID')) {
                $query->where('orderID', $request->orderID);
            }

            $orders = $query->get();

            if ($role === 'Cashier') {
                $subtotal = $orders->sum(function ($order) {
                    return $order->orderItems->sum(function ($item) {
                        return $item->products->price * $item->quantity;
                    });
                });

                $tax = $subtotal * 0.06;
                $serviceCharge = $subtotal * 0.10;
                $total = $subtotal + $tax + $serviceCharge;

                $payment = $orders->first()->payments->first();

                $isPaid = $orders->first()->payments->isNotEmpty();

                session(['checkout' => array_merge(session('checkout', []), [
                    'orderID' => $request->orderID,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'total' => $total,
                    'tableNo' => $orders->first()->orderItems->first()->table->tableNo ?? null,
                    'orderDate' => $orders->first()->created_at ?? null,
                    'isPaid' => $isPaid,
                    'paymentID' => $payment->paymentID ?? null,
                    'paymentMethod' => $payment ? ($payment->paymentMethod === 'credit_debit_card' ? 'Credit/ Debit Card' : 'Cash') : null,
                    'voucherCode' => session('checkout.voucherCode', '-'), // Preserve applied voucher
                    'discount' => session('checkout.discount', 0),
                    'new_total' => session('checkout.new_total', $total),
                    'paymentDate' => $payment->created_at ?? null,
                ])]);
                return view('cashier.order-summary', compact('orders', 'isPaid', 'payment'));
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

            $orders = Orders::with('orderItems', 'payments') ->orderBy('created_at', 'desc') ->get();

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

    public function trackOrderItems(Request $request) {
        if (!Auth::check() || Auth::user()->role !== 'Kitchen') {
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $filter = $request->input('filter', 'pending');

        $query = OrderItems::with('products', 'orders');

        if ($filter === 'pending') {
            $query->where('status', 'Pending');
        } elseif ($filter === 'completed') {
            $query->where('status', 'Completed');
        }

        $orderItems = $query->orderBy('created_at', 'desc')->get();

        return response()->json([
            'orderItems' => $orderItems,
        ]);
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

        $tableNo = $request->input('table');
        session(['tableNo' => $tableNo]);

        $orderIds = Orders::where('tableNo', $tableNo)->pluck('orderID');

        $paidOrderIds = Payment::whereIn('orderID', $orderIds)->pluck('orderID');

        $unpaidOrderIds = $orderIds->diff($paidOrderIds);

        if ($unpaidOrderIds->isNotEmpty()) {
            return redirect()->back()->with('continueOrder', true);
        }

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
        $request->validate([
            'cartKey' => 'required|string',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$request->cartKey])) {
            unset($cart[$request->cartKey]);
            if (empty($cart)) {
                session()->forget('cart');
                return response()->json([
                    'success' => true,
                    'message' => 'Your cart is empty now!',
                    'redirect' => route('order')
                ]);
            } else {
                session()->put('cart', $cart);
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed successfully!',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart!',
        ], 400);
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
                    'status' => 'Pending',
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

    public function updateOrderItemStatus(Request $request) {
        $validated = $request->validate([
            'orderItemID' => 'required|integer|exists:orderitems,orderItemID',
        ]);

        $orderItem = OrderItems::find($validated['orderItemID']);

        if (!$orderItem) {
            return response()->json(['success' => false, 'message' => 'Order item not found!'], 404);
        }

        $orderItem->status = 'Completed';
        $orderItem->save();

        return response()->json(['success' => true, 'message' => 'Order item marked as completed!']);
    }
}
