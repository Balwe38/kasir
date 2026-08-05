<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasUuids;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id_kasir',
        'number_transaction',
        'name_cust',
        'transaction_date',
        'total_price',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class, 'id_transaction');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir');
    }
}