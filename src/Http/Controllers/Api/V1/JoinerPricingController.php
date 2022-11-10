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
use Sty\Hutton\Models\{Customer, Service, JoinerPricing, BuildingType};

class JoinerPricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $building_type = BuildingType::where(
                'uuid',
                $request->builing_type
            )->first();

            $bid = $building_type->id;

            $service = Service::where('uuid', $request->service_id)->first();

            $jp = JoinerPricing::where('building_type_id', $bid)
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
                'building_type_id' => $bid,
                'service_id' => $request->service_id,
                'price' => $request->price,
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

    public function buildingTypeJoinerPricings(Request $request, $uuid)
    {
        try {
            $building_type = BuildingType::where('uuid', $uuid)->first();

            $joinerPricings = JoinerPricing::with('service')
                ->where('building_type_id', $building_type->id)
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'joiner_pricing' => $joinerPricings,
                    'building_type' => $building_type,
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
    public function buildingTypeJoinerPricingsServices(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $building_type = BuildingType::where('uuid', $uuid)->first();

            $services = Service::where(function ($query) use ($search) {
                $query
                    ->where('service_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })
                ->with([
                    'joinerPricings' => function ($query) use ($building_type) {
                        $query->where('building_type_id', $building_type->id);
                    },
                ])
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'services' => $services,
                    'building_type' => $building_type,
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
