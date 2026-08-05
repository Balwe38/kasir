<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Produk extends Model
{
    use HasUuids;

    protected $fillable = [
        'code',
        'nama_produk',
        'harga',
        'stok',
        'deskripsi',
        'status',
        'created_by',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected $casts = [
        'status' => 'boolean',
    ];
}