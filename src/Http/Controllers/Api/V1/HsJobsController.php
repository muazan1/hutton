<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\{Hash, Mail, Validator};

use DataTables;
use DB;
use Str;
use Exception;
use Illuminate\Validation\Rule;
use Mockery\Container;

use Sty\Hutton\Http\Requests\CreateSiteRequest;

use Sty\Hutton\Models\{HsJob, Plot, Site, Customer, ServicePricing};

class HsJobsController extends Controller
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

            foreach ($plots as $plot) {
                $plot = Plot::find($plot);

                $services = ServicePricing::where(
                    'building_type_id',
                    $plot->building_type_id
                )->get();

                foreach ($services as $service) {
                    $job = HsJob::where('plot_id', $plot->id)
                        ->where('service_id', $service->service_id)
                        ->first();
                    if (!$job) {
                        HsJob::create([
                            'plot_id' => $plot->id,
                            'service_id' => $service->service_id,
                            'percent_complete' => 0.0,
                            'amount' => $service->price,
                            'status' => 'not-started',
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

    public function jobsOnPlot(Request $request, $plotId)
    {
        try {
            $search = $request->search ?? '';

            $jobs = HsJob::with('service', 'plot')
                ->where('plot_id', $plotId)
                // ->where(function ($query) use ($search) {
                //     $query->where('plot_name', 'LIKE', '%' . $search . '%');
                // })
                ->paginate(10);

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
            ]);
        }
    }

    public function assignJobToJoiner(Request $request, $jobId)
    {
        try {
            $job = HsJob::find($jobId);

            // if ($job->assigned_user_id != null) {
            //     $message = 'Another Joiner Already Assigned to Job';

            //     return response()->json([
            //         'type' => 'error',
            //         'message' => $message,
            //         'data' => '',
            //     ]);
            // }

            $job->update(['assigned_user_id' => $request->joiner_id]);

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

    // public function JobsOnPlot(Request $request, $plotId)
    // {
    //     dd($plotId);

    //     try {
    //         $search = $request->search ?? '';
    //         $plots = Plot::with('job')
    //             ->where('building_type_id', $btId)
    //             ->where(function ($query) use ($search) {
    //                 $query->where('plot_name', 'LIKE', '%' . $search . '%');
    //             })
    //             ->paginate(10);

    //         return response()->json([
    //             'type' => 'success',
    //             'message' => '',
    //             'data' => ['plots' => $plots],
    //         ]);
    //     } catch (\Exception $e) {
    //         $message = $th->getMessage();

    //         return response()->json([
    //             'type' => 'error',
    //             'message' => $message,
    //             'data' => '',
    //         ]);
    //     }
    // }
}
