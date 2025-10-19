<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ContaController;

Route::get('/', function(){
    return redirect()->route('clientes.index');
});

Route::resource('clientes', ClienteController::class);
Route::resource('contas', ContaController::class);
