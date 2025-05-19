<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function show(Request $request)
    {
        $query = Product::query();


        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
            }
        }

        $products = $query->paginate(8)->withQueryString();

        $categories = Category::all();

        if ($request->ajax()) {
            $productsHtml = view('products.partials.product_list', compact('products'))->render();
            // Evo ispravno: 
            $paginationHtml = view('products.partials.pagination', ['paginator' => $products])->render();

            return response()->json([
                'products' => $productsHtml,
                'pagination' => $paginationHtml,
            ]);
        }


        return view('products.index', compact('products', 'categories'));
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function search(Request $request)
    {
        $term = $request->input('query');

        $products = Product::where('name', 'LIKE', '%' . $term . '%')->limit(5)->get();

        return response()->json($products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image
                    ? asset('storage/' . $product->image)
                    : asset('images/default.webp'),
                'url' => route('products.show', $product->id)
            ];
        }));
    }
}
