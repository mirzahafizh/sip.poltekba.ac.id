<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriKerusakan extends Model
{
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'aktif',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
        ];
    }

    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class);
    }
}