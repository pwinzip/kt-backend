<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnterpriseController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlantController;
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

// Public Route
Route::post('login', [AuthController::class, 'login']);

// Private Route
// Route::resource('enterprises', EnterpriseController::class);
// Route::resource('farmers', FarmerController::class);
// Route::resource('orders', OrderController::class);

Route::post('plants/{id}', [PlantController::class, 'addPlants']);
Route::get('farmerinfo/{id}', [FarmerController::class, 'getInfo']);
Route::get('farmerplants/{id}', [FarmerController::class, 'getPlants']);
Route::get('members/{id}', [EnterpriseController::class, 'getMembers']);
Route::get('sales/{id}', [EnterpriseController::class, 'getSales']);
Route::post('addsales/{id}', [EnterpriseController::class, 'addSales']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('logout', [AuthController::class, 'logout']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
