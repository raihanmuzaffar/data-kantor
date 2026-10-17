<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['super_admin', 'admin', 'manajer', 'karyawan'];
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        $permissions = [
            // User & role management
            'user.view', 'user.create', 'user.update', 'user.delete',
            'role.view', 'role.create', 'role.update', 'role.delete',

            // Divisi
            'divisi.view', 'divisi.create', 'divisi.update', 'divisi.delete',

            // Karyawan
            'karyawan.view', 'karyawan.create', 'karyawan.update', 'karyawan.delete',

            // Pengumuman
            'pengumuman.view', 'pengumuman.create', 'pengumuman.update', 'pengumuman.delete',

            // Dokumen (nanti dipakai)
            'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.delete',

            // Audit
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        Role::findByName('admin')->syncPermissions([
            'user.view',
            'divisi.view', 'divisi.create', 'divisi.update',
            'karyawan.view', 'karyawan.create', 'karyawan.update',
            'pengumuman.view', 'pengumuman.create', 'pengumuman.update', 'pengumuman.delete',
            'dokumen.view', 'dokumen.create', 'dokumen.update',
            'audit.view',
        ]);

        Role::findByName('manajer')->syncPermissions([
            'divisi.view',
            'karyawan.view',
            'pengumuman.view', 'pengumuman.create', 'pengumuman.update',
            'dokumen.view',
        ]);

        Role::findByName('karyawan')->syncPermissions([
            'divisi.view',
            'karyawan.view',
            'pengumuman.view',
            'dokumen.view',
        ]);
    }
}
