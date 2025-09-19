<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            if (!Schema::hasColumn('surat_keluar', 'status')) {
                $table->string('status', 50)->default('draft')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('surat_keluar', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }
        });
    }
};
