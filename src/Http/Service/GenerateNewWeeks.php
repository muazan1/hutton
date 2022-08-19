<?php

namespace Sty\Hutton\Http\Service;

use App\Models\User;

use App\Models\Role;

use Carbon\Carbon;

use Sty\Hutton\Models\WeeklyWork;
use phpDocumentor\Reflection\Types\Null_;

class GenerateNewWeeks
{
    //
    public static function newWeeks()
    {
        $joinerRole = Role::where('name', 'joiner')->first();

        $joiners = User::where('role_id', $joinerRole->id)->get();

        foreach ($joiners as $joiner) {
            $weeklyWork = WeeklyWork::where('user_id', $joiner->id)
                ->where('status', 'in-progress')
                ->first();

            if ($weeklyWork != null) {
                $weeklyWork->update(['status' => 'completed']);
            }

            $data = [
                'user_id' => $joiner->id,
                'status' => 'in-progress',
                'week_start' => Carbon::now(),
                'week_end' => Carbon::now()->addWeek(1),
            ];

            $newWeek = WeeklyWork::create($data);
        }
    }
}
