<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'company_name',
        'contact_number',
        'address',
        'gst_number',
        'lead_source',
        'business_card',
        'gst_document',
        'company_name_board',
        'remarks',
    ];
}
