<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keluar_id')->constrained('surat_keluar')->cascadeOnDelete();
            $table->foreignId('approver_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('level')->default(1)->index(); // 1=Kajur, 2=Kepsek
            // Status: pending, approved, rejected, revisi
            $table->string('status')->default('pending')->index();
            $table->text('note')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->timestamps();

            $table->index(['surat_keluar_id', 'approver_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
