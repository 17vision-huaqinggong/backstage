<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\SerializeDate;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    use SerializeDate;

    protected $fillable = ['account','nickname','phone', 'gender', 'avatar', 'email'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'id', 'user_id');
    }
}
