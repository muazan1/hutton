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
use Illuminate\Validation\Rules\Password;
use Illuminate\Database\Eloquent\Collection;
use App\Models\User;
use App\Models\Role;
use Sty\Hutton\Models\HuttonUser;

class JoinerController extends Controller
{
    public function paginate($items, $perPage = 50, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items =
            $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            $options
        );
    }
    public function index(Request $request)
    {
        try {
            $role = Role::where('name', 'joiner')->first();

            $joiners = User::where('role_id', $role->id)->get();

            $meta = User::where('role_id', $role->id)->paginate(10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['joiner' => $joiners, 'meta' => $meta],
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
        // dd($request);
        try {
            $role = Role::where('name', 'joiner')->first();

            $request->merge([
                'uuid' => (string) Str::uuid(),
                'role_id' => $role->id,
            ]);

            $validator = Validator::make($request->all(), [
                'uuid' => 'required',
                'role_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|unique:users',
                'phone' => 'required|unique:users',
                'password' => ['required', Password::min(8)],
                'confirm_password' => [
                    'required_with:password',
                    'same:password',
                    Password::min(8),
                ],
                'address' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors(),
                    'data' => '',
                ]);
            }

            $data = [
                'uuid' => $request->uuid,
                'role_id' => $request->role_id,
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ];

            $user = User::create($data);
            $user->address = $request->address;
            $user->phone = $request->phone;

            $user->save();

            $message = 'Joiner Added Successfully';

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

    public function edit(Request $request, $joinerId)
    {
        try {
            $joiner = User::findOrFail($joinerId);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['joiner' => $joiner],
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

    public function update(Request $request, $joinerId)
    {
        try {
            $role = Role::where('name', 'joiner')->first();

            $request->merge([
                'role_id' => $role->id,
            ]);
            $joiner = User::findOrFail($joinerId);

            $validator = Validator::make($request->all(), [
                'role_id' => 'required',
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => Rule::unique('users')->ignore($joinerId),
                // 'phone' => 'required|unique:users',
                // 'password' => ['required', Password::min(8)],
                // 'confirm_password' => [
                //     'required_with:password',
                //     'same:password',
                //     Password::min(8),
                // ],
                // 'address' => 'nullable',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => $validator->errors(),
                    'data' => '',
                ]);
            }

            $data = [
                'role_id' => $request->role_id,
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'phone' => $request['phone'],
                'address' => $request->address,
            ];

            $joiner->update($data);

            $joiner->address = $request->address;

            $joiner->phone = $request->phone;

            $joiner->save();

            $message = 'Joiner Updated Successfully';

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

    public function destroy(Request $request, $joinerId)
    {
        try {
            $joiner = User::findOrFail($joinerId);

            $joiner->delete();

            $message = 'Joiner Deleted Successfully';

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
