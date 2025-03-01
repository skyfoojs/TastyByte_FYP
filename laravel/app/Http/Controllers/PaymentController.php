<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Orders;
use App\Models\Vouchers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
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
                ->with('error', 'Payment failed. Please try again.');
        }
    }
}
