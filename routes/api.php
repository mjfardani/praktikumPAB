<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\TransaksiController;
use App\Http\Controllers\Api\PaymentCallbackController;

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

Route::get('city', [CityController::class, 'index']);

Route::post('get_ongkir', [TransaksiController::class, 'get_ongkir']);
Route::post(
    'payments/midtrans-notification',
    [PaymentCallbackController::class, 'receive']
);
