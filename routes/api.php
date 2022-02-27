<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProtectedController;

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

Route::prefix('v1')->group(function(){

  Route::controller(AuthController::class)->group(function(){
    Route::post('/auth', 'doAuthenticate');
  });
  
  Route::middleware('auth.logged')->group(function(){

    Route::middleware('auth.role.admin')->group(function(){
      
      Route::controller(UserController::class)->group(function(){
        Route::get('/user/admins', 'doFetchUserWithAdminRole');
        Route::get('/user/normal', 'doFetchUserWithUserRole');
        Route::get('/user/my', 'doFetchLoggedUser');
        Route::get('/user/{id}', 'doFetchUserById');
        Route::get('/users', 'doFetchUsers');
      });

    });
    
    Route::middleware('auth.role.user')->group(function(){
      
      Route::controller(ProtectedController::class)->group(function(){
        Route::get('/protected', 'doFetchProtected');
      });
      
    });

  });

});

