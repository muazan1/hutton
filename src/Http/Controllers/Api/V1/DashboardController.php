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

class DashboardController extends  Controller
{
    public function joinerRecentWork(Request $request,$uuid) {

        try {
            $joiner = HuttonUser::where('uuid',$uuid)->first();

            $joinerId = $joiner->id;

            $work = DailyWork::whereHas('weeklyWork', function ($query) use($joinerId) {
                $query->where('user_id',$joinerId);
            })->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['work' => $work],
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
