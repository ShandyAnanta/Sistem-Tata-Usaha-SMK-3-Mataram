<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Tambah pengirim_id jika belum ada
            if (!Schema::hasColumn('disposisi', 'pengirim_id')) {
                $table->foreignId('pengirim_id')->constrained('users')->cascadeOnDelete();
                $table->index('pengirim_id');
            }

            // Tambah penerima_id jika belum ada (tanpa after)
            if (!Schema::hasColumn('disposisi', 'penerima_id')) {
                $table->foreignId('penerima_id')->constrained('users')->cascadeOnDelete();
                $table->index('penerima_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            // Hapus FK + index + kolom penerima_id jika ada
            if (Schema::hasColumn('disposisi', 'penerima_id')) {
                $table->dropForeign(['penerima_id']);
                $table->dropIndex(['penerima_id']);
                $table->dropColumn('penerima_id');
            }

            // Hapus FK + index + kolom pengirim_id jika ada
            if (Schema::hasColumn('disposisi', 'pengirim_id')) {
                $table->dropForeign(['pengirim_id']);
                $table->dropIndex(['pengirim_id']);
                $table->dropColumn('pengirim_id');
            }
        });
    }
};
