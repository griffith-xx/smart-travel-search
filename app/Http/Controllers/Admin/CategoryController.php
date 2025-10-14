<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::get();

        return Inertia::render('Admin/Categories/Index', [
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Categories/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|url|max:255',
            'is_popular' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('flash', [
            'style' => 'success',
            'message' => 'เพิ่มข้อมูลหมวดหมู่เรียบร้อยแล้ว',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/Categories/Edit', [
            'category' => Category::find($id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'name_en' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|nullable|string',
            'image_url' => 'sometimes|required|url|max:255',
            'is_popular' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('flash', [
            'style' => 'success',
            'message' => 'แก้ไขข้อมูลหมวดหมู่เรียบร้อยแล้ว',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('flash', [
            'style' => 'success',
            'message' => 'ลบข้อมูลหมวดหมู่เรียบร้อยแล้ว',
        ]);
    }
}
