<?php

use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\PeliculasController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/peliculas', [PeliculasController::class, 'consulta']);
Route::get('/peliculas/{id}', [PeliculasController::class, 'detalle']);
Route::post('/peliculas', [PeliculasController::class, 'alta']);
Route::put('/peliculas/mantenimiento/{pelicula}', [PeliculasController::class, 'modificacion']);
Route::delete('/peliculas/mantenimiento/{pelicula}', [PeliculasController::class, 'baja']);
Route::get('/categorias',[CategoriasController::class, 'consulta']);
Route::post('/categorias', [CategoriasController::class, 'alta']);
Route::put('/categorias/{categoria}', [CategoriasController::class, 'modificar']);
Route::delete('/categorias/{categoria}', [CategoriasController::class, 'baja']);
