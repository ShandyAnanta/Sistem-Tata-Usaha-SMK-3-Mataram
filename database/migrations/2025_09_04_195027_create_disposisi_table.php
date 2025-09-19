<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_masuk_id')->constrained('surat_masuk')->cascadeOnDelete();
            $table->foreignId('pengirim_id')->constrained('users')->cascadeOnDelete();  // yang membuat disposisi
            $table->foreignId('penerima_id')->constrained('users')->cascadeOnDelete(); // penerima disposisi
            $table->text('instruksi')->nullable();
            // Status: terkirim, dibaca, ditindaklanjuti, selesai
            $table->string('status')->default('terkirim')->index();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();

            $table->index(['surat_masuk_id', 'penerima_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disposisi');
    }
};
