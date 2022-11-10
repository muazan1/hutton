<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Validator, Mail};
use DataTables;

use DB;

use Str;

use Exception;

use Illuminate\Validation\Rule;

use Sty\Hutton\Models\{Plot, BuildingType};

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

            $building_type = BuildingType::where(
                'uuid',
                $request->building_type_id
            )->first();

            foreach ($request->plots as $plot) {
                if ($plot) {
                    $plots[] = Plot::create([
                        'uuid' => Str::uuid(),
                        'building_type_id' => $building_type->id,
                        'plot_name' => $plot,
                    ]);
                }
            }

            $message = 'Plot Created Successfully';

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

    public function BuildingTypePlots(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $building_type = BuildingType::where('uuid', $uuid)->first();

            $plots = Plot::with('job')
                ->where('building_type_id', $building_type->id)
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

    public function edit(Request $request, $uuid)
    {
        try {
            $plot = Plot::where('uuid', $uuid)->first();

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

    public function update(Request $request, $uuid)
    {
        try {
            $plot = Plot::where('uuid', $uuid)->first();

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

    public function destroy(Request $request, $uuid)
    {
        try {
            $plot = Plot::where('uuid', $uuid)->first();

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
