<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use DataTables;
use DB;
use Str;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

use Sty\Hutton\Models\JoinerPricing;

use App\Models\User;
use Sty\Hutton\Models\Customer;

class JoinerPricingController extends Controller
{
    public function store(Request $request)
    {
        try {
            $builder = Customer::select('id')
                ->where('slug', $request->builder_id)
                ->first();

            $bid = $builder['id'];

            $jp = JoinerPricing::where('builder_id', $bid)
                ->where('service_id', $request->service_id)
                ->count();

            if ($jp > 0) {
                $message = 'Joiner Pricing Already Exsist';

                return response()->json([
                    'type' => 'error',
                    'message' => $message,
                    'data' => '',
                ]);
            }

            $data = [
                'builder_id' => $bid,
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

    public function update(Request $request, $jpId)
    {
        try {
            $servicePricing = JoinerPricing::find($jpId)->update([
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

    public function destroy(Request $request, $jpId)
    {
        try {
            $service = JoinerPricing::findOrFail($jpId)->delete();

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

    public function builderJoinerPricings(Request $request, $builderId)
    {
        try {
            $builder = Customer::select('id')->find($builderId);

            $joinerPricings = JoinerPricing::with('service')
                ->where('builder_id', $builder->id)
                ->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => [
                    'joiner_pricing' => $joinerPricings,
                    'builder' => $builder,
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
