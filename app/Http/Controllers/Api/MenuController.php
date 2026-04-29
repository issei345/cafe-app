<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->get();

        return response()->json([
            'success' => true,
            'data' => $menus
        ]);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $menu
        ]);
    }

    /**
     * Store a new menu item.
     * Optimized: single INSERT + 1 relationship load, lean JSON, 201 status.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price'       => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
        ]);

        $menu = Menu::create($validated);

        // Load category so frontend can display it immediately
        $menu->load('category');

        return response()->json([
            'success' => true,
            'data' => $menu
        ], 201);
    }
}
