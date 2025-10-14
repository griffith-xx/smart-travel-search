<?php

namespace App\Http\Middleware;

use App\Models\Category;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Province;
use App\Models\Destination;
use App\Models\User;
use PhpParser\Node\Stmt\Catch_;

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
                'users_count' => User::count(),
                'categories_count' => Category::count(),
            ]
        ]);

        return $next($request);
    }
}
