<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id','id');
    }

    public function properties()
    {
        return $this->hasMany(Property::class, 'seller_id','id');
    }

    public function subscription()
    {
        return $this->hasOne(SubscriptionPlan::class, 'user_id','id');
    }

    public function property()
    {
        return $this->belongsToMany(Property::class,'expose_requests','buyer_id', 'property_id')->withPivot('status');
    }

    public function investorDetail()
    {
        return $this->hasOne(InvestorDetail::class, 'buyer_id','id');
    }

    public function investorProfile()
    {
        return $this->hasMany(InvestorProfile::class, 'buyer_id','id');
    }

}
