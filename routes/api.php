<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Auth\LoginController;

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

// メールアドレス認証
Route::get('/email/verify/{id}/{hash}', 'VerifyEmailController@__invoke')
    ->middleware(['signed'])
    ->name('verification.verify');

Route::namespace('Api')->name('api.')->group(function () {
    Route::prefix('login')->name('login')->group(function () {
        Route::post('/', 'UserController@login');
    });

    Route::post('/register', 'UserController@register')->name('register');

    Route::group(['middleware' => ['auth:sanctum', 'verified']],function(){
        Route::get('/user','UserController@getUser');
        Route::post('/logout','UserController@logout');
    });
});
