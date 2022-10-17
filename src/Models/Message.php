<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function admin(){
        return $this->belongsTo(HuttonUser::class,'admin_id','id');
    }

    public function joiner() {
        return $this->belongsTo(HuttonUser::class,'joiner_id','id');
    }

    public function replies() {
        return $this->hasMany(MessageReplay::class);
    }

}
