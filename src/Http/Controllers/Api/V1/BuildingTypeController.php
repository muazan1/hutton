<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\{Hash, Mail, Validator};

use Illuminate\Validation\Rule;

use Illuminate\Database\Eloquent\Collection;

use Exception;

use Sty\Hutton\Models\{Site, HouseType};

use Str;

class BuildingTypeController extends Controller
{
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items =
            $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }

    public function SiteBuildingTypes(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $site = Site::where('uuid', $uuid)->first();

            $buildingTypes = HouseType::with('site.builder')
                ->where('site_id', $site->id)
                ->where(function ($query) use ($search) {
                    $query->where(
                        'house_type_name',
                        'LIKE',
                        '%' . $search . '%'
                    );
                });

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $buildingTypes->orderBy($key, $direction);
                }
            }

            $meta = $buildingTypes->paginate(10);

            $buildingTypes = $buildingTypes->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $buildingTypes,
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

    public function index(Request $request)
    {
        try {
            $buildingTypes = HouseType::all();

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
                'site' => ['required'],
                'house_type_name' => ['required', 'string', 'max:255'],
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

            $site = Site::where('uuid', $request->site)->first();

            $data = [
                'uuid' => Str::uuid(),
                'site_id' => $site->id,
                'house_type_name' => $request->house_type_name,
                'description' => $request->description,
            ];

            $buildingType = HouseType::create($data);

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
            $buildingType = HouseType::with('site.builder')
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
                'site' => ['required'],
                'house_type_name' => ['required', 'string', 'max:255'],
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

            $site = Site::where('uuid', $request->site)->first();

            $data = [
                'site_id' => $site->id,
                'house_type_name' => $request->house_type_name,
                'description' => $request->description,
            ];

            $buildingType = HouseType::where('uuid', $uuid)->first();

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
            $buildingType = HouseType::where('uuid', $uuid)->first();

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
