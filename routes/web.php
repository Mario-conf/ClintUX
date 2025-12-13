<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/clintux', [DashboardController::class, 'index'])->name('clintux');

    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('apps', \App\Http\Controllers\Admin\AppController::class);
        Route::get('audits', [\App\Http\Controllers\Admin\AuditController::class, 'index'])->name('audits.index');
    });

    // Proxy Routes
    Route::any('/apps/{slug}/{path?}', \App\Http\Controllers\ProxyController::class)
        ->where('path', '.*')
        ->name('apps.proxy');

    // Docker Routes
    Route::post('/docker/create', [\App\Http\Controllers\DockerController::class, 'store'])->name('docker.store');
    Route::post('/docker/{id}/{action}', [\App\Http\Controllers\DockerController::class, 'action'])
        ->name('docker.action');

    // System Routes
    Route::post('/system/power/{action}', [\App\Http\Controllers\SystemController::class, 'power'])
        ->name('system.power');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Theme Switcher
    Route::post('/theme-switch', function (\Illuminate\Http\Request $request) {
        $theme = $request->input('theme');
        session(['theme' => $theme]);

        if (auth()->check()) {
            auth()->user()->update(['theme' => $theme]);
        }

        return response()->json(['status' => 'success']);
    })->name('theme.switch');
});

require __DIR__ . '/auth.php';
