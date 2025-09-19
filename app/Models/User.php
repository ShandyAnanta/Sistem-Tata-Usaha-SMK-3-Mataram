<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\HasMany;

// Import model relasi
use App\Models\Disposisi;
use App\Models\SuratKeluar;

/**
 * App\Models\User
 *
 * Model user dengan dukungan role/permission dari Spatie (HasRoles).
 * Pastikan tabel roles/permissions sudah dimigrasikan dan guard sesuai.
 *
 * @property string $guard_name
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Guard default untuk Spatie Permission (opsional bila default sudah 'web').
     * Hapus baris ini jika tidak diperlukan.
     *
     * @var string
     */
    protected $guard_name = 'web';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    // Relasi utilitas opsional
    public function disposisiDiterima(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'penerima_id');
    }

    public function disposisiDikirim(): HasMany
    {
        return $this->hasMany(Disposisi::class, 'pengirim_id');
    }

    public function suratKeluarDibuat(): HasMany
    {
        return $this->hasMany(SuratKeluar::class, 'creator_id');
    }
}
