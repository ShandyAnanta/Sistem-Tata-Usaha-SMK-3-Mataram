<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Approval extends Model
{
    use HasFactory;

    protected $table = 'approvals';

    protected $fillable = [
        'surat_keluar_id',
        'approver_id',
        'level',
        'status',
        'note',
        'decided_at',
    ];

    public function suratKeluar()
    {
        return $this->belongsTo(\App\Models\SuratKeluar::class, 'surat_keluar_id', 'id');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
