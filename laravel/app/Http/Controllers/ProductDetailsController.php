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
    $productDetails = Product::findOrFail($id);

    // Eager load categories and their options
    $categoriesWithOptions = $productDetails->customizableCategory()->with('options')->get();

    return view('waiter.product-details', compact('productDetails', 'categoriesWithOptions'));
    }

}
