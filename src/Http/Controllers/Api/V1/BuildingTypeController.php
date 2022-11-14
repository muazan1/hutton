<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Collection;

use Exception;

use Sty\Hutton\Models\{Site, BuildingType};

use Str;

class BuildingTypeController extends Controller
{
    public function SiteBuildingTypes(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $site = Site::where('uuid', $uuid)->first();


            $buildingTypes = BuildingType::with('site.builder')
                ->where('site_id', $site->id)
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
                'site_slug' => ['required'],
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

            $site = Site::where('slug', $request->site_slug)->first();

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

    public function edit(Request $request, $uuid)
    {
        try {
            $buildingType = BuildingType::with('site.builder')
                ->where('uuid', $uuid)
                ->first();

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

    public function update(Request $request, $uuid)
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

            $site = Site::where('slug', $request->site_slug)->first();

            $data = [
                'site_id' => $site->id,
                'building_type_name' => $request->building_type_name,
                'description' => $request->description,
            ];

            $buildingType = BuildingType::where('uuid', $uuid)->first();

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

    public function destroy(Request $request, $uuid)
    {
        try {
            $buildingType = BuildingType::where('uuid', $uuid)->first();

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
