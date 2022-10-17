<?php

namespace Sty\Hutton\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class MessageReplay extends Model
{
    use HasFactory;

    protected $table = 'message_replay';

    protected $guarded = ['id', 'created_at', 'updated_at'];


}
