<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SuratKeluar extends Model
{
    use HasFactory;

    protected $table = 'surat_keluar';

    protected $fillable = [
        'tanggal_surat','nama_penerima','keterangan_surat','nomor_surat','file_path'
    ];
    
    public function template(): BelongsTo
    {
        return $this->belongsTo(TemplateSurat::class, 'template_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function approvals()
    {
        return $this->hasMany(\App\Models\Approval::class, 'surat_keluar_id', 'id');
    }
}
