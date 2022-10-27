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
        // ROLES
        $admin = Role::create(['name' => 'Admin']);
        $customer = Role::create(['name' => 'Customer']);
        $seller = Role::create(['name' => 'Seller']);

        // Permission::create(['name' => 'home'])->syncRoles([$role1, $role2]);

        // PERMISSIONS
        // Products
        Permission::create(['name' => 'productos.buscar'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos_vehiculos.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos_accesorio.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.buscarVehiculos'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.buscarAccesorios'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.modelosPorMarca'])->syncRoles([$admin]);

        // Admin view
        Permission::create(['name' => 'admin.index'])->syncRoles([$admin]);

        // Offers
        Permission::create(['name' => 'offers.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.destroy'])->syncRoles([$admin]);

        // Payment
        Permission::create(['name' => 'payments.index'])->syncRoles([$seller, $admin, $customer]);
        Permission::create(['name' => 'paymets.store'])->syncRoles([$seller, $admin, $customer]);

        // Quotations
        Permission::create(['name' => 'quotations.simularCotizacion'])->syncRoles([$seller, $customer]);
        Permission::create(['name' => 'quotations.cotizar'])->syncRoles([$seller, $customer]);
        Permission::create(['name' => 'quotations.miCotizacion'])->syncRoles([$customer]);
        Permission::create(['name' => 'quotations.search'])->syncRoles([$seller]);

        // Reserve
        Permission::create(['name' => 'reserves.create'])->syncRoles([$customer, $seller]);

        // Sale
        Permission::create(['name' => 'sales.create'])->syncRoles([$seller]);

        // Create seller account
        Permission::create(['name' => 'usersSeller.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'usersSeller.store'])->syncRoles([$admin]);

        // DE PRUEBA
        // Users
        Permission::create(['name' => 'admin.users.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.users.edit'])->syncRoles([$admin]);
        // Vehicles 
        Permission::create(['name' => 'vehicles.index'])->assignRole($admin, $customer);
        Permission::create(['name' => 'vehicles.create'])->assignRole($admin);
        Permission::create(['name' => 'vehicles.edit'])->assignRole($admin);
        Permission::create(['name' => 'vehicles.destroy'])->assignRole($admin);
    }
}
