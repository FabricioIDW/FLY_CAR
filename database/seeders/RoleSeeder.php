<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Admin']);
        $role2 = Role::create(['name' => 'Customer']);

        // Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'admin.users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$role1]);


        Permission::create(['name' => 'vehicles.index'])->assignRole($role1, $role2);
        Permission::create(['name' => 'vehicles.create'])->assignRole($role1);
        Permission::create(['name' => 'vehicles.edit'])->assignRole($role1);
        Permission::create(['name' => 'vehicles.destroy'])->assignRole($role1);
    }
}
