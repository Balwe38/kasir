<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class stockses extends Model
{
    //
   protected $fillable = [
        'product_id',
        'quantity',
        'type_transaction',
        'base_price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
