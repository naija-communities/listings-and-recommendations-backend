<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
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

Route::post('/auth/register', AuthController::class . '@register')->name('register');
Route::post('/auth/login', AuthController::class . '@login')->name('login');
Route::get('/auth/logout', AuthController::class . '@logout')->name('logout');

Route::group([
    'prefix' => 'users'
], function() {
    Route::get('/', UserController::class . '@allUsers');
    Route::get('/{user}', UserController::class . '@oneUser');
    Route::put('/{user}', UserController::class . '@update');
    Route::patch('/{user}', UserController::class . '@update');
    Route::delete('/{user}', UserController::class . '@destroy');
});
