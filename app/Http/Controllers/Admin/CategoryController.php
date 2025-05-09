<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.home', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create($validated);

        if ($category) {
            return redirect()->route('admin.categories')->with('success', 'Category added successfully.');
        }

        return back()->with('error', 'Something went wrong.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.update', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories')->with('success', 'Category updated successfully.');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories')->with('success', 'Category deleted successfully.');
    }
}
