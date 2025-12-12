<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('store_id', Auth::user()->store->id)
                    ->with(['productCategory', 'thumbnail']) 
                    ->latest()
                    ->paginate(10);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:1000',
            'stock' => 'required|integer|min:1',
            'weight' => 'required|integer|min:1',
            'condition' => 'required|in:new,second',
            'description' => 'required|string',
            'images' => 'required|array|min:1|max:5', 
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product = Product::create([
                'store_id' => Auth::user()->store->id,
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
                'condition' => $request->condition,
                'description' => $request->description,
            ]);

            
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_thumbnail' => $index === 0, 
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function edit(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) abort(403);
        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) abort(403);

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'weight' => 'required|integer',
            'condition' => 'required|in:new,second',
            'description' => 'required|string',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $product->update([
                'product_category_id' => $request->product_category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'price' => $request->price,
                'stock' => $request->stock,
                'weight' => $request->weight,
                'condition' => $request->condition,
                'description' => $request->description,
            ]);

            if ($request->hasFile('images')) {
                
                ProductImage::where('product_id', $product->id)->delete();

                
                foreach ($request->file('images') as $index => $file) {
                    $path = $file->store('products', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $path,
                        'is_thumbnail' => $index === 0, 
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Gagal: ' . $e->getMessage()]);
        }
    }

    public function destroy(Product $product)
    {
        if ($product->store_id !== Auth::user()->store->id) abort(403);
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk dihapus.');
    }
}