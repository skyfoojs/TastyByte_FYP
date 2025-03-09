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
            return back()->with('error', 'Invalid voucher code.');
        }

        $now = now();

        if ($voucher->startedOn > $now || $voucher->expiredOn < $now) {
            return back()->with('error', 'This voucher is not valid at this time.');
        }

        // 取 session 数据
        $checkout = session('checkout', []);

        // 计算税和服务费
        $subtotal = $checkout['subtotal'] ?? 0;
        $tax = $checkout['tax'] ?? ($subtotal * 0.06);
        $serviceCharge = $checkout['serviceCharge'] ?? ($subtotal * 0.10);

        // 计算折扣
        $discount = ($voucher->type === 'Percentage')
            ? ($subtotal * $voucher->value) / 100
            : $voucher->value;

        // 计算新总价
        $newTotal = max(0, ($subtotal + $tax + $serviceCharge) - $discount);

        // 确保 session 里有所有数据
        $checkout['voucherCode'] = $voucher->code;
        $checkout['discount'] = $discount;
        $checkout['new_total'] = $newTotal;

        // 强制存入 session 并保存
        session()->put('checkout', $checkout);
        session()->save();  // **强制 Laravel 立即保存 session**

        return back()->with('success', 'Voucher applied successfully!');
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
