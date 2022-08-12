<?php

namespace Sty\Hutton\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HsJob extends Model
{
    use HasFactory;

    protected $table = 'plot_jobs';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function plot()
    {
        return $this->belongsTo(Plot::class, 'plot_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
