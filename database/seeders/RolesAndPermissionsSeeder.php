<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
       
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define roles
        $roles = [
            'pengendali_gudang', 'pengendali_proc', 'pengendali_finansial',
            'kabag_proc', 'kasi_impor', 'kasi_lokal', 'kasi_intern',
            'pel_impor', 'pel_lokal', 'pel_intern', 'asset_staff'
        ];

        // Create roles if they do not exist
        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        // Define permissions
        $permissions = [
            'manage_users','manage_hak_akses', 'buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','review_rencana_pembelian','buat_rush_order','edit_rush_order','review_rush_order', 'manage_purchase_orders', 'manage_vendors', 'manage_budget' 
        ];

        // Create permissions if they do not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign permissions to roles
        Role::findByName('pengendali_gudang')->givePermissionTo(['review_rencana_pembelian','review_rush_order','edit_rush_order','edit_rencana_pembelian']);
        Role::findByName('pengendali_proc')->givePermissionTo(['review_rencana_pembelian','review_rush_order','edit_rush_order','edit_rencana_pembelian']);
        Role::findByName('pengendali_finansial')->givePermissionTo(['review_rencana_pembelian','review_rush_order']);
        Role::findByName('kabag_proc')->givePermissionTo(['manage_users', 'manage_hak_akses' ,'edit_rkb','edit_rencana_pembelian','edit_rush_order','manage_purchase_orders', 'manage_vendors']);
        Role::findByName('kasi_impor')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('kasi_lokal')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('kasi_intern')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('pel_lokal')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('pel_intern')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('pel_impor')->givePermissionTo(['buat_rkb', 'edit_rkb','hapus_rkb','buat_rencana_pembelian','edit_rencana_pembelian','buat_rush_order','edit_rush_order','manage_purchase_orders']);
        Role::findByName('asset_staff')->givePermissionTo(['buat_rush_order','edit_rush_order']);
        // Tambahkan assign role dan permission lainnya sesuai dokumen
        // Misalnya:
        // Role::findByName('pengendali_gudang')->givePermissionTo(['manage_products']);

        // Create an admin user and assign role
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('123'),
        ]);

        $admin->assignRole('kabag_proc');

        // Tambahkan user tambahan sesuai kebutuhan
        // $user = User::firstOrCreate([
        //     'email' => 'user@example.com',
        // ], [
        //     'name' => 'Regular User',
        //     'password' => Hash::make('password123'),
        // ]);
        // $user->assignRole('pengendali_gudang');
    }
}
