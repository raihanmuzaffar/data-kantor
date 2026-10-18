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

            // Dokumen & Kategori
            'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.delete',
            'dokumen_category.view', 'dokumen_category.create', 'dokumen_category.update', 'dokumen_category.delete',

            // CUTI
            'cuti.view', 'cuti.create', 'cuti.update', 'cuti.delete', 'cuti.approve',

            // ASET
            'aset.view', 'aset.create', 'aset.update', 'aset.delete',

            // ABSENSI
            'absensi.view', 'absensi.create', 'absensi.update', 'absensi.delete',

            // REIMBURSE
            'reimburse.view', 'reimburse.create', 'reimburse.update', 'reimburse.delete', 'reimburse.approve',

            // Audit
            'audit.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Super admin otomatis bypass via Gate::before

        Role::findByName('admin')->syncPermissions([
            'user.view',
            'divisi.view', 'divisi.create', 'divisi.update',
            'karyawan.view', 'karyawan.create', 'karyawan.update',
            'pengumuman.view', 'pengumuman.create', 'pengumuman.update', 'pengumuman.delete',
            'dokumen.view', 'dokumen.create', 'dokumen.update', 'dokumen.delete',
            'dokumen_category.view', 'dokumen_category.create', 'dokumen_category.update', 'dokumen_category.delete',
            'cuti.view', 'cuti.create', 'cuti.update', 'cuti.delete', 'cuti.approve',
            'aset.view', 'aset.create', 'aset.update', 'aset.delete',
            'absensi.view', 'absensi.create', 'absensi.update', 'absensi.delete',
            'reimburse.view', 'reimburse.create', 'reimburse.update', 'reimburse.delete', 'reimburse.approve',
            'audit.view',
        ]);

        Role::findByName('manajer')->syncPermissions([
            'divisi.view',
            'karyawan.view',
            'pengumuman.view', 'pengumuman.create', 'pengumuman.update',
            'dokumen.view', 'dokumen_category.view',
            'cuti.view', 'cuti.approve',
            'aset.view',
            'absensi.view', 'absensi.create',
            'reimburse.view', 'reimburse.approve',
        ]);

        Role::findByName('karyawan')->syncPermissions([
            'divisi.view',
            'karyawan.view',
            'pengumuman.view',
            'dokumen.view', 'dokumen_category.view',
            'cuti.view', 'cuti.create',
            'aset.view',
            'absensi.view', 'absensi.create',
            'reimburse.view', 'reimburse.create', 'reimburse.update',
        ]);
    }
}
