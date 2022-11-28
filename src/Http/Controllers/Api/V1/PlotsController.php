<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Validator};

use DB;

use Str;

use Sty\Hutton\Models\{Plot, HouseType};

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
                'house_type' => ['required'],
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

            $house_type = HouseType::where(
                'uuid',
                $request->house_type
            )->first();

            foreach ($request->plots as $plot) {
                if ($plot) {
                    $plots[] = Plot::create([
                        'uuid' => Str::uuid(),
                        'house_type_id' => $house_type->id,
                        'plot_name' => $plot,
                    ]);
                }
            }

            $message = 'Plot Created Successfully';

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

    public function HouseTypePlots(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $house_type = HouseType::where('uuid', $uuid)->first();

            $plots = Plot::with('job')
                ->where('house_type_id', $house_type->id)
                ->where(function ($query) use ($search) {
                    $query->where('plot_name', 'LIKE', '%' . $search . '%');
                });

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $plots->orderBy($key, $direction);
                }
            }

            // dd($plots->get());

            $meta = $plots->paginate(40);

            $plots = $plots->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $plots,
                'meta' => $meta,
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
