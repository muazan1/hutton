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

use Illuminate\Validation\Rules\Password;

use App\Models\User;

use Sty\Hutton\Models\{Customer, Service, JoinerPricing, HouseType};

class JoinerPricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $house_type = HouseType::where(
                'uuid',
                $request->house_type
            )->first();

            $service = Service::where('uuid', $request->service)->first();

            $jp = JoinerPricing::where('house_type_id', $house_type->id)
                ->where('service_id', $service->id)
                ->count();

            if ($jp > 0) {
                $message = 'Joiner Pricing Already Exist';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $data = [
                'uuid' => Str::uuid(),
                'house_type_id' => $house_type->id,
                'service_id' => $service->id,
                'price' => 0.0,
            ];

            $service = JoinerPricing::create($data);

            $message = 'Joiner Pricing Added';

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

    public function update(Request $request, $uuid)
    {
        try {
            $servicePricing = JoinerPricing::where('uuid', $uuid)
                ->first()
                ->update([
                    'price' => $request->price,
                ]);

            $message = 'Price Updated Successfully';

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
            $service = JoinerPricing::where('uuid', $uuid)
                ->first()
                ->delete();

            $message = 'Service Removed for Pricing';

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

    public function JoinerPricings(Request $request, $uuid)
    {
        try {
            $house_type = HouseType::where('uuid', $uuid)->first();

            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $data = JoinerPricing::with('service')->where(
                'house_type_id',
                $house_type->id
            );

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $data->orderBy($key, $direction);
                }
            }

            $joiners = $data->get();

            $meta = $data->paginate(20);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $joiners,
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
    public function JoinerPricingsServices(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $house_type = HouseType::where('uuid', $uuid)->first();

            $services = Service::where(function ($query) use ($search) {
                $query
                    ->where('service_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })->with([
                'joinerPricings' => function ($query) use ($house_type) {
                    $query->where('house_type_id', $house_type->id);
                },
            ]);

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $services->orderBy($key, $direction);
                }
            }

            $meta = $services->paginate(20);

            $services = $services->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $services,
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
}
