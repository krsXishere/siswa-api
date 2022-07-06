<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SiswaController;
use App\Http\Controllers\AuthController;

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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('siswa', [SiswaController::class, 'index']);
    Route::get('siswa/{id}', [SiswaController::class, 'show']);
    Route::post('siswa/input', [SiswaController::class, 'store']);
    Route::put('siswa/update/{id}', [SiswaController::class, 'update']);
    Route::delete('siswa/delete/{id}', [SiswaController::class, 'destroy']);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
