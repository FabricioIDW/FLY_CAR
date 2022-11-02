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
    Route::get('productos/buscarVehiculos', 'indexVehiculos')->name('vehiculos.buscar');
    Route::get('products/searchAccesories', 'indexAccesorios')->name('accesorios.buscar');

    Route::get('busquedaV', 'searchV')->name('productos.buscarVehiculos');
    Route::get('busquedaA', 'searchA')->name('productos.buscarAccesorios');

    Route::get('vehicleEdit/{vehiculo}', 'editVehicle')->name('vehiculos.editar');
    Route::get('accessoryEdit/{accesorio}', 'editAccesory')->name('accesorios.editar');

    Route::put('vehicle/{vehiculo}', 'updateVehicle')->name('vehiculos.actualizar');
    Route::put('accesory/{accesorio}', 'updateAccesory')->name('accesorios.actualizar');

    Route::get('products/vehicleDown/{vehiculo}', 'destroyVehicle')->name('vehiculos.baja');
    Route::get('products/accessoryDown/{accesorio}', 'destroyAccesory')->name('accesorios.baja');

    Route::get('modelsByBrand', 'modelsBrand')->name('productos.modelosPorMarca');


    Route::get('products/create', 'create')->name('productos.create');

    Route::post('products', 'store')->name('productos.store');

    Route::get('products/search/products/{id}', 'destroy_vehicle')->name('productos.destroy');
});
// Vista admin
Route::controller(UserController::class)->group(function () {
    Route::get('indexAdmin', 'indexAdmin')->name('admin.index');
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
    Route::get('/cotizacion/{quotation}', 'show')->name('quotations.show');
    Route::get('/quotation/{vehiculo}', 'simularCotizacion')->name('quotations.simularCotizacion');
    Route::post('/cotizacion', 'agregarOtroVehiculo')->name('quotations.cotizar');
    Route::get('/generarCotizacion', 'generarCotizacion')->name('quotations.generarCotizacion');
    Route::get('/miCotizacion', 'miCotizacion')->name('quotations.miCotizacion');
    Route::get('/buscarCotizacion', 'buscarCotizacion')->name('quotations.search');
});
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
    // Route::get('/users', 'userList')->middleware('can:admin.users.index')->name('admin.users.index'); //Probando middleware
    // Route::get('/users/{user}', 'userEdit')->middleware('can:admin.users.edit')->name('admin.users.edit'); //Probando middleware
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

// Reports
Route::controller(ReportController::class)->group(function () {
    Route::post('/reportes/vehiculosMasCotizados', 'vehiculosMasCotizados')->name('reportes.vehiculosMasCotizados');
    Route::post('/reportes/ventasNoConcretadas', 'ventasNoConcretadas')->name('reportes.ventasNoConcretadas');
    Route::post('/reportes/accesoriosMasSolicitados', 'accesoriosMasSolicitados')->name('reportes.accesoriosMasSolicitados');
    Route::post('/estadisticas/comisionesMensuales', 'comisionesMensuales')->name('estadisticas.comisionesMensuales');
    Route::post('/estadisticas/modelosMasVendidos', 'modelosMasVendidos')->name('estadisticas.modelosMasVendidos');
    Route::post('/reporte', 'reporte')->name('reportes.reporte');
});

Route::controller(PDFController::class)->group(function () {
    Route::get('/generate-pdf', 'generatePDF')->name('reportes.generarPDF');
});

// Route::middleware([
//     'auth:sanctum',
//     config('jetstream.auth_session'),
//     'verified'
// ])->group(function () {
//     Route::get('/', function () {
//         return redirect()->route('productos.catalogo');
//     })->name('home');
// });
