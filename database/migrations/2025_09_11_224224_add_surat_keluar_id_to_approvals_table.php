<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('approvals', function (Blueprint $table) {
            if (!Schema::hasColumn('approvals', 'surat_keluar_id')) {
                $table->foreignId('surat_keluar_id')
                      ->constrained('surat_keluar')
                      ->cascadeOnDelete()
                      ->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('approvals', function (Blueprint $table) {
            if (Schema::hasColumn('approvals', 'surat_keluar_id')) {
                $table->dropForeign(['surat_keluar_id']);
                $table->dropIndex(['surat_keluar_id']);
                $table->dropColumn('surat_keluar_id');
            }
        });
    }
};
