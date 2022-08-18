<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DailyWork extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function plot()
    {
        return $this->belongsTo(Plot::class, 'plot_id', 'id');
    }
}
