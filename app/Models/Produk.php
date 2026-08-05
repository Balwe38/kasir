<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use SoftDeletes;
    use HasUuids;

    protected $fillable = [
        'code',
        'nama_produk',
        'harga',
        'stok',
        'description',
        'kategori_id',
        'status',
        'created_by',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'status' => 'boolean',
    ];

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class, 'id_product');
    }


    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
}