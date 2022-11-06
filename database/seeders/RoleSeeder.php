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

        // PERMISSIONS
        // Products
        // Permission::create(['name' => 'productos.buscar'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.store'])->syncRoles([$admin]); // Agregar
        Permission::create(['name' => 'productos_vehiculos.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos_accesorio.destroy'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.buscarVehiculos'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.buscarAccesorios'])->syncRoles([$admin]);
        Permission::create(['name' => 'productos.modelosPorMarca'])->syncRoles([$admin]);
        Permission::create(['name' => 'vehiculos.buscar'])->syncRoles([$admin]);
        Permission::create(['name' => 'vehiculos.editar'])->syncRoles([$admin]);
        Permission::create(['name' => 'vehiculos.actualizar'])->syncRoles([$admin]);
        Permission::create(['name' => 'vehiculos.baja'])->syncRoles([$admin]);
        Permission::create(['name' => 'accesorios.buscar'])->syncRoles([$admin]);
        Permission::create(['name' => 'accesorios.editar'])->syncRoles([$admin]);
        Permission::create(['name' => 'accesorios.actualizar'])->syncRoles([$admin]);
        Permission::create(['name' => 'accesorios.baja'])->syncRoles([$admin]);

        // Admin view
        Permission::create(['name' => 'admin.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.changeData'])->syncRoles([$admin]);
        Permission::create(['name' => 'admin.reports'])->syncRoles([$admin]);

        // Offers
        Permission::create(['name' => 'offers.index'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.edit'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.store'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.update'])->syncRoles([$admin]);
        Permission::create(['name' => 'offers.destroy'])->syncRoles([$admin]);

        // Payment
        Permission::create(['name' => 'payments.index'])->syncRoles([$seller, $admin, $customer]);
        Permission::create(['name' => 'payments.store'])->syncRoles([$seller, $admin, $customer]);

        // Quotations
        Permission::create(['name' => 'quotations.generarCotizacion'])->syncRoles([$seller, $customer]);
        Permission::create(['name' => 'quotations.generarCotizacionVendedor'])->syncRoles([$seller]);
        Permission::create(['name' => 'quotations.miCotizacion'])->syncRoles([$customer]);
        Permission::create(['name' => 'quotations.search'])->syncRoles([$seller]);
        Permission::create(['name' => 'quotations.searchQuotation'])->syncRoles([$seller]);
        Permission::create(['name' => 'quotations.seeQuotation'])->syncRoles([$seller]);

        // Reserve
        Permission::create(['name' => 'reserves.create'])->syncRoles([$customer, $seller]);

        // Sale
        Permission::create(['name' => 'sales.create'])->syncRoles([$seller]);

        // Users
        Permission::create(['name' => 'cuenta.actualizar'])->syncRoles([$admin, $seller, $customer]);
        // Customer
        Permission::create(['name' => 'usersCustomer.update'])->syncRoles([$customer]);
        // Seller
        Permission::create(['name' => 'usersSeller.update'])->syncRoles([$seller]);
        // Create seller account
        Permission::create(['name' => 'usersSeller.create'])->syncRoles([$admin]);
        Permission::create(['name' => 'usersSeller.store'])->syncRoles([$admin]);

        // Reports
        Permission::create(['name' => 'reportes.vehiculosMasCotizados'])->syncRoles([$admin]);
        Permission::create(['name' => 'reportes.ventasNoConcretadas'])->syncRoles([$admin]);
        Permission::create(['name' => 'reportes.accesoriosMasSolicitados'])->syncRoles([$admin]);
        Permission::create(['name' => 'reportes.comisionesMensuales'])->syncRoles([$admin]);
        Permission::create(['name' => 'reportes.modelosMasVendidos'])->syncRoles([$admin]);
        Permission::create(['name' => 'reportes.reporte'])->syncRoles([$admin]);
    }
}
