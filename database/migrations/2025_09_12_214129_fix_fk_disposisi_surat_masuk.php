<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1) Drop FK bernama '1' jika ada (nama dari pesan error)
        $exists = DB::selectOne("
            SELECT COUNT(*) AS c
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND TABLE_NAME = 'disposisi'
              AND CONSTRAINT_NAME = '1'
        ");
        if ($exists && $exists->c > 0) {
            DB::statement('ALTER TABLE `disposisi` DROP FOREIGN KEY `1`');
        }

        // 2) Pastikan kolom surat_masuk_id ada dan bertipe unsigned BIGINT
        Schema::table('disposisi', function (Blueprint $table) {
            if (!Schema::hasColumn('disposisi', 'surat_masuk_id')) {
                $table->unsignedBigInteger('surat_masuk_id')->nullable()->index();
            }
        });

        // 3) Hapus FK lain yang namanya mungkin otomatis dan bentrok (opsional, jika ada)
        $fk = DB::select("
            SELECT CONSTRAINT_NAME
            FROM information_schema.REFERENTIAL_CONSTRAINTS
            WHERE CONSTRAINT_SCHEMA = DATABASE()
              AND CONSTRAINT_NAME LIKE 'disposisi\\_%surat\\_%masuk\\_%id\\_%'
        ");
        foreach ($fk as $row) {
            DB::statement('ALTER TABLE `disposisi` DROP FOREIGN KEY `'.$row->CONSTRAINT_NAME.'`');
        }

        // 4) Tambah FK baru dengan nama unik dan jelas
        Schema::table('disposisi', function (Blueprint $table) {
            // pastikan tidak menduplikasi index bernama sama
            $table->foreign('surat_masuk_id', 'disposisi_surat_masuk_id_fk')
                  ->references('id')->on('surat_masuk')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        // Drop FK dan kolom saat rollback
        Schema::table('disposisi', function (Blueprint $table) {
            // drop FK dengan nama yang tadi dibuat
            try {
                DB::statement('ALTER TABLE `disposisi` DROP FOREIGN KEY `disposisi_surat_masuk_id_fk`');
            } catch (\Throwable $e) {}
            if (Schema::hasColumn('disposisi', 'surat_masuk_id')) {
                $table->dropIndex(['surat_masuk_id']);
                $table->dropColumn('surat_masuk_id');
            }
        });
    }
};
