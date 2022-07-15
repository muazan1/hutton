<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class WeeklyWork extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function dailyWork()
    {
        return $this->hasMany(DailyWork::class, 'week_id', 'id');
    }
}
