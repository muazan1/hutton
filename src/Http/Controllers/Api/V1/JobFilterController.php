<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use phpDocumentor\Reflection\Types\Null_;

use Sty\Hutton\Models\BuildingType;

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

    public function adminJobFilter (Request $request) {

        try {
            if($request->site != null)
            {
                $site = Site::find($request->site);
            }

            if($request->buidling_type != null)
            {
                $building_type = BuildingType::find($request->building_type);
            }

            $jobs = HsJob::get();

            if($request->plot != null )
            {
                $jobs = $jobs->where('plot_id',$request->plot);
            }

            if($request->service != null)
            {
                $jobs = $jobs->where('service_id',$request->service);
            }

            $jobs = $jobs->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $jobs,
            ]);

        }catch (\Throwable $th)
        {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'error',
                'message' => $message,
                'data' => '',
            ]);
        }


    }

}
