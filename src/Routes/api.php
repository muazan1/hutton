<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Sty\Hutton\Http\Controllers\Api\V1\BuilderController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//

Route::group(['prefix' => 'api/v1', 'as' => 'api/v1'], function () {
    // Route::get('builder', function (Request $request) {
    //     echo 'api';
    // })->name('builder');

    // Routes for Builders Module
    Route::resource('builders', BuilderController::class);
});
