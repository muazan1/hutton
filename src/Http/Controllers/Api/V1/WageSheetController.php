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

use Carbon\Carbon;

class WageSheetController extends Controller
{
    public function wageSheet(Request $request)
    {
        try {
            $role = Role::where('name', 'joiner')->first();

            $joiners = HuttonUser::with('weeklyWork.dailyWork','weeklyWork.miscWork')
//                ->whereHas('weeklyWork' , function ($query) {
//                    $query->where('status','in-progress');
//                })
                ->where('role_id', $role->id)
                ->get();

            $meta = User::where('role_id', $role->id)->paginate(10);

            $joiners = collect($joiners)->map(function ($item) {

                $item->dailyTotal = 0;

                $item->weeklyTotal = 0;

                $item->first = ($item->weeklyWork->where('status','in-progress')->first());



                if($item->first->dailyWork->count() > 0){

                    $item->dailyTotal += $item->first->dailyWork
                                            ->where('created_at','>=',Carbon::now()->format('Y-m-d'))
                                            ->sum('amount');
                }

                if($item->first->miscWork->count() > 0){

                    $item->dailyTotal += $item->first->miscWork
                                            ->where('created_at',Carbon::now())
                                            ->sum('amount');
                }


                if($item->first->dailyWork->count() > 0){

                    $item->weeklyTotal += $item->first->dailyWork->sum('amount');
                }

                if($item->first->miscWork->count() > 0){

                    $item->weeklyTotal += $item->first->miscWork->sum('amount');
                }

//                if($item->weeklyWork->count() > 0) {
//
//                    foreach ($item->weeklyWork as $value) {
//
//                        if($value->dailyWork->count() > 0)
//                        {
//                            $item->weeklyTotal += $value->dailyWork->sum('amount');
//                        }
//
//                        if($value->miscWork->count() > 0)
//                        {
//                            $item->weeklyTotal += $value->miscWork->sum('amount');
//                        }
//
//                    }
//                }


                return ($item);
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
