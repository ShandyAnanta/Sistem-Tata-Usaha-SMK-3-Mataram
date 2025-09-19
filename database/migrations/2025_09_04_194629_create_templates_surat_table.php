<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates_surat', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kode_klasifikasi')->index();
            $table->string('deskripsi')->nullable();
            $table->longText('body'); // berisi template Blade/placeholder
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates_surat');
    }
};
