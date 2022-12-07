<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class HouseType extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id', 'id');
    }

    public function plots()
    {
        return $this->hasMany(Plot::class, 'house_type_id', 'id');
    }

    public function pricing()
    {
        return $this->belongsTo(ServicePricing::class, 'id', 'house_type_id');
    }
}
