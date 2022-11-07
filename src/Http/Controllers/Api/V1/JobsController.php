<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Sty\Hutton\Models\{
    JoinerPricing,
    BuildingType,
    HsJob,
    DailyWork,
    WeeklyWork
};

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Container\Container;

use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Pagination\Paginator;

use App\Models\User;

class JobsController extends Controller
{
    public function CompleteJob(Request $request, $joiner, $job)
    {
        try {
            $joiner = User::where('uuid', $joiner)->first();

            $week = WeeklyWork::where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

            if ($week != null) {
                $plotJob = HsJob::find($job);

                if ($plotJob->status == 'completed') {
                    $message = 'Job has Already Completed';

                    return response()->json([
                        'type' => 'error',
                        'message' => $message,
                        'data' => '',
                    ]);
                }

                $jp = JoinerPricing::where('service_id', $plotJob->service_id)
                    ->where(
                        'builder_id',
                        $plotJob->plot->buildingType->site->customer_id
                    )
                    ->first();

                if ($plotJob->status == 'completed') {
                    $message = 'Job has Already Completed';

                    return response()->json([
                        'type' => 'error',
                        'message' => $message,
                        'data' => '',
                    ]);
                }

                $data = [
                    'week_id' => $week->id,
                    'plot_job_id' => $plotJob->id,
                    'site_id' => $plotJob->plot->buildingType->site_id,
                    'plot_id' => $plotJob->plot_id,
                    'service_id' => $plotJob->service_id,
                    'day' => null,
                    'work_carried' => null,
                    'time_taken' => null,
                    'amount' => $jp->price,
                ];

                $message = 'Daily Work Added Successfully';

                $week = DailyWork::create($data);

                $plotJob->update([
                    'status' => 'completed',
                    'completed_by' => $week->user_id,
                ]);

                return response()->json([
                    'type' => 'success',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $message = 'Week is not Started';

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
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

    public function PartCompleteJob(Request $request, $joiner, $job)
    {
        try {
            $joiner = User::where('uuid', $joiner)->first();

            $week = WeeklyWork::where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

            if ($week != null) {
                $plotJob = HsJob::find($job);

                if ($plotJob->status == 'completed') {
                    $message = 'Job has Already Completed';

                    return response()->json([
                        'type' => 'error',
                        'message' => $message,
                        'data' => '',
                    ]);
                }

                if ($plotJob->status == 'completed') {
                    $message = 'Job has Already Completed';

                    return response()->json([
                        'type' => 'error',
                        'message' => $message,
                        'data' => '',
                    ]);
                }

                $jp = JoinerPricing::where('service_id', $plotJob->service_id)
                    ->where(
                        'builder_id',
                        $plotJob->plot->buildingType->site->customer_id
                    )
                    ->first();

                $data = [
                    'week_id' => $week->id,
                    'plot_job_id' => $plotJob->id,
                    'site_id' => $plotJob->plot->buildingType->site_id,
                    'plot_id' => $plotJob->plot_id,
                    'service_id' => $plotJob->service_id,
                    'day' => null,
                    'work_carried' => null,
                    'time_taken' => null,
                    'amount' => '0.00',
                ];

                $message = 'Daily Work Added Successfully';

                $week = DailyWork::create($data);

                $plotJob->update([
                    'status' => 'partial-complete',
                    'completed_by' => $week->user_id,
                ]);

                return response()->json([
                    'type' => 'success',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $message = 'Week is not Started';

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
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
