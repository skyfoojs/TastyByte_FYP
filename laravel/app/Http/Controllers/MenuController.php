<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Orders;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\Vouchers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function mainMenu() {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        return view('waiter.menu');
    }

    public function cashierDashboard() {
        if (!Auth::check() || Auth::user()->role !== 'Cashier') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        $today = now()->toDateString();

        $data = [
            'todayOrderCount' => Orders::whereDate('created_at', $today)->count(),
            'todayAmountCount' => Orders::whereDate('created_at', $today)->sum('totalAmount'),
            'todayPendingCount' => Orders::whereDate('created_at', $today)->where('status', 'pending')->count(),
            'todayCompleteCount' => Orders::whereDate('created_at', $today)->where('status', 'completed')->count(),

            'totalOrderCount' => Orders::count(),
            'totalAmountCount' => Orders::sum('totalAmount'),
            'totalPendingCount' => Orders::where('status', 'pending')->count(),
            'totalCompletedCount' => Orders::where('status', 'completed')->count(),
        ];

        return view('cashier.dashboard', compact('data'));
    }
}
