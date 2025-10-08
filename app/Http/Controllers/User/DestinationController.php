<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Province;
use Inertia\Inertia;

class DestinationController extends Controller
{
    public function index()
    {
        $provinces = Province::withCount('destinations')->get();
        $destinations = Destination::with('province')->get();

        return Inertia::render('User/Destinations/Index', [
            'provinces' => $provinces,
            'destinations' => $destinations,
        ]);
    }
}
