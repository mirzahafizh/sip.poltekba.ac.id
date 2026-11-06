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
    Schema::table('users', function (Blueprint $table) {
        $table->foreignId('unit_id')
            ->nullable()
            ->constrained('units')
            ->nullOnDelete();

        $table->string('whatsapp', 20)->nullable();

        $table->enum('role', [
            'pelapor',
            'wadir_ii',
            'upa',
            'teknisi',
            'admin'
        ])->default('pelapor');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropForeign(['unit_id']);
        $table->dropColumn(['unit_id', 'whatsapp', 'role']);
    });
}
};
