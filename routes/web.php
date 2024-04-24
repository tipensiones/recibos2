<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SobresController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
    /*
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
    */
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'years' => [2022, 2023],
        'months' => [
            'ENERO', 'FEBRERO',
            'MARZO', 'ABRIL',
            'MAYO', 'JUNIO',
            'JULIO', 'AGOSTO',
            'SEPTIEMBRE', 'OCTUBRE',
            'NOVIEMBRE', 'DICIEMBRE'
        ]
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('sobres', SobresController::class);
});

require __DIR__.'/auth.php';
