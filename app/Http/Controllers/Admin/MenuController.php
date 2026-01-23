<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->get();
        $categories = Category::all();

        return view('admin.menus.index', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id'=> 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
        ]);

        Menu::create($request->all());

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id'=> 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
        ]);

        $menu->update($request->all());

        return redirect()
            ->route('admin.menus.index')
            ->with('success', 'Menu berhasil diperbarui');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return back()->with('success', 'Menu berhasil dihapus');
    }

    public function toggle(Menu $menu)
    {
        $menu->update([
            'is_active' => ! $menu->is_active
        ]);

        return back();
    }
}
