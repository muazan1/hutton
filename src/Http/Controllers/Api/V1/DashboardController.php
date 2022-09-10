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


            $works = DailyWork::with('weeklyWork','site','plot')->
                whereHas('weeklyWork', function ($query) use($joinerId) {
                    $query->where('user_id',$joinerId);
                })->get();

            $allWork = DailyWork::with('weeklyWork','site','plot')->
                whereHas('weeklyWork', function ($query) use($joinerId) {
                    $query->where('user_id',$joinerId);
                })->get();

            $months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];

            $amounts = [];
//
            foreach ($months as $month)
            {

                $amt = $allWork = DailyWork::with('weeklyWork','site','plot')->
                        whereHas('weeklyWork', function ($query) use($joinerId) {
                            $query->where('user_id',$joinerId);
                        })->whereMonth('created_at',$month)->sum('amount');

                $amounts[] = $amt;
            }

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['work' => $work,'allWork' => $allWork,'months'=> $months,'amounts' => $amounts ],
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
