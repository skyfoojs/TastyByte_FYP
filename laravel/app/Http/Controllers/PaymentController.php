<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Orders;
use App\Models\Vouchers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index() {

        return view('cashier.payment');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'orderID' => 'required|integer|exists:orders,orderID',
            'paymentMethod' => 'required|string|in:cash,credit_card',
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
                'status' => 'completed',
            ]);

            DB::commit();

            return redirect()->route('order.success')->with('success', 'Payment completed! Payment ID: ' . $payment->paymentID);

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
}
