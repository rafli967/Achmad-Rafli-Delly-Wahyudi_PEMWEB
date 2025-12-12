<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index(Request $request)
    {
        
        $categories = ProductCategory::all();

        
        $products = Product::with(['store', 'productCategory'])
                    ->latest()
                    ->paginate(12);

        return view('frontend.home', compact('categories', 'products'));
    }

    public function details($slug)
    {
        $product = Product::where('slug', $slug)
                    ->with(['store', 'productCategory', 'productImages', 'productReviews'])
                    ->firstOrFail();
        
        
        $relatedProducts = Product::where('product_category_id', $product->product_category_id)
                            ->where('id', '!=', $product->id)
                            ->take(4)
                            ->get();

        return view('frontend.details', compact('product', 'relatedProducts'));
    }
}