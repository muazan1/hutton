<?php

namespace Sty\Hutton\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Models\{User, Role};

use Sty\Hutton\Models\{HuttonUser};

use Carbon\Carbon;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class WageSheetController extends Controller
{
    public function paginate($items, $perPage = 5, $page = null, $options = [])
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

    public function wageSheet(Request $request)
    {
        try {
            $role = Role::where('name', 'joiner')->first();

            $search = $request->search ?? '';

            $sort = $request->has('sort')
                ? json_decode($request->sort)
                : json_decode('{}');

            $week_start = $request->week_start ?? '';

            $joiners = HuttonUser::with(
                'weeklyWork.dailyWork',
                'weeklyWork.miscWork'
            )
                ->where(function ($query) use ($search) {
                    $query
                        ->where('first_name', 'LIKE', '%' . $search . '%')
                        ->orWhere('last_name', 'LIKE', '%' . $search . '%');
                })
                ->where('role_id', $role->id)
                ->get();

            $meta = collect($joiners)->map(function ($item) use ($week_start) {
                $item->dailyTotal = 0;

                $item->weeklyTotal = 0;

                if ($week_start != null) {
                    $item->first = $item->weeklyWork
                        ->where('week_start', '=', $week_start)
                        ->first();
                } else {
                    $item->first = $item->weeklyWork
                        ->where('status', 'in-progress')
                        ->first();
                }

                if ($item->first->dailyWork->count() > 0) {
                    $item->dailyTotal += $item->first->dailyWork
                        ->where(
                            'created_at',
                            '>=',
                            Carbon::now()->format('Y-m-d')
                        )
                        ->sum('amount');
                }

                if ($item->first->miscWork->count() > 0) {
                    $item->dailyTotal += $item->first->miscWork
                        ->where('created_at', Carbon::now())
                        ->sum('amount');
                }

                if ($item->first->dailyWork->count() > 0) {
                    $item->weeklyTotal += $item->first->dailyWork->sum(
                        'amount'
                    );
                }

                if ($item->first->miscWork->count() > 0) {
                    $item->weeklyTotal += $item->first->miscWork->sum('amount');
                }

                return $item;
            });

            if ($sort) {
                $orderKeys = get_object_vars($sort);
                if ($orderKeys != []) {
                    $key = key($orderKeys);
                    $direction = $orderKeys[$key];
                    $meta->orderBy($key, $direction);
                }
            }

            $meta = $this->paginate($meta, 10);

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => $joiners,
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

    public function wageSheetByWeek(Request $request)
    {
        try {
            $weekCommencing = $request->week;

            $role = Role::where('name', 'joiner')->first();

            $joiners = HuttonUser::with([
                'weeklyWork' => function ($query) use ($weekCommencing) {
                    return $query->whereDate('week_start', $weekCommencing);
                },
                'weeklyWork.dailyWork',
            ])
                ->where('role_id', $role->id)
                ->paginate();

            return response()->json([
                'type' => 'success',
                'message' => '',
                'data' => ['joiners' => $joiners],
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
