<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category')->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'qty' => $request->qty,
            'category_id' => $request->category_id,
        ]);

        return redirect('/products');
    }

    public function edit(string $id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $product = Product::find($id);
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'qty' => $request->qty,
            'category_id' => $request->category_id,
        ]);

        return redirect('/products');
    }

    public function destroy(string $id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products');
    }
}
