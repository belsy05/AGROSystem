<?php

use App\Http\Controllers\CargoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
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
});

/********************************* PERSONAL *********************************/

Route::get('/personals', [PersonalController::class, 'index'])
->name('personal.index');

Route::get('/personals/buscar', [PersonalController::class, 'index2'])
->name('personal.index2');

Route::get('/personals/{id}', [PersonalController::class, 'show'])
->name('personal.mostrar')->where('id', '[0-9]+');

Route::get('/personals/crear', [PersonalController::class, 'crear'])
->name('personal.crear');

Route::post('/personals/crear', [PersonalController::class, 'store'])
->name('personal.guardar');

Route::get('/personals/{id}/editar', [PersonalController::class, 'edit'])
->name('personal.edit')->where('id', '[0-9]+');

Route::put('/personals/{id}/editar', [PersonalController::class, 'update'])
->name('personal.update')->where('id', '[0-9]+');

Route::get('/estado/{id}', [PersonalController::class, 'updateStatus'])
 ->name('status.update')->where('id', '[0-9]+');


/********************************* CARGO *********************************/

Route::get('/cargos', [CargoController::class, 'index'])
->name('cargo.index');

Route::get('/cargos2', [CargoController::class, 'index2'])
->name('cargo.index2');

//ruta para crear
Route::get('/cargos/crear', [CargoController::class, 'crear'])
->name('cargo.crear');

//ruta para postear
Route::post('/cargos/crear', [CargoController::class, 'store'])
->name('cargo.guardar');

//ruta para mostrar formulario
Route::get('/cargos/{id}/editar', [CargoController::class, 'edit'])
->name('cargo.edit')->where('id', '[0-9]+');

//para actualizar los datos
Route::put('/cargos/{id}/editar', [CargoController::class, 'update'])
->name('cargo.update')->where('id', '[0-9]+');



/********************************* PROVEEDOR *********************************/

Route::get('/proveedors', [ProveedorController::class, 'index'])
->name('proveedor.index');

Route::get('/proveedors/buscar', [ProveedorController::class, 'index2'])
->name('proveedor.index2');

Route::get('/proveedors/crear', [ProveedorController::class, 'crear'])
->name('proveedor.crear');

Route::post('/proveedors/crear', [ProveedorController::class, 'store'])
->name('proveedor.guardar');

Route::get('/proveedors/{id}', [ProveedorController::class, 'show'])
->name('proveedor.mostrar')->where('id', '[0-9]+');

Route::get('/proveedors/{id}/editar', [ProveedorController::class, 'edit'])
->name('proveedor.edit')->where('id', '[0-9]+');

Route::put('/proveedors/{id}/editar', [ProveedorController::class, 'update'])
->name('proveedor.update')->where('id', '[0-9]+');


/********************************* CLIENTE *********************************/

Route::get('/clientes', [ClienteController::class, 'index'])
->name('cliente.index');

Route::get('/clientes/buscar', [ClienteController::class, 'index2'])
->name('cliente.index2');

Route::get('/clientes/{id}', [ClienteController::class, 'show'])
->name('cliente.mostrar')->where('id', '[0-9]+');

Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])
->name('cliente.edit')->where('id', '[0-9]+');

Route::put('/clientes/{id}/editar', [ClienteController::class, 'update'])
->name('cliente.update')->where('id', '[0-9]+');

Route::get('/clientes/crear', [ClienteController::class, 'crear'])
->name('cliente.crear');

Route::post('/clientes/guardar', [ClienteController::class, 'store'])
->name('cliente.guardar');

/********************************* CATEGORIA *********************************/

Route::get('/categorias/crear', [CategoriaController::class, 'crear'])
->name('categoria.crear');

Route::post('/categorias/crear', [CategoriaController::class, 'store'])
->name('categoria.guardar');

/********************************* PRODUCTO *********************************/

Route::get('/productos', [ProductoController::class, 'index'])
->name('producto.index');

Route::get('/productos/crear', [ProductoController::class, 'crear'])
->name('producto.crear');

Route::post('/productos/crear', [ProductoController::class, 'store'])
->name('producto.guardar');
