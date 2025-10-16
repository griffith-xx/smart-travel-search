<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Province;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class ProvinceController extends Controller
{
    public function index()
    {
        try {
            $provinces = Cache::remember('provinces', 3600, function () {
                return Province::select([
                    'id',
                    'name',
                ])->get();
            });

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
