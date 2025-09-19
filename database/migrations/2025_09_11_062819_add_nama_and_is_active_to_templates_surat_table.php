<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('templates_surat', function (Blueprint $table) {
            if (!Schema::hasColumn('templates_surat', 'nama')) {
                $table->string('nama', 191)->index();
            }
            if (!Schema::hasColumn('templates_surat', 'is_active')) {
                $table->boolean('is_active')->default(true)->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('templates_surat', function (Blueprint $table) {
            if (Schema::hasColumn('templates_surat', 'nama')) {
                $table->dropIndex(['nama']);
                $table->dropColumn('nama');
            }
            if (Schema::hasColumn('templates_surat', 'is_active')) {
                $table->dropIndex(['is_active']);
                $table->dropColumn('is_active');
            }
        });
    }
};
