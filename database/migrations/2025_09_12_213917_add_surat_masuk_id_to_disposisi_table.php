<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            if (!Schema::hasColumn('disposisi', 'surat_masuk_id')) {
                $table->foreignId('surat_masuk_id')
                      ->constrained('surat_masuk') // refer ke id di tabel surat_masuk
                      ->cascadeOnDelete()
                      ->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            if (Schema::hasColumn('disposisi', 'surat_masuk_id')) {
                $table->dropForeign(['surat_masuk_id']);
                $table->dropIndex(['surat_masuk_id']);
                $table->dropColumn('surat_masuk_id');
            }
        });
    }
};
