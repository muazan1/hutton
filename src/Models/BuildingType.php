<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingType extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];
}
