<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\PlaylistController;
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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->middleware('auth')->name('index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
Route::prefix('/')->middleware('auth')->group(function() {
    Route::prefix('music')->name('music.')->group(function() {
        Route::get('/', [MusicController::class, 'index'])->name('index');
        Route::get('/create', [MusicController::class, 'create'])->name('create');
        Route::post('/create', [MusicController::class, 'store'])->name('store');
        Route::get('/{music}', [MusicController::class, 'show'])->name('show');
        Route::get('/{music}/edit', [MusicController::class, 'edit'])->name('edit');
        Route::put('/{music}', [MusicController::class, 'update'])->name('update');
        Route::delete('/{music}', [MusicController::class, 'destroy'])->name('delete');
    });

    Route::prefix('playlist')->name('playlist.')->group(function() {
        Route::get('/', [PlaylistController::class, 'index'])->name('index');
        Route::get('/create', [PlaylistController::class, 'create'])->name('create');
        Route::post('/create', [PlaylistController::class, 'store'])->name('store');
        Route::get('/{playlist}', [PlaylistController::class, 'show'])->name('show');
        Route::get('/{playlist}/edit', [PlaylistController::class, 'edit'])->name('edit');
        Route::put('/{playlist}', [PlaylistController::class, 'update'])->name('update');
        Route::delete('/{playlist}', [PlaylistController::class, 'destroy'])->name('delete');
    });

    Route::prefix('album')->name('album.')->group(function() {
        Route::get('/', [AlbumController::class, 'index'])->name('index');
        Route::get('/create', [AlbumController::class, 'create'])->name('create');
        Route::post('/create', [AlbumController::class, 'store'])->name('store');
        Route::get('/{album}', [AlbumController::class, 'show'])->name('show');
        Route::get('/{album}/edit', [AlbumController::class, 'edit'])->name('edit');
        Route::put('/{album}', [AlbumController::class, 'update'])->name('update');
        Route::delete('/{album}', [AlbumController::class, 'destroy'])->name('delete');
    });
});

