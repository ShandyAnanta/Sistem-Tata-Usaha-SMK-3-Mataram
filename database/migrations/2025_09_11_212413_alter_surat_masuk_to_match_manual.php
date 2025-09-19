<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            // Tambahan kolom sesuai buku agenda manual
            if (!Schema::hasColumn('surat_masuk', 'pengirim')) {
                $table->string('pengirim', 191)->index();
            }
            if (!Schema::hasColumn('surat_masuk', 'tanggal_surat')) {
                $table->date('tanggal_surat')->index();
            }
            if (!Schema::hasColumn('surat_masuk', 'keterangan_isi')) {
                $table->string('keterangan_isi', 255)->nullable();
            }
            if (!Schema::hasColumn('surat_masuk', 'tanggal_masuk')) {
                $table->date('tanggal_masuk')->nullable()->index();
            }

            // nomor_surat wajib: jika kolom sudah ada dan sebelumnya nullable, ubah menjadi NOT NULL
            if (Schema::hasColumn('surat_masuk', 'nomor_surat')) {
                // Catatan: pada beberapa versi/driver perlu doctrine/dbal untuk change()
                $table->string('nomor_surat', 191)->nullable(false)->change();
            } else {
                $table->string('nomor_surat', 191);
            }
        });
    }

    public function down(): void
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            // Kembalikan perubahan minimal
            if (Schema::hasColumn('surat_masuk', 'tanggal_masuk')) {
                $table->dropColumn('tanggal_masuk');
            }
            if (Schema::hasColumn('surat_masuk', 'keterangan_isi')) {
                $table->dropColumn('keterangan_isi');
            }
            // pengirim, tanggal_surat, nomor_surat dipertahankan
        });
    }
};
