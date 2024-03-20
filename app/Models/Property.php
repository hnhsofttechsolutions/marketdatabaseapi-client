<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    public function amenities()
    {
        return $this->hasMany(Amenity::class, 'property_id','id');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id','id');
    }

    public function buyer()
    {
        return $this->belongsToMany(User::class,'expose_requests','property_id', 'buyer_id')->withPivot('status');
    }

}
