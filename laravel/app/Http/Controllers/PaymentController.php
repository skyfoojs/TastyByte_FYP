<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Orders;
use App\Models\Vouchers;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index() {
        if (!Auth::check() || Auth::user()->role !== 'Cashier') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }
        return view('cashier.payment');
    }

    public function sendEmail(Request $request) {
        if (!Auth::check() || Auth::user()->role !== 'Cashier') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Get paymentID from request
        $paymentID = $request->query('paymentID');

        // Check if paymentID is provided
        if (!$paymentID) {
            return back()->with('error', 'Payment ID is missing.');
        }

        return view('cashier.send-email', compact('paymentID'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'orderID' => 'required|integer|exists:orders,orderID',
            'paymentMethod' => 'required|string|in:cash,credit_debit_card',
            'voucher_code' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $order = Orders::with('orderItems.products')->findOrFail($request->orderID);

            $totalAmount = $order->orderItems->sum(function ($item) {
                return $item->quantity * ($item->products->price ?? 0);
            });

            $voucherID = null;
            if ($request->filled('voucher_code')) {
                $voucher = Vouchers::where('code', $request->voucher_code)->first();
                if ($voucher) {
                    $totalAmount -= $voucher->discount;
                    $voucherID = $voucher->voucherID;
                }
            }

            $totalAmount = max(0, $totalAmount);

            $payment = Payment::create([
                'orderID' => $order->orderID,
                'voucherID' => $voucherID,
                'totalAmount' => $totalAmount,
                'paymentMethod' => $request->paymentMethod,
                'status' => 'Completed',
            ]);

            $order->update(['status' => 'Completed']);

            $paymentID = $payment->paymentID;

            DB::commit();

            return redirect()->route('order.success', ['paymentID' => $paymentID])->with('success', 'Payment completed! Payment ID: ' . $payment->paymentID);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('orderSummary', ['orderID' => $request->orderID])
                ->with('error', 'Payment failed. Please try again.'. $e->getMessage());
        }
    }

    public function applyVoucher(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|string'
        ]);

        $voucher = Vouchers::where('code', $request->voucher_code)->first();
        if (!$voucher) {
            return response()->json(['success' => false, 'message' => 'Invalid voucher code.'], 400);
        }

        $order = session('checkout');
        $subtotal = $order['subtotal'] ?? 0;
        $newTotal = max(0, $subtotal - $voucher->discount);

        return response()->json([
            'success' => true,
            'voucherID' => $voucher->voucherID,
            'discount' => $voucher->discount,
            'new_total' => $newTotal
        ]);
    }

public function sendDigitalInvoice(Request $request) {
    // Validate email input
    $request->validate([
        'emailAddress' => 'required|email',
        'paymentID' => 'required|integer',
    ]);

    // Get email and payment ID from request
    $email = $request->input('emailAddress');
    $paymentID = $request->input('paymentID');

    // Retrieve payment details from the database
    $payment = Payment::with('orders.orderItems.products')->where('paymentID', $paymentID)->first();

    // Check if payment exists
    if (!$payment) {
        return back()->with('error', 'Payment not found.');
    }

    // Send email with payment details
    Mail::to($email)->send(new SendMail($payment));

    // Redirect with success message
    return redirect()->route('cashier.order')->with('success', 'Digital Invoice sent successfully to ' . $email);
}

}
