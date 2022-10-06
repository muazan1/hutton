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

use Sty\Hutton\Http\Requests\CreateCustomerRequest;
use Sty\Hutton\Http\Requests\UpdateCustomerRequest;

use Sty\Hutton\Models\Customer;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::all();

        return response()->json([
            'type' => 'success',
            'data' => $customers,
        ]);
    }

    public function store(CreateCustomerRequest $request)
    {
        try {
            $data = [
                'uuid' => $request->uuid,
                'customer_name' => $request->customer_name,
                'slug' => $request->slug,
                'email' => $request->email,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'telephone_number' => $request->telephone_number,
                'county' => $request->county,
            ];

            $customer = Customer::create($data);

            $message = 'Customer Added Successfully';

            return response()->json([
                'type' => 'success',
                'message' => $message,
                'data' => $customer,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => $th->getMessage(),
                'data' => '',
            ]);
        }
    }

    public function edit(Request $request, $customerSlug)
    {
        try {
            $customer = Customer::where('slug',$customerSlug)->first();

            return response()->json([
                'type' => 'success',
                'data' => $customer,
            ]);

        } catch (Exception $th) {

            return response()->json([
                'type' => 'error',
                'data' => $th->getMessage(),
            ]);
        }
    }

    public function update(Request $request, $customerId)
    {
        try {
            $customer = Customer::findOrFail($customerId);

            $request->merge([
                'slug' => Str::slug($request->customer_name),
            ]);

            $validator = Validator::make($request->all(), [
                'customer_name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email'],
                'slug' => ['required', 'string', 'max:255'],
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
                    'data' => '',
                ]);
            }

            $data = [
                'customer_name' => $request->customer_name,
                'slug' => $request->slug,
                'email' => $request->email,
                'street_1' => $request->street_1,
                'street_2' => $request->street_2,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'telephone_number' => $request->telephone_number,
                'county' => $request->county,
            ];

            $customer->update($data);

            $message = 'Customer Updated Successfully';

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

    public function destroy(Request $request, $customerSlug)
    {
        try {
            $customer = Customer::where('slug',$customerSlug)->first();

            $customer->delete();

            $message = 'Customer Deleted Successfully';

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
