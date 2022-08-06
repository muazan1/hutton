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

class SiteController extends Controller
{
    public function customerSites(Request $request, $customerSlug)
    {
        $search = $request->search ?? '';

        $customer = Customer::where('slug', $customerSlug)->first();

        $meta = Site::where('customer_id', $customer->id)
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

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => ['meta' => $meta],
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
            $data = [
                'uuid' => $request->uuid,
                'customer_id' => $customer->id,
                'site_name' => $request->site_name,
                'slug' => $request->slug,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
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
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        }
    }

    public function edit(Request $request, $siteId)
    {
        $site = Site::findOrFail($siteId);

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => $site,
        ]);
    }

    public function update(Request $request, $siteId)
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

            $site = Site::findOrFail($siteId);

            $data = [
                'customer_id' => $request->customer_id,
                'site_name' => $request->site_name,
                'slug' => $request->slug,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
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

    public function destroy(Request $request, $siteId)
    {
        try {
            $site = Site::findOrFail($siteId);

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
