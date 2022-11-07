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
            $plots = Plot::paginate(40);

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
                'plots' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'type' => 'error',
                    'message' => $errors,
                    'data' => '',
                ]);
            }

            $plots = [];
            foreach($request->plots as $plot) {
                if ($plot) {
                    $plots[] = Plot::create([
                        'building_type_id' => $request->building_type_id,
                        'plot_name' => $plot,
                    ]);
                }
            }

            // $data = [
            //     'building_type_id' => $request->building_type_id,
            //     'plot_name' => $request->plot_name,
            // ];

            $message = 'Plot Created Successfully';

            // $plot = Plot::create($data);

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => $plots,
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
            $search = $request->search ?? '';
            $plots = Plot::with('job')
                ->where('building_type_id', $btId)
                ->where(function ($query) use ($search) {
                    $query->where('plot_name', 'LIKE', '%' . $search . '%');
                })
                ->paginate(40);

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

    public function edit(Request $request, $plotId)
    {
        try {
            $plot = Plot::findOrFail($plotId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['plot' => $plot],
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

    public function update(Request $request, $plotId)
    {
        try {
            $plot = Plot::findOrFail($plotId);

            $plot->update(['plot_name' => $request->plot_name]);

            $message = 'Plot Updated Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
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



    public function destroy(Request $request, $plotId)
    {
        try {
            $plot = Plot::find($plotId);

            $plot->delete();

            $message = 'Plot Deleted Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
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
