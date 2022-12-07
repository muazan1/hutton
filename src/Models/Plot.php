<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plot extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function job()
    {
        return $this->hasMany(PlotJob::class, 'plot_id', 'id');
    }

    public function buildingType()
    {
        return $this->belongsTo(HouseType::class, 'house_type_id', 'id');
    }

    public static function boot()
    {
        parent::boot();

        self::deleting(function ($plot) {
            $plot->job()->each(function ($jobs) {
                $jobs->delete();
            });
        });
    }
}
