<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            if (Schema::hasColumn('surat_masuk', 'perihal')) {
                $table->dropColumn('perihal');
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_masuk', 'perihal')) {
                $table->string('perihal', 255)->nullable();
            }
        });
    }
};
