<?php
namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Exception;

use Illuminate\Validation\Rule;

use Mockery\Container;

use Sty\Hutton\Http\Requests\CreateSiteRequest;

use Sty\Hutton\Models\{HsJob, MiscWork, Customer, Plot, Site, WeeklyWork, HuttonUser, DailyWork};

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function joinerRecentWork(Request $request, $uuid)
    {
        try {
            $joiner = HuttonUser::where('uuid', $uuid)->first();

            $joinerId = $joiner->id;

            $work = DailyWork::with('weeklyWork', 'site', 'plot')
                ->whereHas('weeklyWork', function ($query) use ($joinerId) {
                    $query->where('user_id', $joinerId);
                })
                ->paginate(10);

            $works = DailyWork::with('weeklyWork', 'site', 'plot')
                ->whereHas('weeklyWork', function ($query) use ($joinerId) {
                    $query->where('user_id', $joinerId);
                })
                ->get();

            $allWork = DailyWork::with('weeklyWork', 'site', 'plot')
                ->whereHas('weeklyWork', function ($query) use ($joinerId) {
                    $query->where('user_id', $joinerId);
                })
                ->get();

            $months = [
                '01',
                '02',
                '03',
                '04',
                '05',
                '06',
                '07',
                '08',
                '09',
                '10',
                '11',
                '12',
            ];

            $amounts = [];
            //
            foreach ($months as $month) {
                $amt = $allWork = DailyWork::with('weeklyWork', 'site', 'plot')
                    ->whereHas('weeklyWork', function ($query) use ($joinerId) {
                        $query->where('user_id', $joinerId);
                    })
                    ->whereMonth('created_at', $month)
                    ->sum('amount');

                $amounts[] = $amt;
            }

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'work' => $work,
                    'allWork' => $allWork,
                    'months' => $months,
                    'amounts' => $amounts,
                ],
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function adminDashboard(Request $request)
    {
        try {
            $builders = Customer::with('sites.buildingTypes.plots.job')->get();

            $collection = collect($builders)
                ->map(function ($item) {
                    if ($item->sites->count() > 0) {
                        foreach ($item->sites as $site) {
                            if ($site->buildingTypes != null) {
                                foreach (
                                    $site->buildingTypes
                                    as $buildingType
                                ) {
                                    if ($buildingType->plots != null) {
                                        foreach (
                                            $buildingType->plots
                                            as $plot
                                        ) {
                                            if ($plot->job != null) {
                                                foreach ($plot->job as $job) {
                                                    $item->completed_services = $job
                                                        ->where(
                                                            'status',
                                                            'completed'
                                                        )
                                                        ->count();

                                                    $item->not_completed_services = $job
                                                        ->where(
                                                            'status',
                                                            '!=',
                                                            'completed'
                                                        )
                                                        ->count();
                                                }
                                            } else {
                                                $item->completed_services = 0;

                                                $item->not_completed_services = 0;
                                            }
                                        }
                                    } else {
                                        $item->completed_services = 0;

                                        $item->not_completed_services = 0;
                                    }
                                }
                            } else {
                                $item->completed_services = 0;

                                $item->not_completed_services = 0;
                            }
                        }
                    } else {
                        $item->completed_services = 0;

                        $item->not_completed_services = 0;
                    }

                    return [
                        'name' => $item->customer_name,
                        'completed' => $item->completed_services,
                        'not_completed' => $item->not_completed_services,
                    ];
                })
                ->take(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'builders' => $builders,
                    'collection' => $collection,
                ],
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function recentlyCompletedWork()
    {
        try {

            $recent_completed_work = HsJob::where('status','completed')
                ->with('plot','service','joiners','plot.buildingType.site.builder')
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['recent_completed_work' => $recent_completed_work],
            ]);

        } catch (\Throwable $th) {

            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);

        }
    }
}
