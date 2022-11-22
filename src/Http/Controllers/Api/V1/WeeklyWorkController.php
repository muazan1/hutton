<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\{Mail, Validator};

use Carbon\Carbon;

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

use App\Models\User;

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

    public function EndWeek(Request $request, $uuid)
    {
        try {
            $data = [];

            $filename = 'views.pdfs.joiner_weekly_report';

            $reportname = 'Joiner Weekly Work.pdf';

            $week = WeeklyWork::with('dailyWork')
                ->where('uuid', $uuid)
                ->first();

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

    public function joinerWeeklyWork(Request $request, $uuid)
    {
        try {
            $weeklyWork = WeeklyWork::with(
                'dailyWork',
                'dailyWork.site',
                'dailyWork.plot',
                'miscWork'
            )
                ->where('uuid', $uuid)
                ->first();

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

    public function currentWeek(Request $request, $uuid)
    {
        try {
            $joiner = User::where('uuid', $uuid)->first();

            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $weeklyWork = WeeklyWork::with('dailyWork')
                ->where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

            if (request()->get('type') == 'misc_work') {
                $data = MiscWork::with('site')->where(
                    'week_id',
                    $weeklyWork->id
                );
            } else {
                $data = DailyWork::with('site', 'plot', 'service')->where(
                    'week_id',
                    $weeklyWork->id
                );
            }

            $meta = $data->paginate(10);

            $data = $data->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'weeklyWork' => $weeklyWork,
                'data' => $data,
                'meta' => $meta,
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

    public function currentDay(Request $request, $uuid)
    {
        try {
            $joiner = User::where('uuid', $uuid)->first();

            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $weeklyWork = WeeklyWork::with('dailyWork')
                ->where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

            if (request()->get('type') == 'misc_work') {
                $data = MiscWork::with('site')
                    ->where('week_id', $weeklyWork->id)
                    ->whereDate('created_at', Carbon::now());
            } else {
                $data = DailyWork::with('site', 'plot', 'service')
                    ->where('week_id', $weeklyWork->id)
                    ->whereDate('created_at', Carbon::now());
            }

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $data->orderBy($key, $direction);
                }
            }

            $meta = $data->paginate(10);

            $data = $data->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'weeklyWork' => $weeklyWork,
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

    public function joinerWeek(Request $request, $uuid)
    {
        try {
            $joiner = User::where('uuid', $uuid)->first();

            $weeklyWork = WeeklyWork::where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

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
}
