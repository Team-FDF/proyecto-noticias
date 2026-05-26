<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use App\Http\Controllers\NoticiaController;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::post('/logout', function() {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function() {
        return redirect(url('/noticias'));
    })->name('dashboard');

    Route::get('/noticias', [NoticiaController::class, 'index']);
    Route::get('/noticias/create', [NoticiaController::class, 'create']);
    Route::post('/noticias', [NoticiaController::class, 'store']);
    Route::get('/noticias/{id}/edit', [NoticiaController::class, 'edit']);
    Route::put('/noticias/{id}', [NoticiaController::class, 'update']);
    Route::delete('/noticias/{id}', [NoticiaController::class, 'destroy']);
});

require __DIR__.'/settings.php';