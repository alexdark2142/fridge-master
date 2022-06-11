<?php

use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\LocationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('locations')->group(function () {
    Route::get('/', [LocationController::class, 'index']);
    Route::get('/{id}', [LocationController::class, 'show']);
    Route::post('/{id}/calculator', [LocationController::class, 'calculator']);
});

Route::prefix('user')->group(function () {
    Route::get('/{userId}/booking', [BookingController::class, 'list']);
    Route::post('/{userId}/booking', [BookingController::class, 'store']);
});
