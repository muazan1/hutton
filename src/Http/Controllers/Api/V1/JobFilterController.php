<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Sty\Hutton\Models\BuildingType;

use Sty\Hutton\Models\HsJob;

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
            $jobs = HsJob::where('status', 'completed')->paginate();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $jobs,
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

            $jobs = HsJob::with('plot.buildingType.site.builder', 'service');

            if ($request->builder != null) {
                $jobs = $jobs->whereHas('plot.buildingType.site.builder', function (
                    $query
                ) use ($request) {
                    $query->where('slug', $request->builder);
                });
            }


            if ($request->site != null) {
                $jobs = $jobs->whereHas('plot.buildingType.site', function (
                    $query
                ) use ($request) {
                    $query->where('slug', $request->site);
                });
            }


            if ($request->buidling_type != null) {
                $jobs = $jobs->whereHas('plot.buildingType', function (
                    $query
                ) use ($request) {
                    $query->where('id', $request->building_type);
                });
            }


            if ($request->plot != null) {
                $jobs = $jobs->where('plot_id', $request->plot);
            }

            if ($request->service != null) {
                $jobs = $jobs->where('service_id', $request->service);
            }

            if ($request->status != null) {
                $jobs = $jobs->where('status', $request->status);
            }

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

    public function joinerJobFilter(Request $request)
    {
        try {

            $jobs = HsJob::with('plot.buildingType.site', 'service');

            if ($request->site != 'null' && $request->site != null) {
                $jobs = $jobs->whereHas('plot.buildingType.site', function (
                    $query
                ) use ($request) {
                    $query->where('slug', $request->get('site'));
                });
            }

            if ($request->building_type != 'null' && $request->building_type != null) {

                $jobs = $jobs->whereHas('plot.buildingType', function (
                    $query
                ) use ($request) {
                    $query->where('id', $request->get('building_type'));
                });
            }

            if ($request->plot != 'null' && $request->plot != null) {

                $jobs = $jobs->where('plot_id',$request->get('plot'));

            }

            if ($request->service != 'null' && $request->service != null) {
                $jobs = $jobs->where('service_id', $request->get('service'));
            }

            if ($request->status != 'null' && $request->status != null) {

                $jobs = $jobs->where('status', $request->get('status'));
            }

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
}
