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
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Check if the user's role matches the required role for the page
        $routeName = $request->route()->getName();

        // Restrict Admin role access
        if (Auth::user()->role === 'Admin') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Restrict Kitchen role access
        if (Auth::user()->role === 'Kitchen') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Restrict Waiter role from accessing cashier's page
        if (Auth::user()->role === 'Waiter' && $routeName !== 'order') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Restrict Cashier role from accessing waiter's page
        if (Auth::user()->role === 'Cashier' && $routeName !== 'cashier.order') {
            session()->forget(['username', 'userID']);
            Auth::logout();
            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Fetch products with their categories
        $products = Product::with('category')->get()->sortBy(fn($product) => $product->category->sort ?? PHP_INT_MAX);

        // Group products by category
        $groupedProducts = $products->groupBy(fn($product) => $product->category->name ?? 'Uncategorized');

        // Determine the view based on route name
        $view = match ($routeName) {
            'order' => 'waiter.order',
            'cashier.order' => 'cashier.order',
            default => '404',
        };

        return view($view, compact('groupedProducts', 'products'));
    }

    public function edit($id) {
        if (!Auth::check() || Auth::user()->role !== 'Waiter') {
            session()->forget(['username', 'userID']);
            Auth::logout();

            return redirect()->route('login')->with('error', 'Unauthorized Access');
        }

        // Fetch product details
        $productDetails = Product::findOrFail($id);

        // Load customizable categories sorted by 'sort_order' and their options also sorted
        $categoriesWithOptions = $productDetails->customizableCategory()
            ->with(['options' => function ($query) {
                $query->orderBy('sort', 'asc'); // Sort options inside each category
            }])
            ->orderBy('sort', 'asc') // Sort categories
            ->get();

        return view('waiter.product-details', compact('productDetails', 'categoriesWithOptions'));
    }

        public function getProductDetails($id)
    {
        // Find the product by ID
        $product = Product::with('customizableCategory.options')->find($id);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found'], 404);
        }
        // Get the customization options
        $categories = $product->customizableCategory()->with('options')->get();
        return response()->json([
            'success' => true,
            'product' => [
                'productID'   => $product->productID,
                'name'        => $product->name,
                'price'       => $product->price,
                'description' => $product->description,
                'image'       => asset($product->image),
            ],
            'categories' => $categories,
        ]);
    }
}
