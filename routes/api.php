<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DestinationController;


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


// Middleware create soon
// Auth Customer Users
Route::get('/get-users', [UserController::class, 'getUsers']);
Route::post('/get-users/{id_customer}', [UserController::class, 'getSpecificUsers']);
Route::post('/register', [UserController::class, 'registerUsers']);
Route::post('/login', [UserController::class, 'loginUsers']);
Route::get('/logout', [UserController::class, 'logoutUsers']);

// Destination 
Route::get('/get-destinations', [DestinationController::class, 'getDestinations']);
Route::post('/get-destinations/{id_destinasi}', [DestinationController::class, 'getSpecificDestinations']);
Route::post('/create-destinations', [DestinationController::class, 'createDestinations']);
Route::post('/update-destinations/{id_destination}', [DestinationController::class, 'updateDestinations']);
Route::post('/delete-destinations/{id_destination}', [DestinationController::class, 'deleteDestinations']);


