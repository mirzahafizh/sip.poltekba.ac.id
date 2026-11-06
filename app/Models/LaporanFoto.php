<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LaporanFoto extends Model
{
    protected $table = 'laporan_fotos';

    protected $fillable = [
        'laporan_id',
        'jenis_foto',
        'nama_file',
        'path',
        'uploaded_by',
    ];

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}