<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles; // <-- Import HasRoles

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles; // <-- Add HasRoles

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 
        'image',
        'email',
        'address',
        'phone',
        'department',
        'designation',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function departmentname()
    {
        return $this->belongsTo(Department::class, 'department');
    }

    public function designationname()
    {
        return $this->belongsTo(Designation::class, 'designation');
    }
    // Relation with UserSocialInfo
    public function socialInfo()
    {
        return $this->hasOne(UserSocialInfo::class);
    }

    // Relation with UserRecovery
    public function recovery()
    {
        return $this->hasOne(UserRecovery::class);
    }

    public function notificationSetting()
    {
        return $this->hasOne(NotificationSetting::class, 'user_id', 'id');
    }
    public function twoFactorAuthentication()
    {
        return $this->hasOne(TwoFactorAuthentication::class);
    }
}