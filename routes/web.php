<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\TimelineController;
// use App\Http\Controllers\RuaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/auth/{provider}', [SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/{profile}/callback', [SocialAuthController::class, 'callback'])->name('social.callback');


// Rota para obter a rua mais próxima do usuário via AJAX
/* Route::get('/ruas/rua-mais-proxima', [RuaController::class, 'ruaMaisProxima'])
    ->name('ruas.rua-mais-proxima'); */

require __DIR__.'/registro-abastecimento.php';

Route::get('/timeline', [TimelineController::class, 'index'])
    ->name('timeline');
