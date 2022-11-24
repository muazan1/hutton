<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Sty\Hutton\Models\{HouseType, PlotJob, Plot, Service};

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Container\Container;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Pagination\Paginator;

class JobFilterController extends Controller
{
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);

        $items =
            $items instanceof Collection ? $items : Collection::make($items);

        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    public function completedJobs(Request $request)
    {
        try {
            $jobs = PlotJob::where('status', 'completed');

            $meta = $jobs->paginate(20);

            $data = $jobs->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $data,
                'meta' => $meta,
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

    public function adminJobFilter(Request $request)
    {
        try {
            $jobs = PlotJob::with('plot.buildingType.site.builder', 'service');

            if ($request->builder != null) {
                $jobs = $jobs->whereHas(
                    'plot.buildingType.site.builder',
                    function ($query) use ($request) {
                        $query->where('uuid', $request->builder);
                    }
                );
            }

            if ($request->site != null) {
                $jobs = $jobs->whereHas('plot.buildingType.site', function (
                    $query
                ) use ($request) {
                    $query->where('uuid', $request->site);
                });
            }

            if ($request->house_type != null) {
                $jobs = $jobs->whereHas('plot.buildingType', function (
                    $query
                ) use ($request) {
                    $query->where('uuid', $request->house_type);
                });
            }

            if ($request->plot != null) {
                $plot = Plot::where('uuid', $request->plot)->first();

                $jobs = $jobs->where('plot_id', $plot->id);
            }

            if ($request->service != null) {
                $service = Service::where('uuid', $request->service)->first();

                $jobs = $jobs->where('service_id', $service->id);
            }

            if ($request->status != null) {
                $jobs = $jobs->where('status', $request->status);
            }

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

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $jobs,
                'meta' => $meta,
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

    // public function joinerJobFilter(Request $request)
    // {
    //     try {
    //         $jobs = PlotJob::with('plot.buildingType.site', 'service');

    //         if ($request->builder != null) {
    //             $jobs = $jobs->whereHas(
    //                 'plot.buildingType.site.builder',
    //                 function ($query) use ($request) {
    //                     $query->where('slug', $request->builder);
    //                 }
    //             );
    //         }

    //         if ($request->site != 'null' && $request->site != null) {
    //             $jobs = $jobs->whereHas('plot.buildingType.site', function (
    //                 $query
    //             ) use ($request) {
    //                 $query->where('slug', $request->get('site'));
    //             });
    //         }

    //         if (
    //             $request->house_type != 'null' &&
    //             $request->house_type != null
    //         ) {
    //             $jobs = $jobs->whereHas('plot.buildingType', function (
    //                 $query
    //             ) use ($request) {
    //                 $query->where('id', $request->get('house_type'));
    //             });
    //         }

    //         if ($request->plot != 'null' && $request->plot != null) {
    //             $jobs = $jobs->where('plot_id', $request->get('plot'));
    //         }

    //         if ($request->service != 'null' && $request->service != null) {
    //             $jobs = $jobs->where('service_id', $request->get('service'));
    //         }

    //         if ($request->status != 'null' && $request->status != null) {
    //             $jobs = $jobs->where('status', $request->get('status'));
    //         }

    //         $jobs = $jobs->paginate(10);

    //         $min = collect($jobs->min('priority'))[0];

    //         $max = collect($jobs->max('priority'))[0];

    //         for ($i = $min; $i <= $max; $i++) {
    //             $count = $jobs
    //                 ->where('priority', $i)
    //                 ->where('status', '!=', 'completed')
    //                 ->count();

    //             $updated = 0;

    //             $jobs->map(function ($item) use ($i, &$updated) {
    //                 if ($item->priority == $i && $item->status != 'completed') {
    //                     $item->is_locked = 0;
    //                     $updated++;
    //                 }

    //                 return $item;
    //             });

    //             if ($count > 0) {
    //                 break;
    //             }
    //         }

    //         return response()->json([
    //             'type' => 'success',
    //             'message' => '',
    //             'data' => ['jobs' => $jobs],
    //         ]);
    //     } catch (\Throwable $th) {
    //         $message = $th->getMessage();

    //         return response()->json([
    //             'type' => 'error',
    //             'message' => $message,
    //             'data' => '',
    //         ]);
    //     }
    // }
}
