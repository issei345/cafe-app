<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    // READ (lihat data)
    public function index()
    {
        $categories = Category::all();
     return view('admin.categories.index', compact('categories'));
    }

    // CREATE (simpan data)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        Category::create([
            'name' => $request->name,
            'is_active' => true
        ]);

        return redirect()->back();
    }

    // UPDATE
    public function update(Request $request, Category $category)
    {
        $category->update([
            'name' => $request->name
        ]);

        return redirect()->back();
    }

    // DELETE
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->back();
    }
}