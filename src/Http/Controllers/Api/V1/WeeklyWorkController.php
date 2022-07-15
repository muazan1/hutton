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

use Sty\Hutton\Models\{Task, Plot, Site, Customer, ServicePricing, WeeklyWork};

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
            $week = WeeklyWork::findOrFail($weekId)->update([
                'status' => 'completed',
            ]);

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

    public function joinerWeeklyWork(Request $request, $joinerId, $weekId)
    {
        try {
            $weeklyWork = WeeklyWork::with('dailyWork')->findOrFail($weekId);

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
