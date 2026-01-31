<?php

use App\Http\Controllers\RegistroAbastecimentoController;

Route::middleware(['auth'])->group(function() {
    Route::get('/registros', [RegistroAbastecimentoController::class, 'index'])->name('registros.index');
    Route::get('/registros/create', [RegistroAbastecimentoController::class, 'create'])->name('registros.create');
    Route::post('/registros', [RegistroAbastecimentoController::class, 'store'])->name('registros.store');

    Route::post('/registros/rapido/{tipoEvento}', [RegistroAbastecimentoController::class, 'storeRapido'])
        ->name('registros.rapido')
        ->where('tipoEvento', 'chegou|acabou');

    Route::get('/registros/historico', [RegistroAbastecimentoController::class, 'historico'])->name('registros.historico');
});
