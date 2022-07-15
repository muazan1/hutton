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

use Sty\Hutton\Models\{Task, Plot, Site, WeeklyWork, DailyWork};

class DailyWorkController extends Controller
{
    public function dailyWork(Request $request)
    {
        try {
            $week = WeeklyWork::find($request->week_id);

            if ($week->status === 'completed') {
                $message = 'Week is Closed';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $validator = Validator::make($request->all(), [
                'week_id' => ['required'],
                'site_id' => ['required'],
                'plot_id' => ['required'],
                'day' => ['required'],
                'work_carried' => ['required'],
                'time_taken' => ['required'],
                'amount' => ['required'],
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
                'week_id' => $request->week_id,
                'site_id' => $request->site_id,
                'plot_id' => $request->plot_id,
                'day' => $request->day,
                'work_carried' => $request->work_carried,
                'time_taken' => $request->time_taken,
                'amount' => $request->amount,
            ];

            $message = 'Daily Work Added Successfully';

            $week = DailyWork::create($data);

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

    public function deleteDailyWork(Request $request, $workId)
    {
        try {
            $dailyWork = DailyWork::find($workId);

            $dailyWork->delete();

            $message = 'Work Removed Successfully';

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
}
