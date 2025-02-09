<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request) {
        // Fetch products with their categories
        $products = Product::with('category')->get();

        // Group products by category
        $groupedProducts = $products->groupBy(fn($product) => $product->category->name ?? 'Uncategorized');

        $view = match ($request->route()->getName()) {
            'order' => 'waiter.order',
            'cashier.order' => 'cashier.order',
            default => '404'
        };

        return view($view, compact('groupedProducts'));
    }

    public function edit($id) {
        $productDetails = Product::findOrFail($id);

        // Eager load categories and their options
        $categoriesWithOptions = $productDetails->customizableCategory()->with('options')->get();

        return view('waiter.product-details', compact('productDetails', 'categoriesWithOptions'));
        }
}
