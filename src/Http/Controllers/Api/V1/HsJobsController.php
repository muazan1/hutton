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

use Sty\Hutton\Models\{
    HsJob,
    Plot,
    Site,
    BuildingType,
    JoinerPricing,
    ServicePricing
};

use App\Models\{User, Role};

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
            // dd('Muazan');
            $search = $request->search ?? '';

            $alljobs = HsJob::with('service', 'plot')
                ->where('plot_id', $plotId)
                // ->where(function ($query) use ($search) {
                //     $query->where('plot_name', 'LIKE', '%' . $search . '%');
                // })
                ->get();
            $jobs = HsJob::with('service', 'plot')
                ->where('plot_id', $plotId)
                // ->where(function ($query) use ($search) {
                //     $query->where('plot_name', 'LIKE', '%' . $search . '%');
                // })
                ->paginate(10);

            $completed = $alljobs->where('status', 'completed')->count();

            $partCompleted = $alljobs
                ->where('status', 'partial-complete')
                ->count();

            $notStarted = $alljobs->where('status', 'not-started')->count();

            $totalAmount = $alljobs->sum('amount');

            $joinerPay = 0;

            foreach ($alljobs as $job) {
                $buidlingType = BuildingType::find(
                    $job->plot->building_type_id
                );

                $joinerPricing = JoinerPricing::where(
                    'builder_id',
                    $buidlingType->site->customer_id
                )
                    ->where('service_id', $job->service_id)
                    ->first();

                $joinerPay += $joinerPricing->price;
            }

            $profit = $totalAmount - $joinerPay;

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'jobs' => $jobs,
                    'alljobs' => $alljobs,
                    'completed' => $completed,
                    'partCompleted' => $partCompleted,
                    'notStarted' => $notStarted,
                    'totalAmount' => $totalAmount,
                    'joinerPay' => $joinerPay,
                    'profit' => $profit,
                ],
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

            $job->joiners()->attach($request->joiner_id);

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

    public function adminJobs(Request $request)
    {
        try {
            $search = $request->search ?? '';
            $status = $request->status ?? '';
            $jobs = HsJob::with(
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
        } catch (\Exception $e) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function servicesByPlot(Request $request, $plotId)
    {
        try {
            $services = HsJob::with('service')
                ->where('plot_id', $plotId)
                ->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['services' => $services],
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

    public function getJob(Request $request, $jobId)
    {
        try {
            $job = HsJob::with('joiners')->find($jobId);

            $roleId = Role::where('name', 'joiner')->first();

            $joiners = User::where('role_id', $roleId->id)->paginate(10);

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
}
