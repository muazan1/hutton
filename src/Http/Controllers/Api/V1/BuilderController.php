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

use Sty\Hutton\Http\Requests\CreateBuilderRequest;
use Sty\Hutton\Http\Requests\UpdateBuilderRequest;

use Sty\Hutton\Models\Builder;

class BuilderController extends Controller
{
    //
    public function index(Request $request)
    {
        $builders = Builder::all();

        return response()->json([
            'type' => 'success',
            'data' => $builders,
        ]);
    }

    public function store(CreateBuilderRequest $request)
    {
        try {
            $data = [
                'uuid' => $request->uuid,
                'builder_name' => $request->builder_name,
                'slug' => $request->slug,
                'email' => $request->email,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'telephone_number' => $request->telephone_number,
                'county' => $request->county,
            ];

            $builder = Builder::create($data);

            $message = 'Builder Added Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => $builder,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function edit(Request $request, $builderId)
    {
        try {
            $builder = Builder::findOrFail($builderId);

            return response()->json([
                'type' => 'success',
                'data' => $builder,
            ]);
        } catch (Exception $th) {
            return response()->json([
                'type' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $builderId)
    {
        // dd($builderId);

        $builder = Builder::findOrFail($builderId);

        $validator = Validator::make($request->all(), [
            'builder_name' => ['required', 'string', 'max:255'],
            'email' => ['required|email'],
            'street_1' => ['required', 'string', 'max:255'],
            'street_2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'postcode' => ['required', 'string', 'max:255'],
            'telephone_number' => ['required', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'customer_type' => ['nullable', 'integer', 'max:255'],
            'contract_type' => ['nullable', 'integer', 'max:255'],
            'contract_expiry_date' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();

            return response()->json([
                'type' => 'error',
                'message' => $errors,
            ]);
        }
    }

    public function destroy(Request $request, $builderId)
    {
        try {
            $builder = Builder::findOrFail($builderId);

            $builder->delete();

            $message = 'Builder Deleted Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => '',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => $th->getMessage(),
            ]);
        }
    }
}
