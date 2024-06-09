<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Warehouse Controller']);
        Role::create(['name' => 'Procurement Controller']);
        Role::create(['name' => 'Financial Controller']);
    }
}

