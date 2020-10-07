<?php
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;


/*************************
 * Authentication Routes *
**************************/
Route::group([
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


/************************************
 * Authentication Restricted Routes *
*************************************/
Route::group([ 'middleware' => 'jwt.auth' ], function($router) {
    Route::apiResource('employees', 'EmployeeController');
    Route::apiResource('companies', 'CompanyController');
});

