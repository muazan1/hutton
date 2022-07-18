<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Sty\Hutton\Models\WeeklyWork;

class WorkController extends Controller
{
    public function JoinerWorkHistory(Request $request, $joinerId)
    {
        try {
            $weeklyWorks = WeeklyWork::where('user_id', $joinerId)->get();

            return response()->json([
                'type' => 'error',
                'message' => '',
                'data' => ['weeklyWorks' => $weeklyWorks],
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
