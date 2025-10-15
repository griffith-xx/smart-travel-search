<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Destination;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class DestinationController extends Controller
{
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

    /**
     * Get all destinations
     */
    public function index(Request $request)
    {
        try {
            $perPage = $request->input('per_page', 15);

            $destinations = Destination::with('province')
                ->when($request->has('is_active'), function ($query) use ($request) {
                    $query->where('is_active', $request->boolean('is_active'));
                })
                ->when($request->has('is_featured'), function ($query) use ($request) {
                    $query->where('is_featured', $request->boolean('is_featured'));
                })
                ->when($request->has('province_id'), function ($query) use ($request) {
                    $query->where('province_id', $request->input('province_id'));
                })
                ->orderBy('sort_order', 'asc')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);

            return response()->json([
                'success' => true,
                'data' => $destinations
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch destinations',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get single destination
     */
    public function show($id)
    {
        try {
            $destination = Destination::with(['province', 'preference'])->find($id);

            if (!$destination) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination not found'
                ], 404);
            }

            // เพิ่ม view count
            $destination->increment('view_count');

            return response()->json([
                'success' => true,
                'data' => $destination
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update destination
     */
    public function update(Request $request, $id)
    {
        try {
            $destination = Destination::find($id);

            if (!$destination) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination not found'
                ], 404);
            }

            $validator = Validator::make(
                $request->all(),
                [
                    // Basic Information
                    'province_id' => 'sometimes|required|exists:provinces,id',
                    'name' => 'sometimes|required|string|max:255',
                    'name_en' => 'sometimes|required|string|max:255',
                    'short_description' => 'sometimes|required|string',
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
                    'cover_image' => 'sometimes|required|url',
                    'gallery_images' => 'sometimes|required|array',
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

            $data = $validator->validated();

            // แปลง gallery_images จาก array เป็น JSON string
            if (isset($data['gallery_images'])) {
                $data['gallery_images'] = json_encode($data['gallery_images']);
            }

            // ตั้งค่า updated_by
            if ($request->user() && $request->user() instanceof \App\Models\Admin) {
                $data['updated_by'] = $request->user()->id;
            }

            // slug จะถูกอัพเดทอัตโนมัติใน boot() method ถ้า name_en หรือ name เปลี่ยน
            $destination->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Destination updated successfully',
                'data' => $destination->fresh()->load('province')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete destination
     */
    public function destroy($id)
    {
        try {
            $destination = Destination::find($id);

            if (!$destination) {
                return response()->json([
                    'success' => false,
                    'message' => 'Destination not found'
                ], 404);
            }

            $destination->delete();

            return response()->json([
                'success' => true,
                'message' => 'Destination deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
