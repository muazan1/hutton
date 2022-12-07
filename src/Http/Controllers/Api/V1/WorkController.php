<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

use Sty\Hutton\Models\WeeklyWork;

use App\Models\User;

class WorkController extends Controller
{
    public function JoinerWorkHistory(Request $request, $uuid)
    {
        try {
            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $joiner = User::where('uuid', $uuid)->first();

            $weeklyWorks = WeeklyWork::where('user_id', $joiner->id);

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $weeklyWorks->orderBy($key, $direction);
                }
            }

            $data = $weeklyWorks->get();

            $meta = $weeklyWorks->paginate(20);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $data,
                'meta' => $meta,
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
