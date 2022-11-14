<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\WeeklyWork;

use App\Models\User;

class WorkController extends Controller
{
    public function JoinerWorkHistory(Request $request, $uuid)
    {
        try {
            $joiner = User::where('uuid', $uuid)->first();

            $weeklyWorks = WeeklyWork::where('user_id', $joiner->id)->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['weeklyWorks' => $weeklyWorks, 'joiner' => $joiner],
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
