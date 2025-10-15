<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Http\Controllers\Controller;
use App\Models\DestinationScraper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DestinationScraperController extends Controller
{
    public function index()
    {
        try {
            $destinationScrapers = DestinationScraper::get();
            return response()->json($destinationScrapers);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch destination scraper data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'url' => 'required|url|',
                'body' => 'required|json',
                'http_status_code' => 'required|numeric',
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
            $destinationScraper = DestinationScraper::create($data);

            return response()->json([
                'success' => true,
                'message' => 'DestinationScraper created successfully',
                'data' => $destinationScraper,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create DestinationScraper',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DestinationScraper::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'DestinationScraper deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete DestinationScraper',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
