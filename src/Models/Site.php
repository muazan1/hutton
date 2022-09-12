<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function buildingTypes ()
    {
        return $this->hasMany(BuildingType::class,'site_id','id');
    }

    public function builder() {
        return $this->belongsTo(Customer::class,'customer_id','id');
    }
}
