<?php

namespace Sty\Hutton\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServicePricing extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
