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

use Sty\Hutton\Models\{Site, BuildingType, Customer, Service, ServicePricing};

class ServicePricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $service = Service::where('uuid', $request->service)->first();

            $building_type = BuildingType::where(
                'uuid',
                $request->building_type
            )->first();

            $sp = ServicePricing::where('building_type_id', $building_type->id)
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
                'building_type_id' => $request->building_type_id,
                'service_id' => $request->service_id,
                'price' => $request->price,
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
            $service = ServicePricing::where('uuid', $uuid)
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

    public function servicePricings(Request $request, $uuid)
    {
        try {
            $buildingType = BuildingType::where('uuid', $uuid)->first();

            $pricings = ServicePricing::with('service')
                ->where('building_type_id', $buildingType->id)
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'pricings' => $pricings,
                    'buildingType' => $buildingType,
                ],
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
            $buildingType = BuildingType::where('uuid', $uuid)->first();

            $services = Service::with([
                'pricings' => function ($query) use ($buildingType) {
                    $query->where('building_type_id', $buildingType->id);
                },
            ])->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'pricings' => $services,
                    'buildingType' => $buildingType,
                ],
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
