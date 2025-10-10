<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $provinces = Province::withCount('destinations')->get();
        $regions = config('regions');

        $regionsMap = collect($regions)->pluck('label', 'value')->toArray();

        return Inertia::render('Admin/Provinces/Index', [
            'provinces' => $provinces,
            'regions' => $regions,
            'regionsMap' => $regionsMap,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Provinces/Create', [
            'regions' => config('regions')
        ]);
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
            'region' => 'required|in:north,central,south,northeast,east,west',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'image_url' => 'required|url|max:255',
            'is_popular' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        Province::create($validated);

        return redirect()->route('admin.provinces.index')->with('flash', [
            'style' => 'success',
            'message' => 'เพิ่มข้อมูลจังหวัดเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Admin/Provinces/Show', [
            'province' => Province::with('destinations')->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return Inertia::render('Admin/Provinces/Edit', [
            'province' => Province::find($id),
            'regions' => config('regions'),
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
            'region' => 'sometimes|required|in:north,central,south,northeast,east,west',
            'latitude' => 'sometimes|nullable|numeric|between:-90,90',
            'longitude' => 'sometimes|nullable|numeric|between:-180,180',
            'image_url' => 'sometimes|required|url|max:255',
            'is_popular' => 'sometimes|boolean',
            'sort_order' => 'sometimes|integer',
        ]);

        $province = Province::findOrFail($id);
        $province->update($validated);

        return redirect()->route('admin.provinces.index')->with('flash', [
            'style' => 'success',
            'message' => 'แก้ไขข้อมูลจังหวัดเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $province = Province::find($id);
        $province->delete();

        return redirect()->route('admin.provinces.index')->with('flash', [
            'style' => 'success',
            'message' => 'ลบข้อมูลจังหวัดเรียบร้อยแล้ว',
        ]);
    }
}
