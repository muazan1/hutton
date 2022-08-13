<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DataTables;
use DB;
use Str;
use Exception;
use Illuminate\Validation\Rule;
use Mockery\Container;

use Sty\Hutton\Http\Requests\CreateSiteRequest;
use Sty\Hutton\Models\Site;
use Sty\Hutton\Models\Customer;
use Sty\Hutton\Models\Service;
use Sty\Hutton\Models\ServicePricing;
use Sty\Hutton\Models\BuildingType;

class ServicePricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $sp = ServicePricing::where(
                'building_type_id',
                $request->building_type_id
            )
                ->where('service_id', $request->service_id)
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

    public function update(Request $request, $spId)
    {
        try {
            $servicePricing = ServicePricing::find($spId)->update([
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

    public function destroy(Request $request, $spId)
    {
        try {
            $service = ServicePricing::findOrFail($spId)->delete();

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

    public function servicePricings(Request $request, $btId)
    {
        try {
            $buildingType = BuildingType::find($btId);

            $pricings = ServicePricing::with('service')
                ->where('building_type_id', $btId)
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

    public function servicesWithPricings(Request $request, $btId)
    {
        try {
            $buildingType = BuildingType::find($btId);

            $services = Service::with([
                'pricings' => function ($query) use ($btId) {
                    $query->where('building_type_id', $btId);
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
