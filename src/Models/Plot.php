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
        return $this->hasMany(HsJob::class, 'plot_id', 'id');
    }
}
