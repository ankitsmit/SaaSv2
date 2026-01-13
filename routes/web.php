<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Super Admin Routes
Route::middleware(['auth', 'user.type:super_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', ['title' => 'Admin Dashboard']);
    })->name('dashboard');

    // Module Management
    Route::resource('modules', \App\Http\Controllers\Admin\ModuleController::class);
    Route::resource('submodules', \App\Http\Controllers\Admin\SubmoduleController::class);
    
    // Company Management
    Route::resource('companies', \App\Http\Controllers\Admin\CompanyController::class);
    
    // Assign modules/submodules to companies
    Route::post('companies/{company}/modules/{module}/assign', [\App\Http\Controllers\Admin\CompanyModuleController::class, 'assign'])->name('companies.modules.assign');
    Route::delete('companies/{company}/modules/{module}/remove', [\App\Http\Controllers\Admin\CompanyModuleController::class, 'remove'])->name('companies.modules.remove');
    Route::patch('companies/{company}/modules/{module}/toggle', [\App\Http\Controllers\Admin\CompanyModuleController::class, 'toggleStatus'])->name('companies.modules.toggle');
    
    Route::post('companies/{company}/submodules/{submodule}/assign', [\App\Http\Controllers\Admin\CompanySubmoduleController::class, 'assign'])->name('companies.submodules.assign');
    Route::delete('companies/{company}/submodules/{submodule}/remove', [\App\Http\Controllers\Admin\CompanySubmoduleController::class, 'remove'])->name('companies.submodules.remove');
    Route::patch('companies/{company}/submodules/{submodule}/toggle', [\App\Http\Controllers\Admin\CompanySubmoduleController::class, 'toggleStatus'])->name('companies.submodules.toggle');
    
    // Permission Management
    Route::resource('permissions', \App\Http\Controllers\Admin\PermissionController::class);
    
    // User Management (Admin can manage all users)
    Route::resource('users', UserController::class);
});

// Client Routes - Protected by module/submodule access
Route::middleware(['auth', 'user.type:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', function () {
        return view('client.dashboard', ['title' => 'Dashboard']);
    })->name('dashboard');

    // Example: Module-based routes - You can add your modules here
    // Route::middleware(['module.access:example-module'])->group(function () {
    //     Route::middleware(['submodule.access:example-submodule'])->group(function () {
    //         Route::get('/example', function () {
    //             return view('client.modules.example');
    //         })->name('example');
    //     });
    // });
});

// Legacy dashboard route - redirect based on user type
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isSuperAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    
    return redirect()->route('client.dashboard');
})->name('dashboard');

require __DIR__.'/auth.php';
