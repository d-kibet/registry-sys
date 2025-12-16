<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;
use App\Models\AuditLog;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request with role-based redirect
     */
    public function login(Request $request)
    {
        $request->validate([
            'id_number' => ['required', 'numeric'],
            'pin' => ['required', 'digits:4'],
        ]);

        // Rate limiting - 5 attempts per minute
        $key = 'login.' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'id_number' => ["Too many login attempts. Please try again in {$seconds} seconds."],
            ]);
        }

        // Find user by id_number first
        $user = \App\Models\User::where('id_number', $request->id_number)->first();

        // Check if user exists and is active before attempting authentication
        if ($user && !$user->is_active) {
            RateLimiter::hit($key, 60);
            throw ValidationException::withMessages([
                'id_number' => ['Your account has been deactivated. Please contact your administrator.'],
            ]);
        }

        // Attempt login using id_number and pin (Laravel expects 'password' field)
        if (Auth::attempt(['id_number' => $request->id_number, 'password' => $request->pin], $request->boolean('remember'))) {
            RateLimiter::clear($key);

            $user = Auth::user();

            // Update last login timestamp
            $user->updateLastLogin();

            // Log successful login
            AuditLog::log('user_logged_in', $user);

            $request->session()->regenerate();

            // Role-based redirect
            return $this->redirectBasedOnRole($user);
        }

        // Failed login attempt
        RateLimiter::hit($key, 60);

        throw ValidationException::withMessages([
            'id_number' => ['The provided credentials do not match our records.'],
        ]);
    }

    /**
     * Redirect user based on their role
     */
    protected function redirectBasedOnRole($user)
    {
        if ($user->isSuperAdmin()) {
            return redirect()->intended(route('super-admin.dashboard'));
        }

        if ($user->isCompanyAdmin()) {
            return redirect()->intended(route('company-admin.dashboard'));
        }

        if ($user->isAgent()) {
            return redirect()->intended(route('agent.dashboard'));
        }

        // Default redirect if no role matches
        Auth::logout();
        throw ValidationException::withMessages([
            'email' => ['No valid role assigned. Please contact your administrator.'],
        ]);
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        // Log logout action
        if (Auth::check()) {
            AuditLog::log('user_logged_out', Auth::user());
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
