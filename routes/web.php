<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\CarroController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('marcas', MarcaController::class);
Route::resource('modelos', ModeloController::class);
Route::resource('carros', CarroController::class);
Route::resource('clientes', ClienteController::class);
Route::resource('locacoes', LocacaoController::class)->parameters([
    'locacoes' => 'locacao',
]);
Route::patch('locacoes/{locacao}/concluir', [LocacaoController::class, 'concluir'])
    ->name('locacoes.concluir');