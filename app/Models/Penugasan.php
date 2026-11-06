<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penugasan extends Model
{
    protected $table = 'penugasans';

    protected $fillable = [
        'laporan_id',
        'teknisi_id',
        'ditugaskan_oleh',
        'catatan_tugas',
        'tanggal_penugasan',
        'mulai_dikerjakan',
        'selesai_dikerjakan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_penugasan' => 'datetime',
            'mulai_dikerjakan' => 'datetime',
            'selesai_dikerjakan' => 'datetime',
        ];
    }

    public function laporan(): BelongsTo
    {
        return $this->belongsTo(Laporan::class);
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teknisi_id');
    }

    public function pemberiTugas(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ditugaskan_oleh');
    }
}