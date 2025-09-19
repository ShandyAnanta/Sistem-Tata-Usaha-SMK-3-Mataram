<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            // Empat field sederhana sesuai pedoman
            if (!Schema::hasColumn('surat_keluar', 'tanggal_surat')) {
                $table->date('tanggal_surat')->index();
            }
            if (!Schema::hasColumn('surat_keluar', 'nama_penerima')) {
                $table->string('nama_penerima', 191)->index();
            }
            if (!Schema::hasColumn('surat_keluar', 'keterangan_surat')) {
                $table->string('keterangan_surat', 255);
            }

            // nomor_surat wajib (NOT NULL)
            if (Schema::hasColumn('surat_keluar', 'nomor_surat')) {
                $table->string('nomor_surat', 191)->nullable(false)->change();
            } else {
                $table->string('nomor_surat', 191);
            }

            // Opsional: jika ada kolom lama yang tidak dipakai, biarkan dulu agar aman (hindari drop saat awal)
            // Contoh: template_id/body bisa diabaikan di level aplikasi.
        });
    }

    public function down(): void
    {
        Schema::table('surat_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('surat_keluar', 'keterangan_surat')) {
                $table->dropColumn('keterangan_surat');
            }
            if (Schema::hasColumn('surat_keluar', 'nama_penerima')) {
                $table->dropColumn('nama_penerima');
            }
            // tanggal_surat & nomor_surat dipertahankan
        });
    }
};
