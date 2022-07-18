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

// use App\Models\User;

use Sty\Hutton\Models\{HsJobs, User, Plot, Site, WeeklyWork, DailyWork};

class WageSheetController extends Controller
{
    public function wageSheet(Request $request)
    {
        try {
            $joiners = User::where('role_id', 2)->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $joiners,
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
