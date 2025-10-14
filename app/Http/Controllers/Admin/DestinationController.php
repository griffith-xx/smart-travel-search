<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\FeatureActivity;
use App\Models\FeatureBudgetAccommodation;
use App\Models\FeatureDurationIntensity;
use App\Models\FeatureEnvironment;
use App\Models\FeatureWellnessGoal;
use App\Models\Province;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $destinations  = Destination::with('province')->get();

        return Inertia::render('Admin/Destinations/Index', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinces = Province::get();

        return Inertia::render('Admin/Destinations/Create', [
            'provinces' => $provinces,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            // Basic Information
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'nullable|string',

            // Location & Contact
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string',
            'district' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'line_id' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',

            // Media
            'cover_image' => 'required|url',
            'gallery_images' => 'required|array',
            'gallery_images.*' => 'url',
            'video_url' => 'nullable|url',
            'virtual_tour_url' => 'nullable|url',

            // Pricing & Booking
            'price_from' => 'nullable|numeric',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'pricing_note' => 'nullable|string',
            'accepts_online_booking' => 'nullable|boolean',
            'booking_url' => 'nullable|url',

            // Special Features
            'has_parking' => 'nullable|boolean',
            'has_wifi' => 'nullable|boolean',
            'has_restaurant' => 'nullable|boolean',
            'pet_friendly' => 'nullable|boolean',
            'wheelchair_accessible' => 'nullable|boolean',
            'family_friendly' => 'nullable|boolean',
            'eco_friendly' => 'nullable|boolean',
        ]);

        Destination::create(array_merge($validated, [
            'created_by' => auth('admin')->id(),
        ]));

        return redirect()->route('admin.destinations.index')
            ->with('flash', [
                'style' => 'success',
                'message' => 'เพิ่มสถานที่ท่องเที่ยวเรียบร้อยแล้ว',
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Destination $destination)
    {
        $destination->load([
            'province',
            'preference'
        ]);

        if ($destination->preference) {
            $destination->preference->wellness_goals = FeatureWellnessGoal::whereIn('id', $destination->preference->wellness_goals)->get();
            $destination->preference->activities = FeatureActivity::whereIn('id', $destination->preference->activities)->get();
            $destination->preference->environments = FeatureEnvironment::whereIn('id', $destination->preference->environments)->get();
            $destination->preference->duration_intensity = FeatureDurationIntensity::find($destination->preference->duration_intensity_id);
            $destination->preference->budget_accommodation = FeatureBudgetAccommodation::find($destination->preference->budget_accommodation_id);
        }

        return Inertia::render('Admin/Destinations/Show', [
            'destination' => $destination,
            'regions' => collect(config('regions'))->pluck('label', 'value'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Destination $destination)
    {
        $provinces = Province::orderBy('name')->get();

        $destination->gallery_images_array;

        return Inertia::render('Admin/Destinations/Edit', [
            'destination' => $destination,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            // Basic Information
            'province_id' => 'required|exists:provinces,id',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'short_description' => 'required|string',
            'description' => 'nullable|string',

            // Location & Contact
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'address' => 'nullable|string',
            'district' => 'nullable|string',
            'subdistrict' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'line_id' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',

            // Media
            'cover_image' => 'required|url',
            'gallery_images' => 'required|array',
            'gallery_images.*' => 'url',
            'video_url' => 'nullable|url',
            'virtual_tour_url' => 'nullable|url',

            // Pricing & Booking
            'price_from' => 'nullable|numeric|min:0',
            'price_to' => 'nullable|numeric|min:0|gte:price_from',
            'pricing_note' => 'nullable|string',
            'accepts_online_booking' => 'nullable|boolean',
            'booking_url' => 'nullable|url',

            // Special Features
            'has_parking' => 'nullable|boolean',
            'has_wifi' => 'nullable|boolean',
            'has_restaurant' => 'nullable|boolean',
            'pet_friendly' => 'nullable|boolean',
            'wheelchair_accessible' => 'nullable|boolean',
            'family_friendly' => 'nullable|boolean',
            'eco_friendly' => 'nullable|boolean',

            // Admin & Status
            'is_active' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
            'is_recommended' => 'nullable|boolean',
            'admin_notes' => 'nullable|string',
        ]);

        $destination->update(array_merge($validated, [
            'updated_by' => auth('admin')->id(),
        ]));

        return redirect()->route('admin.destinations.index')
            ->with('flash', [
                'style' => 'success',
                'message' => 'แก้ไขสถานที่ท่องเที่ยวเรียบร้อยแล้ว',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('flash', [
                'style' => 'success',
                'message' => 'ลบสถานที่ท่องเที่ยวเรียบร้อยแล้ว',
            ]);
    }

    /**
     * Toggle active status
     */
    public function toggleActive(Destination $destination)
    {
        $destination->update([
            'is_active' => !$destination->is_active,
            'updated_by' => auth('admin')->id(),
        ]);

        return back()->with('flash', [
            'style' => 'success',
            'message' => $destination->is_active
                ? 'เปิดใช้งานสถานที่ท่องเที่ยวแล้ว'
                : 'ปิดใช้งานสถานที่ท่องเที่ยวแล้ว',
        ]);
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Destination $destination)
    {
        $destination->update([
            'is_featured' => !$destination->is_featured,
            'updated_by' => auth('admin')->id(),
        ]);

        return back()->with('flash', [
            'style' => 'success',
            'message' => $destination->is_featured
                ? 'เพิ่มเป็นสถานที่แนะนำแล้ว'
                : 'ยกเลิกสถานที่แนะนำแล้ว',
        ]);
    }

    /**
     * Restore soft deleted destination
     */
    public function restore($id)
    {
        $destination = Destination::withTrashed()->findOrFail($id);
        $destination->restore();

        return back()->with('flash', [
            'style' => 'success',
            'message' => 'กู้คืนสถานที่ท่องเที่ยวเรียบร้อยแล้ว',
        ]);
    }

    /**
     * Force delete destination permanently
     */
    public function forceDelete($id)
    {
        $destination = Destination::withTrashed()->findOrFail($id);
        $destination->forceDelete();

        return redirect()->route('admin.destinations.index')
            ->with('flash', [
                'style' => 'success',
                'message' => 'ลบสถานที่ท่องเที่ยวถาวรเรียบร้อยแล้ว',
            ]);
    }
}
