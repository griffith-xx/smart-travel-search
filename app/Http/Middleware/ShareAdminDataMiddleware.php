<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Province;
use App\Models\Destination;

class ShareAdminDataMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $request->merge([
            'inertia_admin_stats' => [
                'provinces_count' => Province::count(),
                'destinations_count' => Destination::count(),
            ]
        ]);

        return $next($request);
    }
}
