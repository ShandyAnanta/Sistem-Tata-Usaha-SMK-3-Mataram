<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        $permissions = [
            'surat-masuk.view', 'surat-masuk.create', 'surat-masuk.update', 'surat-masuk.delete',
            'disposisi.create', 'disposisi.view',
            'surat-keluar.view', 'surat-keluar.create', 'surat-keluar.update', 'surat-keluar.delete',
            'surat-keluar.submit', 'surat-keluar.approve',
            'laporan.view',
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['name' => $p, 'guard_name' => $guard]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);
        $kepsek = Role::firstOrCreate(['name' => 'kepala_sekolah', 'guard_name' => $guard]);
        $kajur  = Role::firstOrCreate(['name' => 'kepala_jurusan', 'guard_name' => $guard]);
        $guru   = Role::firstOrCreate(['name' => 'guru', 'guard_name' => $guard]);

        $admin->syncPermissions($permissions);
        $kepsek->syncPermissions([
            'surat-masuk.view', 'disposisi.create', 'disposisi.view',
            'surat-keluar.view', 'surat-keluar.approve', 'laporan.view',
        ]);
        $kajur->syncPermissions([
            'surat-masuk.view', 'disposisi.view',
            'surat-keluar.view', 'surat-keluar.create', 'surat-keluar.update',
            'surat-keluar.submit', 'surat-keluar.approve',
        ]);
        $guru->syncPermissions([
            'surat-keluar.view', 'surat-keluar.create', 'surat-keluar.update', 'surat-keluar.submit',
        ]);

        $uAdmin = User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin TU',
            'password' => Hash::make('password'),
        ]);
        $uAdmin->assignRole('admin');

        $uKepsek = User::firstOrCreate(['email' => 'kepsek@example.com'], [
            'name' => 'Kepala Sekolah',
            'password' => Hash::make('password'),
        ]);
        $uKepsek->assignRole('kepala_sekolah');

        $uKajur = User::firstOrCreate(['email' => 'kajur@example.com'], [
            'name' => 'Kepala Jurusan',
            'password' => Hash::make('password'),
        ]);
        $uKajur->assignRole('kepala_jurusan');

        $uGuru = User::firstOrCreate(['email' => 'guru@example.com'], [
            'name' => 'Guru',
            'password' => Hash::make('password'),
        ]);
        $uGuru->assignRole('guru');

        $this->call(RolesAndPermissionsSeeder::class);
    }
}
