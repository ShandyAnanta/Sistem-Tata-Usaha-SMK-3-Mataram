<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            if (!Schema::hasColumn('disposisi', 'instruksi')) {
                $table->string('instruksi', 255)->nullable()->after('penerima_id');
            }
            if (!Schema::hasColumn('disposisi', 'status')) {
                $table->string('status', 50)->default('terkirim')->index();
            }
        });
    }

    public function down(): void
    {
        Schema::table('disposisi', function (Blueprint $table) {
            if (Schema::hasColumn('disposisi', 'instruksi')) {
                $table->dropColumn('instruksi');
            }
            if (Schema::hasColumn('disposisi', 'status')) {
                $table->dropIndex(['status']);
                $table->dropColumn('status');
            }
        });
    }
};
