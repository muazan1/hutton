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

use App\Models\{User, Role};

use Sty\Hutton\Models\{HsJobs, HuttonUser, Plot, Site, WeeklyWork, DailyWork};

class WageSheetController extends Controller
{
    public function wageSheet(Request $request)
    {
        try {
            $role = Role::where('name', 'joiner')->first();

            $joiners = HuttonUser::with('weeklyWork')
                ->where('role_id', $role->id)
                ->get();

            $meta = User::where('role_id', $role->id)->paginate(10);

            $collection = collect($joiners)->map(function ($item) {
                dd($item);
            });

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['joiner' => $joiners, 'meta' => $meta],
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

    public function wageSheetByWeek(Request $request)
    {
        try {
            $weekCommencing = $request->week;

            $role = Role::where('name', 'joiner')->first();

            $joiners = HuttonUser::with([
                'weeklyWork' => function ($query) use ($weekCommencing) {
                    return $query->whereDate('week_start', $weekCommencing);
                },
                'weeklyWork.dailyWork',
            ])
                ->where('role_id', $role->id)
                ->paginate();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['joiners' => $joiners],
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
