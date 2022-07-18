<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Sty\Hutton\Models\HsJob;

class JobFilterController extends Controller
{
    public function completedJobs(Request $request)
    {
        try {

            $jobs = HsJob::where('status', 'completed')->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $jobs,
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
