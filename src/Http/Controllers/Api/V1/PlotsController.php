<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DataTables;
use DB;
use Str;
use Exception;
use Illuminate\Validation\Rule;

use Sty\Hutton\Models\Plot;

class PlotsController extends Controller
{
    public function index(Request $request)
    {
        try {
            $plots = Plot::all();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['plots' => $plots],
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
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'building_type_id' => ['required'],
                'plot_name' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'type' => 'error',
                    'message' => $errors,
                    'data' => '',
                ]);
            }

            $data = [
                'building_type_id' => $request->building_type_id,
                'plot_name' => $request->plot_name,
            ];

            $message = 'Plot Created Successfully';

            $plot = Plot::create($data);

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => $plot,
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

    public function BuildingTypePlots(Request $request, $btId)
    {
        try {
            $plots = Plot::where('building_type_id', $btId)->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['plots' => $plots],
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
