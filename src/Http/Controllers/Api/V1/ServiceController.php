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

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $search = $request->search ?? '';
            // dd($search);

            $services = Service::all();

            $meta = Service::where(function ($query) use ($search) {
                $query
                    ->where('service_name', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%');
            })->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['services' => $services, 'meta' => $meta],
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

    public function show(Request $request, $sId)
    {
        try {
            $service = Service::findOrFail($sId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['service' => $service],
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
                'service_name' => 'required',
                'description' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors(),
                    'data' => '',
                ]);
            }

            $data = [
                'service_name' => $request->service_name,
                'description' => $request->description,
            ];

            $service = Service::create($data);

            $message = 'Service Added Successfully';

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

    public function edit(Request $request, $sId)
    {
        try {
            $service = Service::findOrFail($sId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['service' => $service],
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

    public function update(Request $request, $sId)
    {
        try {
            $service = Service::findOrFail($sId);

            $validator = Validator::make($request->all(), [
                'service_name' => 'required',
                'description' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors(),
                    'data' => '',
                ]);
            }

            $data = [
                'service_name' => $request->service_name,
                'description' => $request->description,
            ];

            $service->update($data);

            $message = 'Service Updated Successfully';

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

    public function destroy(Request $request, $sId)
    {
        try {
            $service = Service::findOrFail($sId);

            $service->delete();

            $message = 'Service Deleted Successfully';
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
