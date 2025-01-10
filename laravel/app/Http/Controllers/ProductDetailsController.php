<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductDetailsController extends Controller
{
    public function index() {
        //
    }

    public function edit($id) {
        $productDetails = Product::find($id);
        return view('waiter.product-details', compact('productDetails'));
    }
}
