<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rotas para visualizar os registros de Pokémons
Route::get('/', function () {
    return response()->json(['success' => true, 'message' => 'Bem-vindo ao sistema de Pokémons!']);
});
Route::get('/pokemons', [PokemonController::class, 'index']);
Route::get('/pokemons/{id}', [PokemonController::class, 'show']);

// Rota para inserir um Pokémon
Route::post('/pokemons', [PokemonController::class, 'store']);

// Rota para alterar um Pokémon
Route::put('/pokemons/{id}', [PokemonController::class, 'update']);

// Rota para excluir um Pokémon por id
Route::delete('/pokemons/{id}', [PokemonController::class, 'destroy']);
