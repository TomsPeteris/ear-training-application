<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use hasFactory;

    const MEMBER_ROLE = 'Member';
    const ADMIN_ROLE = 'Admin';
    const SUPER_ADMIN_ROLE = 'Super Admin';
    const ASSIGNABLE_ROLES = [self::MEMBER_ROLE, self::ADMIN_ROLE];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'full_name',
        'email',
        'password',
        'role',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exercises()
    {
        return $this->hasMany('App\Models\Exercise');
    }

    public function isAdmin()
    {
        return $this->role === self::ADMIN_ROLE ||
            $this->role === self::SUPER_ADMIN_ROLE;
    }

    public function getAvatarPath()
    {
        return $this->avatar ? asset('storage/'.$this->avatar) : null;
    }
}
