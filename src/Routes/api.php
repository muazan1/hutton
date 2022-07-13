<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Sty\Hutton\Http\Controllers\Api\V1\CustomerController;
use Sty\Hutton\Http\Controllers\Api\V1\SiteController;
use Sty\Hutton\Http\Controllers\Api\V1\BuildingTypeController;
use Sty\Hutton\Http\Controllers\Api\V1\PlotsController;
use Sty\Hutton\Http\Controllers\Api\V1\ServiceController;
use Sty\Hutton\Http\Controllers\Api\V1\JoinerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'api/v1', 'as' => 'api/v1'], function () {
    // Route::get('builder', function (Request $request) {
    //     echo 'api';
    // })->name('builder');

    // Routes for Builders|Customers Module
    Route::resource('customers', CustomerController::class);

    // Routes for Joiner Module
    Route::resource('joiners', JoinerController::class);

    // Routes for sites Crud
    Route::resource('sites', SiteController::class);

    // Routes for Buidling Types Crud
    Route::resource('building-types', BuildingTypeController::class);

    // Routes for Plots Crud
    Route::resource('plots', PlotsController::class);

    // Routes for services Crud
    Route::resource('services', ServiceController::class);

    // Route for builder sites || Customer sites
    Route::get('customer/{customer}/sites', [
        SiteController::class,
        'customerSites',
    ])->name('customer.site');

    //Route for getting Building Types for specific site
    Route::get('site/{site}/building-types', [
        BuildingTypeController::class,
        'SiteBuildingTypes',
    ])->name('sites.buildingTypes');

    //Route for getting plots for specific Building Types
    Route::get('building-type/{btId}/plots', [
        PlotsController::class,
        'BuildingTypePlots',
    ])->name('buildingTypes.plots');
});
