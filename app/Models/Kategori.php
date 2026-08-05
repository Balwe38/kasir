<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Kategori extends Model
{
    use HasUuids;

    protected $fillable = [
        'nama_kategori',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function produks()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}