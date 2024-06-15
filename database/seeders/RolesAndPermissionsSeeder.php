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
            Role::firstOrCreate(['name' => $role]);
        }

        // Define permissions
        $permissions = [
            'manage_users','manage_hak_akses', 'manage_products', 'buat_rkb', 'edit_rkb','hapus_rkb','rencana_pembelian', 'manage_purchase_orders', 'manage_vendors', 'manage_assets' 
        ];

        // Create permissions if they do not exist
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assign permissions to roles
        Role::findByName('kabag_proc')->givePermissionTo(['manage_users', 'manage_products']);
        // Tambahkan assign role dan permission lainnya sesuai dokumen
        // Misalnya:
        // Role::findByName('pengendali_gudang')->givePermissionTo(['manage_products']);

        // Create an admin user and assign role
        $admin = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin User',
            'password' => Hash::make('password123'),
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
