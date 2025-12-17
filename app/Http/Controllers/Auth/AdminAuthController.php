<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function showLoginPage()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        if (app()->environment('local')) {
            $email = env('TEST_ADMIN_EMAIL');
            $password = env('TEST_ADMIN_PASSWORD');

            if ($email && $password) {
                if (Auth::guard('admin')->attempt(['email' => $email, 'password' => $password], true)) {
                    request()->session()->regenerate();

                    return redirect()->intended(route('admin.dashboard'));
                }
            }
        }

        return Inertia::render('Auth/AdminLogin');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('welcome');
    }
}
