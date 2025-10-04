<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Inertia\Inertia;

class DestinationController extends Controller
{
    public function index()
    {
        $destinations = Destination::get();

        return Inertia::render('User/Destinations/Index', [
            'destinations' => $destinations,
        ]);
    }
}
