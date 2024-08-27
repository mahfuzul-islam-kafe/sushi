<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function zones()
    {
        return $this->belongsToMany(Zone::class, 'restaurant_zone', 'restaurant_id', 'zone_id')
            ->withPivot('zone_name');
    }
    
    public function address(): Attribute
    {
          
        return Attribute::make(
            
            get: fn($value) => json_decode($value,true),
            set: fn($value) => json_encode($value),
        );
    }
    // public function api_key(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn($value) => json_decode($value,true),
    //         set: fn($value) => json_encode($value),
    //     );
    // }

    
}
