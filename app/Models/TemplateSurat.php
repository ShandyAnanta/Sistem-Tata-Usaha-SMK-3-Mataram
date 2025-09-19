<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'templates_surat';

    protected $fillable = [
        'nama',
        'kode_klasifikasi',
        'deskripsi',
        'body',
        'is_active',
    ];

    public function suratKeluar(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'template_id');
    }
}
