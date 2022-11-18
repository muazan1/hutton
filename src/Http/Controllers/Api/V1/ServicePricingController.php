<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Str;

use Sty\Hutton\Models\{HouseType, Service, ServicePricing};

class ServicePricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $service = Service::where('uuid', $request->service)->first();

            $house_type = HouseType::where(
                'uuid',
                $request->house_type
            )->first();

            $sp = ServicePricing::where('house_type_id', $house_type->id)
                ->where('service_id', $service->id)
                ->count();

            if ($sp > 0) {
                $message = 'Service is Already Added for Pricing';

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

            $service = ServicePricing::create($data);

            $message = 'Service Added for Pricing';

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
            $servicePricing = ServicePricing::where('uuid', $uuid)
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
            $service = ServicePricing::where('uuid', $uuid)->first();

            $service->delete();

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

    public function servicePricings(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $house_type = HouseType::where('uuid', $uuid)->first();

            $pricings = ServicePricing::with('service')->where(
                'house_type_id',
                $house_type->id
            );

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $pricings->orderBy($key, $direction);
                }
            }

            $meta = $pricings->paginate(10);

            $pricings = $pricings->get();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $pricings,
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

    public function servicesWithPricings(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $house_type = HouseType::where('uuid', $uuid)->first();

            $services = Service::with([
                'pricings' => function ($query) use ($house_type) {
                    $query->where('house_type_id', $house_type->id);
                },
            ])->where(function ($query) use ($search) {
                $query->where('service_name', 'LIKE', '%' . $search . '%');
            });

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $services->orderBy($key, $direction);
                }
            }

            $meta = $services->paginate(10);

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
