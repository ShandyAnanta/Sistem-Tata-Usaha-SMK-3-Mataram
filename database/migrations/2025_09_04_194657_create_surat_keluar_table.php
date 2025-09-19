<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            // Relasi ke template (opsional jika surat kadang tidak pakai template)
            $table->foreignId('template_id')->nullable()->constrained('templates_surat')->nullOnDelete();
            // Pembuat draf surat
            $table->foreignId('creator_id')->constrained('users')->cascadeOnDelete();
            // Nomor resmi (diisi saat approved)
            $table->string('nomor_surat')->unique()->nullable();
            // Metadata surat
            $table->date('tanggal_surat')->nullable();
            $table->string('perihal');
            $table->string('tujuan'); // penerima utama/pihak luar
            $table->longText('body'); // konten hasil render template + data
            // Status workflow: draft, pending_kajur, pending_kepsek, approved, rejected
            $table->string('status')->default('draft')->index();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();

            $table->index('tanggal_surat');
            $table->index('creator_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_keluar');
    }
};
