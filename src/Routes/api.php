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
    WorkController,
    DashboardController,
    ReportController,
    ChatController,
    JobsController
};

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::middleware(['auth:sanctum'])->group(function () {

Route::group(['prefix' => 'api/v1', 'as' => 'api/v1'], function () {
    Route::get('joiners/map', [JoinerController::class, 'map']);

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

    Route::resource('plot-jobs', HsJobsController::class);

    // Route for builder sites || Customer sites
    Route::get('builder/{customer}/sites', [
        SiteController::class,
        'customerSites',
    ])->name('customer.site');

    //Route for getting Building Types for specific site
    Route::get('site/{slug}/building-types', [
        BuildingTypeController::class,
        'SiteBuildingTypes',
    ])->name('sites.buildingTypes');

    //Route for getting plots for specific Building Types
    Route::get('building-type/{btId}/plots', [
        PlotsController::class,
        'BuildingTypePlots',
    ])->name('buildingTypes.plots');

    Route::get('plot/{plotId}/services', [
        HsJobsController::class,
        'servicesByPlot',
    ])->name('servicesbyPlots');

    // route for getting building types service pricing
    Route::get('building-type/{btId}/pricings', [
        ServicePricingController::class,
        'servicePricings',
    ])->name('bt.sp');

    Route::get('building-type/{btId}/pricings/services', [
        ServicePricingController::class,
        'servicesWithPricings',
    ])->name('bt.wsp');

    // route for getting building types service pricing
    Route::get('building-type//{builderId}/joiner-pricings', [
        JoinerPricingController::class,
        'builderJoinerPricings',
    ])->name('bld.jp');

    Route::get('building-type/{builderId}/joiner-pricings/services', [
        JoinerPricingController::class,
        'builderJoinerPricingsServices',
    ])->name('bld.jps');

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

    //    route for saving daily miscellaneous work
    Route::post('generate-daily-misc-work', [
        DailyWorkController::class,
        'dailyMiscWork',
    ])->name('generate.dailyMiscWork');

    // Route for removing || Deleting daily work
    Route::delete('daily-work/{workId}', [
        DailyWorkController::class,
        'deleteDailyWork',
    ])->name('delete.dailyWork');

    //    Route for removing || deleting the daily miscellanous work
    Route::delete('daily-misc-work/{workId}', [
        DailyWorkController::class,
        'deleteDailyMiscWork',
    ])->name('delete.dailyMiscWork');

    // Route for viewing joiner weekly work
    Route::get('week/{weekId}/work', [
        WeeklyWorkController::class,
        'joinerWeeklyWork',
    ])->name('joiner.weeklyWork');

    // Get Current week
    Route::get('joiner/{joinerId}/current_week', [
        WeeklyWorkController::class,
        'currentWeek',
    ]);

    // Get Current day
    Route::get('joiner/{joinerId}/current_day', [
        WeeklyWorkController::class,
        'currentDay',
    ]);

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

    //    Route for Jobs Main filter for admin
    Route::post('admin/jobs/filter', [
        JobFilterController::class,
        'adminJobFilter',
    ])->name('admin.job.filter');

    Route::get('joiner/jobs/filter', [
        JobFilterController::class,
        'joinerJobFilter',
    ])->name('joiner.job.filter');

    Route::get('jobs/completed', [
        JobFilterController::class,
        'completedJobs',
    ])->name('completed.jobs');

    // route for getting
    Route::get('plot/{plot}/jobs', [
        HsJobsController::class,
        'jobsOnPlot',
    ])->name('jobPlots');

    /* Routes end for job filters */

    // route for assigning job to joiner
    Route::post('job/{jobId}/assign-joiner', [
        HsJobsController::class,
        'assignJobToJoiner',
    ])->name('assign.joiner');

    // route for removeing job to joiner
    Route::post('job/{jobId}/remove-joiner', [
        HsJobsController::class,
        'removeJobToJoiner',
    ])->name('remove.joiner');

    // Route for Joiner Work History
    Route::get('joiner/{joinerId}/work-history', [
        WorkController::class,
        'JoinerWorkHistory',
    ])->name('work.history');

    /* Admin Jobs Controller*/

    Route::get('admin/jobs', [HsJobsController::class, 'adminJobs'])->name(
        'admin.jobs'
    );

    //    Route for joiner jobs
    Route::get('joiner/{uuid}/jobs', [
        HsJobsController::class,
        'joinerJobs',
    ])->name('joiner.jobs');

    Route::get('jobs/{job}', [HsJobsController::class, 'getJob'])->name(
        'get.job'
    );

    //    Routes for dashboard api's

    //    for joiner recent work api
    Route::get('joiner/{uuid}/recent-works', [
        DashboardController::class,
        'joinerRecentWork',
    ])->name('joinerRecentWork.dashboard');

    //        get joiner by uuid
    Route::get('joiner/{uuid}', [
        JoinerController::class,
        'joinerDetails',
    ])->name('joiner.view');

    //        Route for admin dashboard
    Route::get('admin/dashboard', [
        DashboardController::class,
        'adminDashboard',
    ]);

    //        route for getting recently completed services
    Route::get('admin/recently-completed-work', [
        DashboardController::class,
        'recentlyCompletedWork',
    ]);

    //  Route for site details
    Route::get('site/{slug}', [SiteController::class, 'details']);

    //    for site dashboard
    Route::get('site/{slug}/jobs', [HsJobsController::class, 'jobsOnSite']);

    //    for jobs on each builder
    Route::get('builder/{slug}/jobs', [
        HsJobsController::class,
        'jobsOnBuilder',
    ]);

    //    Route for site dashboard

    Route::controller(DashboardController::class)->group(function () {
        Route::get('site/{slug}/dashboard', 'siteDashboard');

        Route::get('site/{slug}/dashboard/bars', 'siteDashboardBars');

        Route::get(
            'site/{slug}/dashboard/completions',
            'siteDashboardCompletionChart'
        );

        Route::get('builder/{slug}/dashboard/pieChart', 'BuilderPieChart');

        Route::get('admin/dashboard/pieChart', 'AdminPieChart');
    });

    //    Admin Report Routes
    Route::controller(ReportController::class)->group(function () {
        Route::prefix('admin/reports/')->group(function () {
            Route::post('builder-jobs-completed', 'builderJobsCompleted');

            Route::post('builder-remaining-jobs', 'builderRemainingJobs');

            Route::post('joiner-completed-jobs', 'joinerCompletedJobs');

            Route::post('joiner-wage-sheet', 'joinerWageSheet');

            Route::post('builder-invoice-sheet', 'builderInvoiceSheet');

            Route::post('report-by-site', 'ReportBySite');
        });
    });

    //    Chat Routes

    Route::controller(ChatController::class)->group(function () {
        Route::prefix('chat/')->group(function () {
            Route::post('create', 'CreateChat');

            Route::post('{chat}/message', 'CreateMessage');

            Route::get('{chat}', 'GetChat');

            Route::post('send-message', 'sendMessage');
        });
    });

    //    ROute for getting admins
    Route::get('admins', [DashboardController::class, 'getAdmins']);

    Route::get('admin/{uuid}/notifications', [
        ChatController::class,
        'adminNotifications',
    ]);

    Route::get('joiner/{uuid}/notifications', [
        ChatController::class,
        'joinerNotifications',
    ]);

    Route::post('message/reply', [ChatController::class, 'chatReply']);

    Route::get('message/{message_id}/mark_read', [
        ChatController::class,
        'markRead',
    ]);

    Route::get('message/{message_id}/details', [
        ChatController::class,
        'messageDetails',
    ]);

    // automatic complet jobs
    Route::controller(JobsController::class)->group(function () {
        Route::prefix('joiner/{joiner}/job/{job}')->group(function () {
            Route::post('complete', 'CompleteJob');

            Route::post('part-complete', 'PartCompleteJob');
        });
    });
});
