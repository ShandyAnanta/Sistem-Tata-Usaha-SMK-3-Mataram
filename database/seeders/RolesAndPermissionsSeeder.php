<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $tu   = Role::firstOrCreate(['name' => 'TU']);
        $hum  = Role::firstOrCreate(['name' => 'Humas']);
        $kur  = Role::firstOrCreate(['name' => 'Kurikulum']);

        // Sesuaikan email/ID di bawah dengan data nyata
        User::where('email','tu@example.com')->first()?->assignRole($tu);
        User::where('email','humas@example.com')->first()?->assignRole($hum);
        User::where('email','kurikulum@example.com')->first()?->assignRole($kur);
    }
}
