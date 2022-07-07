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
    public function customerSites(Request $request, $customerId)
    {
        $sites = Site::where('customer_id', $customerId)->get();

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => ['sites' => $sites],
        ]);
    }

    public function index(Request $request)
    {
        $sites = Site::all();

        return response()->json([
            'type' => 'success',
            'message' => '',
            'data' => ['sites' => $sites],
        ]);
    }

    public function store(CreateSiteRequest $request)
    {
        try {
            $data = [
                'uuid' => $request->uuid,
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
            dd('hello world');
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => $th->getMessage(),
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
