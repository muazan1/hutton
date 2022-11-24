<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\{Validator};

use DB;

use Str;

use Exception;

use Sty\Hutton\Models\{
    PlotJob,
    HuttonUser,
    Plot,
    Site,
    HouseType,
    JoinerPricing,
    ServicePricing,
    Service
};

use App\Models\{Role};

use Illuminate\Pagination\LengthAwarePaginator;

class PlotJobsController extends Controller
{
    public function GenerateJobs(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'plots' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors(),
                ]);
            }

            $plots = $request->plots;

            foreach (array_unique($plots) as $plot) {
                $plot = Plot::where('uuid', $plot)->first();

                $services = ServicePricing::where(
                    'house_type_id',
                    $plot->house_type_id
                )->get();

                foreach ($services as $service) {
                    $job = PlotJob::where('plot_id', $plot->id)
                        ->where('service_id', $service->service_id)
                        ->first();

                    if (!$job) {
                        $ser = Service::find($service->service_id);

                        PlotJob::create([
                            'uuid' => Str::uuid(),
                            'plot_id' => $plot->id,
                            'service_id' => $service->service_id,
                            'percent_complete' => 0.0,
                            'amount' => $service->price,
                            'status' => 'not-started',
                            'priority' => $ser->priority,
                        ]);
                    }
                }
            }

            $message = 'Jobs Generated Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
            ]);
        }
    }

    public function paginate(
        $perPage,
        $total = null,
        $page = null,
        $pageName = 'page'
    ) {
        $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

        return new LengthAwarePaginator(
            $this->forPage($page, $perPage),
            $total ?: $this->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => $pageName,
            ]
        );
    }

    public function jobsOnPlot(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $plot = Plot::where('uuid', $uuid)->first();

            $alljobs = PlotJob::with('service', 'plot', 'joiners')
                ->where('plot_id', $plot->id)
                ->get();

            $jobs = PlotJob::with(
                'service',
                'plot.buildingType.site.builder',
                'joiners'
            )
                ->where('plot_id', $plot->id)
                ->orderBy('priority', 'asc');

            $meta = $jobs->paginate(20);

            $jobs = $jobs->get();

            $min = collect($jobs->min('priority'))[0];

            $max = collect($jobs->max('priority'))[0];

            for ($i = $min; $i <= $max; $i++) {
                $count = $jobs
                    ->where('priority', $i)
                    ->where('status', '!=', 'completed')
                    ->count();

                $updated = 0;

                $jobs->map(function ($item) use ($i, &$updated) {
                    if ($item->priority == $i && $item->status != 'completed') {
                        $item->is_locked = 0;
                        $updated++;
                    }

                    return $item;
                });

                if ($count > 0) {
                    break;
                }
            }

            // $completed = $alljobs->where('status', 'completed')->count();

            // $partCompleted = $alljobs
            //     ->where('status', 'partial-complete')
            //     ->count();

            // $notStarted = $alljobs->where('status', 'not-started')->count();

            // $totalAmount = $alljobs->sum('amount');

            // $joinerPay = 0;

            // foreach ($alljobs as $job) {
            //     $buidlingType = HouseType::find($job->plot->building_type_id);

            //     $joinerPricing = JoinerPricing::where(
            //         'building_type_id',
            //         $buidlingType->id
            //     )
            //         ->where('service_id', $job->service_id)
            //         ->first();

            //     $joinerPay +=
            //         $joinerPricing != null ? $joinerPricing->price : 0;
            // }

            // $profit = $totalAmount - $joinerPay;

            return response()->json([
                'type' => 'success',
                'message' => '',
                'meta' => $meta,
                'alljobs' => $alljobs,
                'data' => $jobs,
                // 'completed' => $completed,
                // 'partCompleted' => $partCompleted,
                // 'notStarted' => $notStarted,
                // 'totalAmount' => $totalAmount,
                // 'joinerPay' => $joinerPay,
                // 'profit' => $profit,

                'plot' => $plot,
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
            ]);
        }
    }

    public function assignJobToJoiner(Request $request, $uuid)
    {
        try {
            $job = PlotJob::where('uuid', $uuid)->first();

            $job->joiners()->attach($request->joiner_id);

            // if ($job->assigned_user_id != null) {
            //     $message = 'Another Joiner Already Assigned to Job';

            //     return response()->json([
            //         'type' => 'error',
            //         'message' => $message,
            //         'data' => '',
            //     ]);
            // }

            // $job->update(['assigned_user_id' => $request->joiner_id]);

            $message = 'Joiner Successfully Assigned to Job';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
            ]);
        }
    }

    public function removeJobToJoiner(Request $request, $uuid)
    {
        try {
            $job = PlotJob::where('uuid', $uuid)->first();

            $job->joiners()->detach($request->joiner_id);

            $message = 'Joiner Successfully Removed from Job';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
            ]);
        }
    }

    public function adminJobs(Request $request)
    {
        try {
            $search = $request->search ?? '';

            $status = $request->status ?? '';

            $jobs = PlotJob::with(
                'plot',
                'plot.buildingType',
                'plot.buildingType.site',
                'service'
            );

            if ($status != null) {
                $jobs = $jobs->where('status', $status);
            }
            // ->where('building_type_id', $btId)
            // ->where(function ($query) use ($search) {
            //     $query->where('plot_name', 'LIKE', '%' . $search . '%');
            // })
            $jobs = $jobs->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['jobs' => $jobs],
            ]);
        } catch (\Exception $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function joinerJobs(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $joiner = HuttonUser::where('uuid', $uuid)->first();

            $jobs = PlotJob::with(
                'joiners',
                'plot',
                'plot.buildingType',
                'plot.buildingType.site',
                'service'
            )->whereHas('joiners', function ($query) use ($joiner) {
                $query->where('id', $joiner->id);
            });

            $jobs = $jobs->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['jobs' => $jobs],
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

    public function servicesByPlot(Request $request, $uuid)
    {
        try {
            $plot = Plot::where('uuid', $uuid)->first();

            $services = PlotJob::with('service')
                ->where('plot_id', $plot->id)
                ->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $services,
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

    public function getJob(Request $request, $uuid)
    {
        try {
            $job = PlotJob::with('joiners')
                ->where('uuid', $uuid)
                ->first();

            $roleId = Role::where('name', 'joiner')->first();

            $joiners = HuttonUser::where('role_id', $roleId->id)->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['job' => $job, 'joiners' => $joiners],
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

    public function jobsOnSite(Request $request, $slug)
    {
        try {
            $site = Site::with('buildingTypes.plots.job')
                ->where('slug', $slug)
                ->first();

            $jobs = PlotJob::with('service', 'plot.buildingType.site.builder')
                ->whereHas('plot.buildingType.site', function ($query) use (
                    $slug
                ) {
                    $query->where('slug', $slug);
                })
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'site' => $site,
                    'jobs' => $jobs,
                ],
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function jobsOnBuilder(Request $request, $slug)
    {
        try {
            $jobs = PlotJob::with('service', 'plot.buildingType.site.builder')
                ->whereHas('plot.buildingType.site.builder', function (
                    $query
                ) use ($slug) {
                    $query->where('slug', $slug);
                })
                ->paginate(10);

            $collection = collect(
                Site::with('builder', 'buildingTypes.plots.job')
                    ->whereHas('builder', function ($query) use ($slug) {
                        $query->where('slug', $slug);
                    })
                    //                            ->where('slug',$slug)
                    ->get()
            )->map(function ($item) {
                $site_name = $item->site_name;
                $completed = 0;
                $not_completed = 0;

                if ($item->buildingTypes != null) {
                    foreach ($item->buildingTypes as $buildinType) {
                        if ($buildinType->plots != null) {
                            //
                            foreach ($buildinType->plots as $plot) {
                                //                                                dump($plot->job->count());
                                $completed += $plot->job
                                    ->where('status', 'completed')
                                    ->count();
                                $not_completed += $plot->job
                                    ->where('status', '!=', 'completed')
                                    ->count();
                            }
                        } else {
                            $completed += 0;
                            $not_completed += 0;
                        }
                    }
                } else {
                    $completed += 0;
                    $not_completed += 0;
                }

                return [$site_name, $completed, $not_completed];
            });

            //            $completed = $collection->where('status','completed')->count();
            //            $not_completed = $collection->where('status','!=','completed')->count();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'collection' => $collection,
                    'jobs' => $jobs,
                ],
            ]);
        } catch (\Exception $e) {
            $message = $e->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function show(Request $request, $uuid)
    {
        try {
            $job = PlotJob::with('plot.buildingType.site', 'service')
                ->where('uuid', $uuid)
                ->first();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['job' => $job],
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
