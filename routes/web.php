<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CustomAuthController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;

use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Http\Request;

use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/dashboard', function () {
    return view('app');
});


Route::get('/userPage', function () {
    return view('app');
});



      

Route::get('CeKjC3ep2f1elK92P6ttwYHHwUpOtRF55yo9Gaxy5MD5gjkU4Xh0iKFqvGXprJI2/{id}&{token}', [CustomAuthController::class, 'AllowLoginConnect']);
Route::get('/generate-encrypted-card-url/{id}', [CardController::class, 'generateEncrypted']);
Route::get('/get-ip', [CardController::class, 'getIp']);

// Route::get('/admin', function () {
//     return view('app');
// });

// Route::get('/Userd', function () {
//     return view('app');
// });

// Route::get('/admin/detail', function () {
//     return view('app');
// });

Route::get('/getCard/{id}', function () {
    return view('app');
});

Route::middleware(['alreadyLogin'])->group(function () {
    Route::get('/login', function () {
        return view('app');
    });
});

Route::middleware(['isLogin'])->group(function () {
    Route::get('/', function () {
        return view('app');
    });
    Route::get('/showcard/{id}', function () {
        return view('app');
    });
});


Route::get('/camera', function () {
    return view('app');
});

Route::get('/user/{id}&{token}', function () {
    return view('app');
});

// Route::get('aa/{id}&{token}', [CardController::class, 'detail']);

// Route::get('/', function () {
//     return view('app');
// });
// Route::get('/showcard/{id}', function () {
//     return view('app');
// });
