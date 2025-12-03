<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/.well-known/appspecific/com.chrome.devtools.json', function () {
    if (app()->environment('local')) {
        return redirect()->away('http://localhost:5173/.well-known/appspecific/com.chrome.devtools.json', 307);
    }
    abort(404);
})->name('devtools');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('design-system', function () {
    return Inertia::render('DesignSystem');
})->middleware(['auth', 'verified'])->name('design-system');

require __DIR__.'/settings.php';
