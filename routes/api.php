<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Crypt;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/store-device-info', [CardController::class, 'deviceStore']);
// Route to get the list of cards with QR codes
Route::get('/cards', [CardController::class, 'getCards']);

// Route to get a specific card's details based on its ID
Route::get('/card/{id}', [CardController::class, 'showCard']);
Route::get('/getCard/{id}', [CardController::class, 'getCard']);
Route::get('/card/addContract/{id}', [CardController::class, 'addContract']);
// Route::get('/user/{id}&{token}', [CardController::class, 'detail']);


Route::post('/login/auth',[CustomAuthController::class,'loginUser'])->name('loginUser');
Route::post('/logout', [CustomAuthController::class, 'logoutUser'])->name('logoutUser');


