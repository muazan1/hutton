<?php

namespace Sty\Hutton\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class HuttonUser extends Authenticatable
{
    protected $table = 'users';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function weeklyWork()
    {
        return $this->hasMany(WeeklyWork::class);
    }
}
