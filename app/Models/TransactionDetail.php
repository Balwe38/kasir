<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TransactionDetail extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_transaction',
        'id_product',
        'qty',
        'price',
        'discount_price',
        'discount_percent',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_product');
    }
}