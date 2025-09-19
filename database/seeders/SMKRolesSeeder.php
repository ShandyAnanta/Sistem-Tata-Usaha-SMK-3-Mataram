<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;

class SMKRolesSeeder extends Seeder
{
    public function run(): void
    {
        // pastikan guard_name konsisten dengan guard login (web)
        $tu   = Role::firstOrCreate(['name' => 'TU', 'guard_name' => 'web']);
        $hum  = Role::firstOrCreate(['name' => 'Humas', 'guard_name' => 'web']);
        $kur  = Role::firstOrCreate(['name' => 'Kurikulum', 'guard_name' => 'web']);

        // contoh assign (sesuaikan email/ID nyata)
        User::where('email','tu@example.com')->first()?->syncRoles(['TU']);
        User::where('email','humas@example.com')->first()?->syncRoles(['Humas']);
        User::where('email','kurikulum@example.com')->first()?->syncRoles(['Kurikulum']);
    }
}
