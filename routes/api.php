<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PacienteController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('paciente', PacienteController::class);

Route::get('search/{name?}', [PacienteController::class, 'search']);

Route::get('cep/{id}', function ($id) {
    $response = Http::get('https://viacep.com.br/ws/'.$id.'/json/');
    return $response->json();
});

Route::get('/', function () {
    return view('welcome');
});
