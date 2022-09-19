<?php

namespace Sty\Hutton\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function pricings()
    {
        return $this->hasMany(ServicePricing::class);
    }


    public function joinerPricings()
    {
        return $this->hasMany(JoinerPricing::class);
    }

    public function jobs () {
        return $this->hasMany(HsJob::class,'service_id','id');
    }
}
