<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();
        return view('admin.products.home', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $product = Product::create($validated);

        if ($product) {
            return redirect()->route('admin.products')->with('success', 'Product added successfully.');
        }

        return back()->with('error', 'Something went wrong.');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.update', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'description' => 'required|string',
        ]);

        $product->update($validated);

        return redirect()->route('admin.products')->with('success', 'Product updated successfully.');
    }

    public function delete($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Product deleted successfully.');
    }
}
