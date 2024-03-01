<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    protected $guarded = [];

    public $timestamps = false;


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected static function booted()
    {
        static::created(function ($user) {
            if (User::count() === 1) {
                $user->assignRole('admin');
                $user->active_status = true;
                $user->can_modify = true;
                $user->save();
            } else {
                $user->assignRole('notconfirmed');
            }
        });

    }

    public function role()
    {
        return $this->hasOne(Role::class)->without('pivot');
    }

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'users_partners');
    }
}
