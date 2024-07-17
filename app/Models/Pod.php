<?php

// app/Models/Pod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pod extends Model
{
    protected $fillable = ['courier_receipt_no', 'pod_soft_copy', 'pod_courier', 'indent_id'];

    public function indent()
    {
        return $this->belongsTo(Indent::class);
    }
}

