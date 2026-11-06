<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Laporan extends Model
{
    protected $table = 'laporans';

    protected $fillable = [
        'nomor_tiket',
        'user_id',
        'gedung_id',
        'kategori_kerusakan_id',
        'lokasi_detail',
        'judul_laporan',
        'deskripsi',
        'status',
        'disetujui_oleh',
        'disetujui_pada',
        'catatan_penolakan',
    ];

    protected function casts(): array
    {
        return [
            'disetujui_pada' => 'datetime',
        ];
    }

    public const STATUSES = [
        'laporan_baru',
        'menunggu_persetujuan_wadir_ii',
        'ditolak',
        'disetujui',
        'menunggu_penanganan_upa',
        'ditugaskan',
        'sedang_dikerjakan',
        'menunggu_verifikasi',
        'selesai',
    ];

    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function gedung(): BelongsTo
    {
        return $this->belongsTo(Gedung::class);
    }

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(
            KategoriKerusakan::class,
            'kategori_kerusakan_id'
        );
    }

    public function penyetuju(): BelongsTo
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    public function fotos(): HasMany
    {
        return $this->hasMany(LaporanFoto::class);
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatStatus::class);
    }

public function penugasan()
{
    return $this->hasOne(Penugasan::class, 'laporan_id')->latestOfMany();
}

public function verifikasi()
{
    return $this->hasOne(Verifikasi::class, 'laporan_id')->latestOfMany();
}
}