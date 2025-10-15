<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::with(['province', 'categories'])->get();
        return response()->json($destinations);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
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
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $data = $validator->validated();
            $destination = Destination::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Destination created successfully',
                'data' => $destination->load('province')
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        Destination::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Destination deleted successfully'
        ], 200);
    }
}
