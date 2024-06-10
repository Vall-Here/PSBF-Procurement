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
        // Define roles
        $roles = [
            'pengendali_gudang', 'pengendali_proc', 'pengendali_finansial',
            'kabag_proc', 'kasi_impor', 'kasi_lokal', 'kasi_intern',
            'pel_impor', 'pel_lokal', 'pel_intern', 'asset_staff'
        ];

        // Create roles
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        // Define permissions
        $permissions = [
            'manage_users', 'manage_products', // Tambahkan sesuai kebutuhan
        ];

        // Create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Assign permissions to roles (example)
        Role::findByName('kabag_proc')->givePermissionTo(['manage_users', 'manage_products']);
        // Tambahkan assign role dan permission lainnya sesuai dokumen

        // Create an admin user and assign role
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole('kabag_proc');
    }
}
