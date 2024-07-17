<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pricing extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'pickup_city',
        'drop_city',
        'vehicle_type',
        'body_type',
        'rate_from',
        'rate_to',
        'remarks',
    ];
}
