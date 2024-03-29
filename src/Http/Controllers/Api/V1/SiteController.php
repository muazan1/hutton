<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\{Hash, Validator, Http, Mail};

use DataTables;

use DB;

use Str;

use Exception;

use Illuminate\Validation\Rule;

use Mockery\Container;

use Sty\Hutton\Http\Requests\CreateSiteRequest;

use Sty\Hutton\Models\{Site, Customer};

class SiteController extends Controller
{
    public function customerSites(Request $request, $uuid)
    {
        $search = $request->search ?? '';

        $customer = Customer::where('uuid', $uuid)->first();

        $meta = Site::with('builder')
            ->where('customer_id', $customer->id)
            ->where(function ($query) use ($search) {
                $query
                    ->where('site_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('telephone_number', 'LIKE', '%' . $search . '%')
                    ->orWhere('street_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('street_1', 'LIKE', '%' . $search . '%')
                    ->orWhere('postcode', 'LIKE', '%' . $search . '%')
                    ->orWhere('county', 'LIKE', '%' . $search . '%')
                    ->orWhere('city', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        $locations = collect(
            Site::where('customer_id', $customer->id)
                ->where('latitude', '!=', null)
                ->where('longitude', '!=', null)
                ->get()
        )->map(function ($item) {
            return [
                'lat' =>
                    $item->latitude != null
                        ? floatval($item->latitude)
                        : floatval(0.0),
                'lng' =>
                    $item->longitude != null
                        ? floatval($item->longitude)
                        : floatval(0.0),
                'title' => $item->site_name,
                'label' => $item->site_name,
            ];
        });

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => ['meta' => $meta, 'locations' => $locations],
        ]);
    }

    public function index(Request $request)
    {
        $meta = Site::paginate(10);

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => ['meta' => $meta],
        ]);
    }

    public function store(CreateSiteRequest $request)
    {
        try {
            $customer = Customer::where('uuid', $request->customer_id)->first();

            $apiKey = env('GOOGLE_MAP_API_KEY');

            $address =
                $request->street_1 .
                ' ' .
                $request->street_2 .
                ', ' .
                $request->city .
                ', ' .
                $request->county .
                ', ' .
                $request->postcode;

            $location = Http::acceptJson()->get(
                'https://maps.googleapis.com/maps/api/geocode/json?address=' .
                    $address .
                    '&key=' .
                    $apiKey
            );

            $latitude = json_decode($location)->results[0]->geometry->location
                ->lat;

            $longitude = json_decode($location)->results[0]->geometry->location
                ->lng;

            $data = [
                'uuid' => $request->uuid,
                'customer_id' => $customer->id,
                'site_name' => $request->site_name,
                'slug' => $request->slug,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'county' => $request->county,
                'telephone_number' => $request->telephone_number,
            ];

            Site::create($data);

            $message = 'Site Created Successfully';

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
        $site = Site::where('uuid', $uuid)->first();

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => $site,
        ]);
    }

    public function details(Request $request, $slug)
    {
        $site = Site::with('builder')
            ->where('slug', $slug)
            ->first();

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => $site,
        ]);
    }

    public function update(Request $request, $uuid)
    {
        try {
            $request->merge([
                'slug' => Str::slug($request->site_name),
            ]);

            $validator = Validator::make($request->all(), [
                'customer_id' => ['required'],
                'site_name' => ['required'],
                'slug' => ['required'],
                'street_1' => ['required'],
                'street_2' => ['nullable'],
                'city' => ['required'],
                'postcode' => ['required'],
                'county' => ['required'],
                'telephone' => ['required'],
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors();

                return response()->json([
                    'type' => 'error',
                    'message' => $errors,
                    'data' => '',
                ]);
            }

            $site = Site::where('uuid', $uuid)->first();

            $customer = Customer::where('uuid', $request->customer_id)->first();

            $apiKey = env('GOOGLE_MAP_API_KEY');

            $address =
                $request->street_1 .
                ' ' .
                $request->street_2 .
                ', ' .
                $request->city .
                ', ' .
                $request->county .
                ', ' .
                $request->postcode;

            $location = Http::acceptJson()->get(
                'https://maps.googleapis.com/maps/api/geocode/json?address=' .
                    $address .
                    '&key=' .
                    $apiKey
            );

            $latitude = json_decode($location)->results[0]->geometry->location
                ->lat;

            $longitude = json_decode($location)->results[0]->geometry->location
                ->lng;

            $data = [
                'customer_id' => $customer->id,
                'site_name' => $request->site_name,
                'slug' => $request->slug,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'latitude' => $latitude,
                'longitude' => $longitude,
                'county' => $request->county,
                'telephone' => $request->telephone,
            ];

            $site->update($data);

            $message = 'Site Updated Successfully';

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
            $site = Site::where('uuid', $uuid)->first();

            $site->delete();

            $message = 'Site Deleted Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            $message = $th->getMessage();

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        }
    }
}
