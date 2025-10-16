<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Cache::remember('categories', 3600, function () {
                return Category::select([
                    'id',
                    'name',
                ])->get();
            });
            return response()->json($categories);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch categories',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
