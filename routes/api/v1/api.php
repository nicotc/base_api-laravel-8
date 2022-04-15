<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/', function () {
//     return "Hello World";
// });


Route::prefix("auth")->group(function () {
    Route::post("login", "App\Http\Controllers\AuthController@login");
    Route::post("register", "App\Http\Controllers\AuthController@register");
    Route::group(['middleware' => 'auth:api'], function() {
        Route::post("logout", "App\Http\Controllers\AuthController@logout");
    });
});


Route::prefix("abogados")->group(function () {
    Route::group(['middleware' => ['role:abogado','auth:api']], function() {
        Route::get('/', function () {
            return "Hello Abogado";
        });
    });
});


Route::prefix("panel")->group(function () {
    Route::group(['middleware' => ['role:panel','auth:api']], function() {
        Route::get('/', function () {
            return "Hello Panel";
        });
    });
});



// Route::group(['prefix' => 'auth'], function () {
//     Route::post('login', 'App\Http\Controllers\API\Auth\LoginController@login');
//     Route::post('signup', 'App\Http\Controllers\API\UserController@signUp');
//     Route::group([
//         'middleware' => 'auth:api'
//     ], function() {
//         Route::post('change-password', 'App\Http\Controllers\API\UserController@change_password');
//         Route::get('logout', 'App\Http\Controllers\API\UserController@logout');
//         Route::get('user', 'App\Http\Controllers\API\UserController@user');
//         }
//     );
// });

//Route::resource('users', App\Http\Controllers\API\UserController::class);



