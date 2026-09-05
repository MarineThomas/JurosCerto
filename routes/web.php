<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmprestimoController;
use App\Http\Controllers\ParcelaController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\DashboardController;

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

    Route::resource('clientes', ClienteController::class);
    Route::resource('emprestimos', EmprestimoController::class);

    Route::patch('/parcelas/{parcela}/pagar', [ParcelaController::class, 'pagar'])->name('parcelas.pagar');

    Route::get('/relatorios/comprovante/{emprestimo}', [RelatorioController::class, 'comprovante'])
    ->name('relatorios.comprovante');

    Route::get('/relatorios/geral', [RelatorioController::class, 'geral'])
    ->name('relatorios.geral');

    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


    });


require __DIR__.'/auth.php';
