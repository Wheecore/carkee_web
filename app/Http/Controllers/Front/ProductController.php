<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show(Request $request)
    {
        // Retrieve product ID from query string
        $productId = $request->query('id');
        if (!$productId) {
            abort(404, 'Product not found');
        }

        // Retrieve the product from the database
        $product = Product::find($productId);
        if (!$product) {
            abort(404, 'Product not found');
        }
        // Optionally generate a custom scheme URL for the app (if configured)
        // $appUrl = "carkee://product?id={$product->id}";

        return view('frontend.product.index', compact('product'));
    }
}