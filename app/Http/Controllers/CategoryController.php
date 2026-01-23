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
    $validated = $request->validate([
        'name' => 'required|string|max:100|unique:categories,name',
    ]);

    Category::create([
        'name' => $validated['name'],
        'is_active' => true,
    ]);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Kategori berhasil ditambahkan');
}

    // UPDATE
public function update(Request $request, Category $category)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $category->update([
        'name' => $request->name,
    ]);

    return redirect()->back()->with('success', 'Kategori berhasil diperbarui');
}
    

  
public function destroy(Category $category)
{
    $category->delete();

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Kategori berhasil dihapus');
}

public function toggleStatus(Category $category)
{
    $category->update([
        'is_active' => ! $category->is_active
    ]);

    return redirect()
        ->route('admin.categories.index')
        ->with('success', 'Status kategori berhasil diperbarui');
}


}