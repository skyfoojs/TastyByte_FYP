<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(){
        // Fetch products with their categories
        $products = Product::with('category')->get();

        // Group products by category
        $groupedProducts = $products->groupBy(function ($product) {
            return $product->category->name ?? 'Uncategorized'; // Default if category is null
        });

        return view('waiter.order', compact('groupedProducts'));
    }


}
