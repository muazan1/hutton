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

use Sty\Hutton\Models\{HsJob, MiscWork, Plot, Site, WeeklyWork, DailyWork};

use Whoops\Util\Misc;

class DailyWorkController extends Controller
{
    public function dailyWork(Request $request)
    {
        try {
            $week = WeeklyWork::find('uuid', $request->week_id)->first();

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
                'service_id' => ['required'],
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

            $plotJob = HsJob::where('plot_id', $request->plot_id)
                ->where('service_id', $request->service_id)
                ->first();

            if ($plotJob->status == 'completed') {
                $message = 'Job has Already Completed';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $site = Site::where('slug', $request->site_id)->first();

            $data = [
                'uuid' => Str::uuid(),
                'week_id' => $request->week_id,
                'plot_job_id' => $plotJob->id,
                'site_id' => $site->id,
                'plot_id' => $request->plot_id,
                'service_id' => $request->service_id,
                'day' => $request->day,
                'work_carried' => $request->work_carried,
                'time_taken' => $request->time_taken,
                'amount' => $request->amount,
            ];

            $message = 'Daily Work Added Successfully';

            $week = DailyWork::create($data);

            $weekly_work = WeeklyWork::where(
                'uuid',
                $request->week_id
            )->first();

            $plotJob->update([
                'status' => $request->status,
                'completed_by' => $weekly_work->user_id,
            ]);

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

    public function dailyMiscWork(Request $request)
    {
        try {
            $week = WeeklyWork::where('uuid', $request->week_id)->first();

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
                'title' => ['required'],
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
                'uuid' => Str::uuid(),
                'week_id' => $request->week_id,
                'site_id' => $request->site_id,
                'title' => $request->title,
                'work_carried' => $request->work_carried,
                'time_taken' => $request->time_taken,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ];

            $message = 'Daily Work Added Successfully';

            $week = MiscWork::create($data);

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

    public function deleteDailyWork(Request $request, $uuid)
    {
        try {
            $dailyWork = DailyWork::where('uuid', $uuid)->first();

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

    public function deleteDailyMiscWork(Request $request, $uuid)
    {
        try {
            $dailyWork = MiscWork::where('uuid', $uuid)->first();

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
