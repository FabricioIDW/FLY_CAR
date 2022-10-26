<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::resource('vehicles', VehicleController::class)->parameters(['vehicles' => 'vehicles'])->names('vehicles');
Route::resource('users', UserController::class)->only(['index', 'edit'])->middleware('can:admin.users.index')->names('admin.users');

Route::resource('vehicles', VehicleController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
