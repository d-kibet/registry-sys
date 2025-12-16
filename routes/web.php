<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Offline page for PWA
Route::get('/offline', function () {
    return view('offline');
})->name('offline');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Super Admin Routes
Route::middleware(['auth', 'role:Super Admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('super-admin.dashboard');
    })->name('dashboard');

    // Companies Management
    Route::get('/companies', function () {
        return view('super-admin.companies');
    })->name('companies.index');

    // Agents Management
    Route::get('/agents', function () {
        return view('super-admin.agents');
    })->name('agents.index');

    // All Registrations
    Route::get('/registrations', function () {
        return view('super-admin.registrations');
    })->name('registrations.index');

    // Audit Logs
    Route::get('/audit-logs', function () {
        return view('super-admin.audit-logs');
    })->name('audit-logs');
});

// Company Admin Routes
Route::middleware(['auth', 'role:Company Admin'])->prefix('company-admin')->name('company-admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('company-admin.dashboard');
    })->name('dashboard');

    // Agent Management
    Route::get('/agents', function () {
        return view('company-admin.agents.index');
    })->name('agents.index');

    // Registrations
    Route::get('/registrations', function () {
        return view('company-admin.registrations.index');
    })->name('registrations.index');

    // Reports
    Route::get('/reports', function () {
        return view('company-admin.reports');
    })->name('reports');

    // Export
    Route::get('/export', function () {
        return view('company-admin.export');
    })->name('export');
});

// Agent Routes
Route::middleware(['auth', 'role:Agent'])->prefix('agent')->name('agent.')->group(function () {
    Route::get('/dashboard', function () {
        return view('agent.dashboard');
    })->name('dashboard');

    // Member Registration
    Route::get('/register', function () {
        return view('agent.register');
    })->name('register');

    // My Registrations
    Route::get('/my-registrations', function () {
        return view('agent.my-registrations');
    })->name('my-registrations');

    // Performance Stats
    Route::get('/stats', function () {
        return view('agent.stats');
    })->name('stats');
});

// API Routes for AJAX requests
Route::middleware('auth')->prefix('api')->group(function () {
    // Check phone number duplicate
    Route::post('/check-phone', function (Illuminate\Http\Request $request) {
        $phone = $request->input('phone_number');
        $member = App\Models\Member::where('phone_number', $phone)->with(['registeredBy', 'company'])->first();

        if ($member) {
            $agentName = $member->registeredBy?->name ?? 'Unknown Agent';
            $companyName = $member->company?->name ?? 'Unknown Company';
            $registeredDate = $member->created_at->format('d/m/Y');

            return response()->json([
                'exists' => true,
                'message' => "This phone number is already registered on {$registeredDate} by {$agentName} from {$companyName}",
                'member' => [
                    'id' => $member->id,
                    'full_name' => $member->full_name,
                    'phone_number' => $member->phone_number,
                    'registered_at' => $registeredDate,
                ]
            ]);
        }

        return response()->json(['exists' => false]);
    })->middleware('throttle:60,1')->name('api.check-phone');
});
