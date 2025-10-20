<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class MapController extends Controller
{
    public function index()
    {
        return Inertia::render('User/Map');
    }
}
