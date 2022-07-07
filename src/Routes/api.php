<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Sty\Hutton\Http\Controllers\Api\V1\CustomerController;
use Sty\Hutton\Http\Controllers\Api\V1\SiteController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'api/v1', 'as' => 'api/v1'], function () {
    // Route::get('builder', function (Request $request) {
    //     echo 'api';
    // })->name('builder');

    // Routes for Builders|Customers Module
    Route::resource('customers', CustomerController::class);

    // Routes for sites Crud
    Route::resource('sites', SiteController::class);
    // Route for builder sites || Customer sites
    Route::get('customer/{customer}/sites', [
        SiteController::class,
        'customerSites',
    ])->name('customer.site');
});
