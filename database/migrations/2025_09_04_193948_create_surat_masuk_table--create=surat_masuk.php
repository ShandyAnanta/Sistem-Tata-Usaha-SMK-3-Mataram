<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->nullable();
            $table->date('tanggal');
            $table->string('pengirim');
            $table->string('perihal');
            $table->string('file_path')->nullable();
            $table->string('agenda_number')->unique();
            $table->string('status')->default('baru');
            $table->timestamps();

            $table->index('tanggal');
            $table->index('pengirim');
            $table->index('perihal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_masuk');
    }
};
