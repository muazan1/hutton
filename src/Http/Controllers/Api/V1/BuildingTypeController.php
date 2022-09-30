<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Sty\Hutton\Models\BuildingType;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Validator;

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Collection;

use Exception;

use Sty\Hutton\Models\Site;

use Str;

class BuildingTypeController extends Controller
{
    public function SiteBuildingTypes(Request $request, $slug)
    {
        try {
            $search = $request->search ?? '';

            $site = Site::where('slug',$slug)->first();

            $buildingTypes = BuildingType::where('site_id', $site->id)
                ->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'building_type_name',
                            'LIKE',
                            '%' . $search . '%'
                        )
                        ->orWhere('description', 'LIKE', '%' . $search . '%');
                })
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['building_types' => $buildingTypes],
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

    public function index(Request $request)
    {
        try {
            $buildingTypes = BuildingType::all();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['building_types' => $buildingTypes],
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
                'site_id' => ['required'],
                'building_type_name' => ['required', 'string', 'max:255'],
                'description' => ['nullable'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'type' => 'error',
                    'message' => $errors,
                    'data' => '',
                ]);
            }

            $site = Site::where('slug',$request->site_id)->first();

            $data = [
                'uuid' => Str::uuid(),
                'site_id' => $site->id,
                'building_type_name' => $request->building_type_name,
                'description' => $request->description,
            ];

            $buildingType = BuildingType::create($data);

            $message = 'Building Type Added Successfully';

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

    public function edit(Request $request, $btId)
    {
        try {
            $buildingType = BuildingType::with('site.builder')->findOrFail($btId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['building_type' => $buildingType],
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

    public function update(Request $request, $btId)
    {
        try {
            $validator = Validator::make($request->all(), [
                'site_id' => ['required'],
                'building_type_name' => ['required', 'string', 'max:255'],
                'description' => ['nullable'],
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
                'site_id' => $request->site_id,
                'building_type_name' => $request->building_type_name,
                'description' => $request->description,
            ];

            $buildingType = BuildingType::findOrFail($btId);

            $buildingType->update($data);

            $message = 'Building Type Updated Successfully';

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

    public function destroy(Request $request, $btId)
    {
        try {
            $buildingType = BuildingType::findOrFail($btId);

            $buildingType->delete();

            $message = 'Building Type Deleted';

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
