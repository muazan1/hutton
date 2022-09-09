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

    public function miscWork(){
        return $this->belongsTo(MiscWork::class,'week_id','id');
    }

    public function joiner(){
        return $this->belongsTo(HuttonUser::class,'user_id','id');
    }
}
