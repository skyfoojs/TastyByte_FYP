<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'customizableCategory.options'])->get();

        // Group products by category
        $groupedProducts = $products->groupBy(fn($product) => $product->category->name ?? 'Uncategorized');

        $view = match ($request->route()->getName()) {
            'order' => 'waiter.order',
            'cashier.order' => 'cashier.order',
            default => '404'
        };

        return view($view, compact('groupedProducts', 'products'));
    }

    public function edit($id) {
        $productDetails = Product::findOrFail($id);

        // Eager load categories and their options
        $categoriesWithOptions = $productDetails->customizableCategory()->with('options')->get();

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
