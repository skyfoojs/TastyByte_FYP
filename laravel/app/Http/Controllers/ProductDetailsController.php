<?php

namespace App\Http\Controllers;

use App\Models\CustomizableOptions;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailsController extends Controller
{
    public function index() {
        //
    }

    public function edit($id) {
        $productDetails = Product::find($id);

        $productCustomizableDetails = CustomizableOptions::with('category')->get();

        $groupedCustomizableDetails = $productCustomizableDetails->groupBy(function ($product) {
            return $product->category->name ?? 'Uncategorized'; // Default if category is null
        });

        return view('waiter.product-details', compact('productDetails', 'groupedCustomizableDetails'));
}
}
