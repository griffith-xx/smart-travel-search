<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Destination;
use App\Models\Province;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index()
    {
        $provinces = Province::withCount('destinations')->get();
        $categories = Category::withCount('destinations')->get();
        $destinations = Destination::with('province')->get();

        return Inertia::render('Welcome', [
            'provinces' => $provinces,
            'categories' => $categories,
            'destinations' => $destinations,
        ]);
    }
}
