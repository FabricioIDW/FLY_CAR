<?php

use App\Http\Controllers\OfferController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReserveController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Home y redirección
Route::get('/dashboard', function () {
    return redirect()->route('productos.catalogo');
});
Route::get('/', function () {
    return redirect()->route('productos.catalogo');
})->name('home');
// Products
Route::controller(ProductController::class)->group(function () {
    Route::get('catalogo', 'catalogo')->name('productos.catalogo');
    // Vehicles
    Route::get('productos/buscarVehiculos', 'indexVehiculos')->name('vehiculos.buscar');
    Route::get('editarVehiculo/{vehiculo}', 'editVehicle')->name('vehiculos.editar');
    Route::put('vehiculo/{vehiculo}', 'updateVehicle')->name('vehiculos.actualizar');
    Route::get('productos/eliminarVehiculo/{vehiculo}', 'destroyVehicle')->name('vehiculos.baja');
    // Accessories
    Route::get('productos/buscarAccesorios', 'indexAccesorios')->name('accesorios.buscar');
    Route::get('editarAccesorio/{accesorio}', 'editAccesory')->name('accesorios.editar');
    Route::put('accesorio/{accesorio}', 'updateAccesory')->name('accesorios.actualizar');
    Route::get('productos/eliminarAccesorio/{accesorio}', 'destroyAccesory')->name('accesorios.baja');
    // Models
    Route::get('modelsByBrand', 'modelsBrand')->name('productos.modelosPorMarca');
    // Products
    Route::get('productos/crear', 'create')->name('productos.create');
    Route::post('productos', 'store')->name('productos.store');
    Route::get('productos/buscar/productos/{id}', 'destroy_vehicle')->name('productos.destroy');
});
// Vista admin
Route::controller(UserController::class)->group(function () {
    Route::get('administracion', 'indexAdmin')->name('admin.index');
});
Route::controller(ReportController::class)->group(function () {
    Route::get('/reportes', 'reports')->name('admin.reports');
});

// Offers
Route::controller(OfferController::class)->group(function () {
    Route::get('/ofertas', 'index')->name('offers.index');
    Route::get('/crearOferta', 'create')->name('offers.create');
    Route::get('/editarOferta/{offer}', 'edit')->name('offers.edit');
    Route::post('/ofertas', 'store')->name('offers.store');
    Route::put('/ofertas/{offer}', 'update')->name('offers.update');
    Route::get('/ofertas/{offer}', 'destroy')->name('offers.destroy');
});
// Payment
Route::controller(PaymentController::class)->group(function () {
    Route::get('/pago/{action}/{amount}', 'index')->name('payments.index');
    Route::post('/pago', 'store')->name('payments.store');
});
// Quotations
Route::controller(QuotationController::class)->group(function () {
    Route::get('/cotizacion/{vehiculo}', 'simularCotizacion')->name('quotations.simularCotizacion');
    Route::post('/cotizacion', 'agregarOtroVehiculo')->name('quotations.cotizar');
    Route::get('/generarCotizacion', 'generarCotizacion')->name('quotations.generarCotizacion');
    Route::get('/generarCotizacionVendedor', 'generarCotizacionVendedor')->name('quotations.generarCotizacionVendedor');
    Route::get('/miCotizacion', 'miCotizacion')->name('quotations.miCotizacion');
    // Route::get('/buscarCotizacion', 'buscarCotizacion')->middleware('can:quotations.search')->name('quotations.search');
    Route::get('/verCotizacion/{quotation}/', 'mostrarQuotation')->name('quotations.seeQuotation');
    Route::post('/miCotizacion/{quotation}', 'generateQuotationPDF')->name('quotations.generatePDF');
});
Route::get('/buscarCotizaciones', function () {
    return view('quotations.searchQuotation');
})->middleware('can:quotations.searchQuotation')->name('quotations.searchQuotation');
// Reserve
Route::controller(ReserveController::class)->group(function () {
    Route::get('/reserva', 'create')->name('reserves.create');
});
// Sale
Route::controller(SaleController::class)->group(function () {
    Route::get('/venta/{concretized}', 'create')->name('sales.create');
});
// User
Route::controller(UserController::class)->group(function () {
    Route::get('/cuenta', 'actualizarCuenta')->name('cuenta.actualizar');
    // Customer
    Route::get('/crearCuenta', 'index')->name('usersCustomer.index');
    Route::get('/crearCuenta/nuevoCliente', 'create_new_customer')->name('usersCustomer.createNew');
    Route::get('/crearCuenta/clienteExistente', 'create_existing_customer')->name('usersCustomer.createExisting');
    Route::post('/crearCuenta/nuevoCliente', 'store_new_customer')->name('usersCustomer.storeNew');
    Route::post('/crearCuenta/clienteExistente', 'store_existing_customer')->name('usersCustomer.storeExisting');
    Route::put('/perfil/actualizarCliente', 'update_customer')->name('usersCustomer.update');
    // Seller
    Route::get('/crearCuenta/vendedor', 'create_seller')->name('usersSeller.create');
    Route::post('/crearCuenta/vendedor', 'store_seller')->name('usersSeller.store');
    Route::put('/perfil/actualizarVendedor', 'update_seller')->name('usersSeller.update');
});
