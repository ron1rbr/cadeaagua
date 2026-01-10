<?php

use App\Http\Controllers\RegistroAbastecimentoController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function() {
    Route::get('/registros', [RegistroAbastecimentoController::class, 'index'])->name('registros.index');
    Route::get('/registros/create', [RegistroAbastecimentoController::class, 'create'])->name('registros.create');
    Route::post('/registros', [RegistroAbastecimentoController::class, 'store'])->name('registros.store');

    // Registro rápido (modo simplificado)
    Route::post('/registros/rapido/{tipo}', [RegistroAbastecimentoController::class, 'storeRapido'])
        ->name('registros.rapido')
        ->where('tipo', 'chegou|acabou');
});
