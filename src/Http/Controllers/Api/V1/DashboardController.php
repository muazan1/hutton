<?php
namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Exception;

use Illuminate\Validation\Rule;

use Mockery\Container;

use Sty\Hutton\Http\Requests\CreateSiteRequest;

use Sty\Hutton\Models\{MiscWork, Plot, Site, WeeklyWork,HuttonUser, DailyWork};

use Carbon\Carbon;

class DashboardController extends  Controller
{
    public function joinerRecentWork(Request $request,$uuid) {

        try {
            $joiner = HuttonUser::where('uuid',$uuid)->first();

            $joinerId = $joiner->id;

            $work = DailyWork::with('weeklyWork','site','plot')->
                    whereHas('weeklyWork', function ($query) use($joinerId) {
                        $query->where('user_id',$joinerId);
                    })->paginate(10);

            $amounts = [];

            $works = DailyWork::with('weeklyWork','site','plot')->
                whereHas('weeklyWork', function ($query) use($joinerId) {
                    $query->where('user_id',$joinerId);
                })->get();

            $allWork = collect($works)->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->format('M');
            })->map(function ($item) {
                return $item->total_amount = ($item->sum('amount'));
            });
//
//            return response()->json(['work' => $allWork]);
//            dd($allWork);
//            foreach ($allWork as $item => $key)
//            {
//                dd($item);
//            }


            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['work' => $work,'allWork' => $allWork ],
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
