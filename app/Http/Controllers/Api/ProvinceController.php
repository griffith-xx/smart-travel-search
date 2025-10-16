<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Exception;

class ProvinceController extends Controller
{
    public function index()
    {
        try {
            $provinces = Province::get();
            return response()->json($provinces);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch provinces',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
