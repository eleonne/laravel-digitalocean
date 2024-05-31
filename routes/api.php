<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/send', [PokemonController::class, 'send_pokemon']);
Route::get('/list', [PokemonController::class, 'list_folder']);
Route::get('/players', [PokemonController::class, 'getPlayers']);
Route::get('/players-list', [PokemonController::class, 'getPlayersList']);
Route::get('/max-player', [PokemonController::class, 'getMaxPlayer']);
Route::get('/start', [PokemonController::class, 'start']);
Route::get('/details/{name}', [PokemonController::class, 'getPlayerDetails'])->name('editApplication');
// Route::get('/send', function() {
//     return PokemonController::send_pokemon(); 
//     print_r(PokemonController::send_pokemon());
//     exit;
// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
