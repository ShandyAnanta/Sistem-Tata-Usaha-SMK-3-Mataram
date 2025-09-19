<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('number_sequences')) {
            Schema::create('number_sequences', function (Blueprint $table) {
                $table->id();
                $table->string('prefix', 191)->unique();
                $table->unsignedInteger('last_number')->default(0);
                $table->timestamps();
            });
        } else {
            Schema::table('number_sequences', function (Blueprint $table) {
                if (!Schema::hasColumn('number_sequences','prefix')) {
                    $table->string('prefix', 191)->unique();
                }
                if (!Schema::hasColumn('number_sequences','last_number')) {
                    $table->unsignedInteger('last_number')->default(0);
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('number_sequences');
    }
};

