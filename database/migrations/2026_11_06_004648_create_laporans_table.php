<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up(): void
{
    Schema::create('laporans', function (Blueprint $table) {
        $table->id();

        $table->string('nomor_tiket')->unique();

        $table->foreignId('user_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->foreignId('gedung_id')
            ->constrained('gedungs')
            ->restrictOnDelete();

        $table->foreignId('kategori_kerusakan_id')
            ->constrained('kategori_kerusakans')
            ->restrictOnDelete();

        $table->string('lokasi_detail');
        $table->string('judul_laporan');
        $table->text('deskripsi');

        $table->enum('status', [
            'laporan_baru',
            'menunggu_persetujuan_wadir_ii',
            'ditolak',
            'disetujui',
            'menunggu_penanganan_upa',
            'ditugaskan',
            'sedang_dikerjakan',
            'menunggu_verifikasi',
            'selesai'
        ])->default('laporan_baru');

        $table->foreignId('disetujui_oleh')
            ->nullable()
            ->constrained('users')
            ->nullOnDelete();

        $table->timestamp('disetujui_pada')->nullable();

        $table->text('catatan_penolakan')->nullable();

        $table->timestamps();

        $table->index(['status', 'created_at']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
