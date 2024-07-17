<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'vehicle_type',
        'body_type',
        'tonnage_passing',
        'driver_number',
        'status',
        'rc_book',
        'driving_license',
        'remarks',
    ];

    
}
