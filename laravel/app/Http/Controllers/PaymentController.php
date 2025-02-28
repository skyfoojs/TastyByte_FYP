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
        // Validate that the orderID exists
        $request->validate([
            'orderID' => 'required|integer|exists:orders,orderID',
            'paymentMethod' => 'required|string',
            'voucherID' => 'nullable|integer|exists:vouchers,voucherID',
        ]);

        try {
            DB::beginTransaction();

            // Retrieve the selected order
            $order = Orders::with('orderItems.products')->findOrFail($request->orderID);

            // Calculate total amount from order items
            $totalAmount = $order->orderItems->sum(function ($item) {
                return $item->quantity * ($item->products->price ?? 0);
            });

            // Apply voucher discount if provided
            if ($request->filled('voucherID')) {
                $voucher = Vouchers::find($request->voucherID);
                if ($voucher) {
                    $totalAmount -= $voucher->discount; // Adjust logic as needed
                }
            }

            // Ensure total amount is not negative
            $totalAmount = max(0, $totalAmount);

            // Create new payment record
            $payment = Payment::create([
                'orderID' => $order->orderID,
                'voucherID' => $request->voucherID,
                'totalAmount' => $totalAmount,
                'paymentMethod' => $request->paymentMethod,
                'status' => 'completed', // Adjust based on actual payment process
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
