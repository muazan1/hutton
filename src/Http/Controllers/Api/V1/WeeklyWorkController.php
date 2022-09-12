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

use Carbon\Carbon;

use Sty\Hutton\Http\Requests\CreateSiteRequest;

use Sty\Hutton\Mail\Work\WorkSend;

use Sty\Hutton\Models\{
    HsJobs,
    MiscWork,
    Plot,
    Site,
    Customer,
    ServicePricing,
    DailyWork,
    WeeklyWork
};

use Sty\Hutton\Http\Service\GeneratePDF;

class WeeklyWorkController extends Controller
{
    public function StartWeek(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required'],
                'week_start' => ['required', 'date'],
                'week_end' => ['required', 'date'],
                'status' => ['required'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'type' => 'error',
                    'message' => $errors,
                    'data' => '',
                ]);
            }

            $data = [
                'user_id' => $request->user_id,
                'week_start' => $request->week_start,
                'week_end' => $request->week_end,
                'status' => $request->status,
            ];

            $message = 'Week Created Successfully';

            $week = WeeklyWork::create($data);

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => $week,
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

    public function EndWeek(Request $request, $weekId)
    {
        try {
            $data = [];

            $filename = 'views.pdfs.joiner_weekly_report';

            $reportname = 'Joiner Weekly Work.pdf';

            $week = WeeklyWork::findOrFail($weekId);

            $pdf = GeneratePDF::generateReport($week, $filename, $reportname);

            $work = $week->update([
                'status' => 'completed',
            ]);

            $mail = Mail::to('admin@admin.com')->send(
                new WorkSend($week, $pdf)
            );

            $message = 'Week Ended Successfully';

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
                'data' => '',
            ]);
        }
    }

    public function joinerWeeklyWork(Request $request, $weekId)
    {
        try {
            $weeklyWork = WeeklyWork::with(
                'dailyWork',
                'dailyWork.site',
                'dailyWork.plot',
                'miscWork'
            )->findOrFail($weekId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $weeklyWork,
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

    public function currentWeek(Request $request, $joinerId)
    {
        try {
            $weeklyWork = WeeklyWork::with('dailyWork')
                ->where('user_id', $joinerId)
                ->where('status', 'in-progress')
                ->first();

            $dailyWork = DailyWork::with('site', 'plot')
                ->where('week_id', $weeklyWork->id)
                ->paginate(10);

            $dailyMiscWork = MiscWork::where('week_id', $weeklyWork->id)
                ->whereDate('created_at', Carbon::now())
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'weeklyWork' => $weeklyWork,
                    'dailyWork' => $dailyWork,
                    'dailyMiscWork' => $dailyMiscWork,
                ],
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => 'Sorry! there no week Active',
                'data' => '',
            ]);
        }
    }

    public function currentDay(Request $request, $joinerId)
    {
        try {
            $weeklyWork = WeeklyWork::with('dailyWork')
                ->where('user_id', $joinerId)
                ->where('status', 'in-progress')
                ->first();

            $dailyWork = DailyWork::with('site', 'plot')
                ->where('week_id', $weeklyWork->id)
                ->whereDate('created_at', Carbon::now())
                ->paginate(10);

            $dailyMiscWork = MiscWork::where('week_id', $weeklyWork->id)
                ->whereDate('created_at', Carbon::now())
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'weeklyWork' => $weeklyWork,
                    'dailyWork' => $dailyWork,
                    'dailyMiscWork' => $dailyMiscWork,
                ],
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => 'Sorry! there no week Active',
                'data' => '',
            ]);
        }
    }
}
