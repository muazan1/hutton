<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Sty\Hutton\Http\Controllers\Api\V1\{
    CustomerController,
    SiteController,
    BuildingTypeController,
    JoinerPricingController,
    PlotsController,
    JoinerController,
    ServiceController,
    ServicePricingController,
    HsJobsController,
    WeeklyWorkController,
    DailyWorkController,
    WageSheetController,
    JobFilterController,
    WorkController
};

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

    // Routes for services pricing  Crud
    Route::resource('service-pricings', ServicePricingController::class);

    // Route for Joiner Pricing CRUD
    Route::resource('joiner-pricings', JoinerPricingController::class);

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

    // route for getting building types service pricing
    Route::get('building/{btId}/pricings', [
        ServicePricingController::class,
        'servicePricings',
    ])->name('bt.sp');

    // route for getting building types service pricing
    Route::get('builder/{builderId}/joiner-pricings', [
        JoinerPricingController::class,
        'builderJoinerPricings',
    ])->name('bld.jp');

    // Route for generating the Jobs || Tasks
    Route::post('generate-jobs', [
        HsJobsController::class,
        'GenerateJobs',
    ])->name('generate.jobs');

    // Route for generating Weekly work
    Route::post('generate-weekly-work', [
        WeeklyWorkController::class,
        'StartWeek',
    ])->name('generate.weeklyWork');

    // Route for end Weeklky Work
    Route::post('end-weekly-work/{weekId}', [
        WeeklyWorkController::class,
        'EndWeek',
    ])->name('end.weeklyWork');

    // route for saving daily work
    Route::post('generate-daily-work', [
        DailyWorkController::class,
        'dailyWork',
    ])->name('generate.dailyWork');

    // Route for removing || Deleting daily work
    Route::delete('daily-work/{workId}', [
        DailyWorkController::class,
        'deleteDailyWork',
    ])->name('delete.dailyWork');

    // Route for viewing joiner weekly work
    Route::get('joiner/{joinerId}/week/{weekId}/work', [
        WeeklyWorkController::class,
        'joinerWeeklyWork',
    ])->name('joiner.weeklyWork');

    //Route for Wage Sheet
    Route::get('wage-sheet', [WageSheetController::class, 'wageSheet'])->name(
        'wage-sheet'
    );

    //route for weekly wage sheet
    Route::post('weekly/wage-sheet', [
        WageSheetController::class,
        'wageSheetByWeek',
    ])->name('weekly.wage-sheet');

    /* Routes for jobs filters */

    // route for getting building typpes by site

    // Route::get('site/{siteId}/building-type', [
    //     JobFilterController::class,
    //     'buildingTypeBySite',
    // ])->name('jf.get_bt');

    // route for completed jobs
    Route::get('jobs/completed', [
        JobFilterController::class,
        'completedJobs',
    ])->name('completed.jobs');

    // route for getting
    Route::get('plot/{plot}/jobs', [
        HsJobsController::class,
        'jobsOnPlot',
    ])->name('jobPlots');

    /* Routes end for job fileters */

    // route for assigning job to joiner
    Route::post('job/{jobId}/assign-joiner', [
        HsJobsController::class,
        'assignJobToJoiner',
    ])->name('assign.joiner');

    // Route for Joiner Work History
    Route::get('joiner/{joinerId}/work-history', [
        WorkController::class,
        'JoinerWorkHistory',
    ])->name('work.history');
});
