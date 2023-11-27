<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItineraryController;
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
Route::put('/update-destinations/{id_destinasi}', [DestinationController::class, 'updateDestinations']);
Route::delete('/delete-destinations/{id_destinasi}', [DestinationController::class, 'deleteDestinations']);


// Itinerary
Route::get('/get-itinerary', [ItineraryController::class, 'getItinerary']);
Route::post('/get-itinerary/{id_itinerary}', [ItineraryController::class, 'getSpecificItinerary']);
Route::get('/get-itinerary/{id_destinasi}', [ItineraryController::class, 'getSpecificItineraryFromDestination']);
Route::post('/create-itinerary', [ItineraryController::class, 'createItinerary']);
Route::put('/update-itinerary/{id_itinerary}', [ItineraryController::class, 'updateItinerary']);
Route::delete('/delete-itinerary/{id_itinerary}', [ItineraryController::class, 'deleteItinerary']);



// Review

