<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request) {
        // Authorization check: Ensure user is authenticated
        if (!Auth::check()) {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        // Check if the user's role matches the required role for the page
        $routeName = $request->route()->getName();

        // Restrict Admin role access
        if (Auth::user()->role === 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        // Restrict Kitchen role access
        if (Auth::user()->role === 'Kitchen') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        // Restrict Waiter role from accessing cashier's page
        if (Auth::user()->role === 'Waiter' && $routeName !== 'order') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        // Restrict Cashier role from accessing waiter's page
        if (Auth::user()->role === 'Cashier' && $routeName !== 'cashier.order') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        // Fetch products with their categories
        $products = Product::with('category')->get();

        // Group products by category
        $groupedProducts = $products->groupBy(fn($product) => $product->category->name ?? 'Uncategorized');

        // Determine the view based on route name
        $view = match ($routeName) {
            'order' => 'waiter.order',
            'cashier.order' => 'cashier.order',
            default => '404',
        };

        return view($view, compact('groupedProducts'));
    }

    public function edit($id) {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect('/login')->with('error', 'Unauthorized Access');
        }

        $productDetails = Product::findOrFail($id);

        // Eager load categories and their options
        $categoriesWithOptions = $productDetails->customizableCategory()->with('options')->get();

        return view('waiter.product-details', compact('productDetails', 'categoriesWithOptions'));
        }
}
