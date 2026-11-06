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
    Schema::create('penugasans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('laporan_id')
            ->constrained('laporans')
            ->cascadeOnDelete();

        $table->foreignId('teknisi_id')
            ->constrained('users')
            ->restrictOnDelete();

        $table->foreignId('ditugaskan_oleh')
            ->constrained('users')
            ->restrictOnDelete();

        $table->text('catatan_tugas')->nullable();

        $table->timestamp('tanggal_penugasan')->nullable();
        $table->timestamp('mulai_dikerjakan')->nullable();
        $table->timestamp('selesai_dikerjakan')->nullable();

        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penugasans');
    }
};
