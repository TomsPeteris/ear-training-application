<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string role
 * @property string|null avatar
 * @property \Illuminate\Support\Carbon|null created_at
 * @property \Illuminate\Support\Carbon|null updated_at
 *
 */
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
        'first_name',
        'last_name',
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

    /**
     * @return HasMany
     */
    public function exercises(): HasMany
    {
        return $this->hasMany('App\Models\Exercise');
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ADMIN_ROLE ||
            $this->role === self::SUPER_ADMIN_ROLE;
    }

    /**
     * @return string|null
     */
    public function getAvatarPath(): string|null
    {
        return $this->avatar ? asset('storage/'.$this->avatar) : null;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->first_name.' '.$this->last_name;
    }
}
