<?php

use App\Http\Controllers\PersonalController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DetalleCompraController;
use App\Http\Controllers\DetallesCotizacionController;
use App\Http\Controllers\DetalleVentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\InventarioController;
use App\Http\Controllers\PedidosClientesController;
use App\Http\Controllers\RangoController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\DetallesPedidosClientesController;
use App\Http\Controllers\DetallesPedidosProductosNuevosController;
use App\Http\Controllers\DetallesPedidosProveedorController;
use App\Http\Controllers\FacturasVencerController;
use App\Http\Controllers\PedidosProductosNuevosController;
use App\Http\Controllers\PedidosProveedorController;
use App\Http\Controllers\ProductosVencerController;
use App\Http\Controllers\ServicioController;
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

Route::get('/cargos/crear', [CargoController::class, 'crear'])
->name('cargo.crear');

Route::post('/cargos/crear', [CargoController::class, 'store'])
->name('cargo.guardar');

Route::get('/cargos/{id}/editar', [CargoController::class, 'edit'])
->name('cargo.edit')->where('id', '[0-9]+');

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

Route::get('/proveedors/crear2', [ProveedorController::class, 'crear2'])
->name('proveedor.crear2');

Route::post('/proveedors/crear2', [ProveedorController::class, 'store2'])
->name('proveedor.guardar2');

Route::get('/proveedors/crear3', [ProveedorController::class, 'crear3'])
->name('proveedor.crear3');

Route::post('/proveedors/crear3', [ProveedorController::class, 'store3'])
->name('proveedor.guardar3');

Route::get('/proveedors/{id}', [ProveedorController::class, 'show'])
->name('proveedor.mostrar')->where('id', '[0-9]+');

Route::get('/proveedors/{id}/editar', [ProveedorController::class, 'edit'])
->name('proveedor.edit')->where('id', '[0-9]+');

Route::put('/proveedors/{id}/editar', [ProveedorController::class, 'update'])
->name('proveedor.update')->where('id', '[0-9]+');


/********************************* CLIENTE *********************************/

Route::get('/clientes', [ClienteController::class, 'index'])
->name('cliente.index');

Route::get('/clientes/buscar', [clienteController::class, 'index2'])
->name('cliente.index2');

Route::get('/clientes/crear', [ClienteController::class, 'crear'])
->name('cliente.crear');

Route::post('/clientes/guardar', [ClienteController::class, 'store'])
->name('cliente.guardar');

Route::get('/clientes/crear2', [ClienteController::class, 'crear2'])
->name('cliente.crear2');

Route::post('/clientes/guardar2', [ClienteController::class, 'store2'])
->name('cliente.guardar2');

Route::get('/clientes/crear3', [ClienteController::class, 'crear3'])
->name('cliente.crear3');

Route::post('/clientes/guardar3', [ClienteController::class, 'store3'])
->name('cliente.guardar3');

Route::get('/clientes/crear4', [ClienteController::class, 'crear4'])
->name('cliente.crear4');

Route::post('/clientes/guardar4', [ClienteController::class, 'store4'])
->name('cliente.guardar4');

Route::get('/clientes/{id}', [ClienteController::class, 'show'])
->name('cliente.mostrar')->where('id', '[0-9]+');

Route::get('/clientes/{id}/edit', [ClienteController::class, 'edit'])
->name('cliente.edit')->where('id', '[0-9]+');

Route::put('/clientes/{id}/editar', [ClienteController::class, 'update'])
->name('cliente.update')->where('id', '[0-9]+');


/********************************* CATEGORIAS *********************************/

Route::get('/categorias', [CategoriaController::class, 'index'])
->name('categoria.index');

Route::get('/categorias/buscar', [CategoriaController::class, 'index2'])
->name('categoria.index2');

Route::get('/categorias/crear', [CategoriaController::class, 'crear'])
->name('categoria.crear');

Route::post('/categorias/guardar', [CategoriaController::class, 'store'])
->name('categoria.guardar');

Route::get('/categorias/crear2', [CategoriaController::class, 'crear2'])
->name('categoria.crear2');

Route::post('/categorias/guardar2', [CategoriaController::class, 'store2'])
->name('categoria.guardar2');

Route::get('/categorias/{id}/editar', [CategoriaController::class, 'edit'])
->name('categoria.edit')->where('id', '[0-9]+');

Route::put('/categorias/{id}/editar', [CategoriaController::class, 'update'])
->name('categoria.update')->where('id', '[0-9]+');


/********************************* PRODUCTOS *********************************/

Route::get('/productos', [ProductoController::class, 'index'])
->name('producto.index');

Route::get('/productos/buscar', [ProductoController::class, 'index2'])
->name('producto.index2');

Route::get('/productos/crear', [ProductoController::class, 'crear'])
->name('producto.crear');

Route::post('/productos/crear', [ProductoController::class, 'store'])
->name('producto.guardar');

Route::get('/productos/crear2', [ProductoController::class, 'crear2'])
->name('producto.crear2');

Route::post('/productos/crear2', [ProductoController::class, 'store2'])
->name('producto.guardar2');

Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])
->name('producto.edit')->where('id', '[0-9]+');

Route::put('/productos/{id}/editar', [ProductoController::class, 'update'])
->name('producto.update')->where('id', '[0-9]+');

Route::get('/productos/{id}', [ProductoController::class, 'show'])
->name('producto.mostrar')->where('id', '[0-9]+');


/********************************* COMPRAS y REPORTE *********************************/

Route::get('/compras/crear',[CompraController::class, 'create'])
->name('compras.crear');

Route::get('/compras/limpiar',[CompraController::class, 'limpiar'])
->name('compras.limpir');

Route::get('/compras', [CompraController::class, 'index'])
->name('compras.index');

Route::get('/compras/reporte', [CompraController::class, 'reporte'])
->name('compras.reporte');

Route::get('/compras/{id}', [CompraController::class, 'show'])
->name('compras.mostrar');

Route::get('/compras2/{id}', [CompraController::class, 'show2'])
->name('compra.mostrar');

Route::post('/compras/guardar', [CompraController::class, 'store'])
->name('compras.guardar');

Route::get('/compras/pdf/{anio1}/{anio2}/{proveeforR}', [CompraController::class, 'pdf'])
->name('compras.pdf');


/******************************* DETALLE COMPRAS *******************************/

Route::post('/detalle_compra/agregar', [DetalleCompraController::class, 'agregar_detalle'])
->name('detalle_compra.crear');

Route::get('/detalle_compra/eliminar/{DetalleCompra}', [DetalleCompraController::class, 'destroy'])
->name('detalle_compra.eliminar');

Route::post('/detalle_compra/editar', [DetalleCompraController::class, 'agregar_detalle_edit'])
->name('detalle_compra.editar');


/********************************* INVENTARIO *********************************/

Route::get('/inventario', [InventarioController::class, 'index'])
->name('inventario.index');

Route::get('/inventario/buscar', [InventarioController::class, 'index2'])
->name('inventario.index2');

Route::get('/inventario/precios/{id}/{presentacion}', [InventarioController::class, 'precios'])
->name('inventario.precio')->where('id', '[0-9]+');

Route::get('/inventario/detalles/{id}/{presentacion}', [InventarioController::class, 'detalles'])
->name('inventario.detalle')->where('id', '[0-9]+');


/********************************* VENTAS *********************************/

Route::get('/ventas/crear/{clientepedido}',[VentaController::class, 'create'])
->name('ventas.crear');

Route::get('/ventas/limpiar/{cliente}',[VentaController::class, 'limpiar'])
->name('ventas.limpir');

Route::post('/ventas/guardar', [VentaController::class, 'store'])
->name('ventas.guardar');

Route::get('/ventas', [VentaController::class, 'index'])
->name('ventas.index');

Route::get('/ventas/reporte', [VentaController::class, 'reporte'])
->name('ventas.reporte');

Route::get('/ventas/{id}', [VentaController::class, 'show'])
->name('ventas.mostrar');

Route::get('/ventas/pdf/{anio1}/{anio2}/{clientes?}/{empleados}', [VentaController::class, 'pdf'])
->name('ventas.pdf');


/******************************* DETALLE VENTAS *******************************/

Route::post('/detalle_venta/agregar', [DetalleVentaController::class, 'agregar_detalle'])
->name('detalle_venta.crear');

Route::get('/detalle_venta/eliminar/{DetalleCompra}/{cliente}', [DetalleVentaController::class, 'destroy'])
->name('detalle_venta.eliminar');

Route::post('/detalle_venta/editar', [DetalleVentaController::class, 'agregar_detalle_edit'])
->name('detalle_venta.editar');

Route::post('/rango/agregar', [RangoController::class, 'agregar_detalle'])
->name('rango.crear');


/******************************* PEDIDOS CLIENTES *******************************/

Route::get('/pedidosClientes', [PedidosClientesController::class, 'index'])
->name('pedidosCliente.index');

Route::get('/pedidosClientes/detalle/{id}', [PedidosClientesController::class, 'show'])
->name('pedidosCliente.show');

Route::get('/pedidosClientes/crear', [PedidosClientesController::class, 'create'])
->name('pedidosCliente.crear');

Route::post('/pedidos/crear', [PedidosClientesController::class, 'store'])
->name('pedidosCliente.guardar');

Route::get('/pedidosCliente/limpiar',[PedidosClientesController::class, 'limpiar'])
->name('pedidosCliente.limpiar');

Route::get('/estadoP/{id}', [PedidosClientesController::class, 'updateStatus'])
 ->name('status.update')->where('id', '[0-9]+');

Route::get('/destroy/{id}', [PedidosClientesController::class, 'eliminar'])
->name('status.destroy')->where('id', '[0-9]+');


/******************************* DETALLE PEDIDO CLIENTES *******************************/

Route::post('/detalle_pedidosCliente/agregar', [DetallesPedidosClientesController::class, 'agregar_detalle'])
->name('detalle_pedidosCliente.crear');

Route::get('/detalle_pedidosCliente/eliminar/{DetalleCompra}', [DetallesPedidosClientesController::class, 'destroy'])
->name('detalle_pedidosCliente.eliminar');

Route::post('/detalle_pedidosCliente/editar', [DetallesPedidosClientesController::class, 'agregar_detalle_edit'])
->name('detalle_pedidosCliente.editar');


/******************************* PEDIDOS PRODUCTOS NUEVOS CLIENTES *******************************/

Route::get('/pedidosProductoNuevoClientes', [PedidosProductosNuevosController::class, 'index'])
->name('pedidosClienteP.index');

Route::get('/pedidosProductoNuevoClientes/detalle/{id}', [PedidosProductosNuevosController::class, 'show'])
->name('pedidosClienteP.show');

Route::get('/pedidosProductoNuevoClientes/crear', [PedidosProductosNuevosController::class, 'create'])
->name('pedidosClienteP.crear');

Route::post('/pedidosProductoNuevo/crear', [PedidosProductosNuevosController::class, 'store'])
->name('pedidosClienteP.guardar');

Route::get('/pedidosProductoNuevoCliente/limpiar',[PedidosProductosNuevosController::class, 'limpiar'])
->name('pedidosClienteP.limpiar');

Route::get('/estadoPPN/{id}', [PedidosProductosNuevosController::class, 'updateStatus'])
 ->name('status.update')->where('id', '[0-9]+');


/******************************* DETALLE PEDIDO PRODUCTOS NUEVOS CLIENTES *******************************/

Route::post('/detalle_pedidosProductoNuevoCliente/agregar', [DetallesPedidosProductosNuevosController::class, 'agregar_detalle'])
->name('detalle_pedidosClienteP.crear');

Route::get('/detalle_pedidosProductoNuevoCliente/eliminar/{Detallepedido}', [DetallesPedidosProductosNuevosController::class, 'destroy'])
->name('detalle_pedidosClienteP.eliminar');

Route::post('/detalle_pedidosProductoNuevoCliente/editar', [DetallesPedidosProductosNuevosController::class, 'agregar_detalle_edit'])
->name('detalle_pedidoP.editar');


/******************************* FACTURAS PROXIMAS A VENCER *******************************/

Route::get('/compra', [FacturasVencerController::class, 'index'])
->name('compra.index');

Route::get('/compra/reporte', [FacturasVencerController::class, 'reporte'])
->name('compra.reporte');


/******************************* PRODUCTOS PROXIMOS A VENCER *******************************/

Route::get('/Inventarios', [ProductosVencerController::class, 'index'])
->name('Inventarios.index');

Route::get('/Inventarios/buscar', [ProductosVencerController::class, 'index2'])
->name('Inventarios.index2');


/******************************* COTIZACIONES Y DETALLES DE LAS COTIZACIONES *******************************/

Route::get('/cotizaciones/crear',[CotizacionController::class, 'create'])
->name('cotizaciones.crear');

Route::post('/cotizaciones/guardar', [CotizacionController::class, 'store'])
->name('cotizaciones.guardar');

Route::get('/cotizaciones/limpiar',[CotizacionController::class, 'limpiar'])
->name('cotizaciones.limpir');

Route::get('/cotizaciones/{id}', [CotizacionController::class, 'show'])
->name('cotizaciones.mostrar');

Route::post('/detalle_cotizacion/agregar', [DetallesCotizacionController::class, 'agregar_detalle'])
->name('detalle_cotizacion.crear');

Route::get('/detalle_cotizacion/eliminar/{DetalleCotizacion}', [DetallesCotizacionController::class, 'destroy'])
->name('detalle_cotizacion.eliminar');

Route::post('/detalle_cotizacion/editar', [DetallesCotizacionController::class, 'agregar_detalle_edit'])
->name('detalle_cotizacion.editar');


/******************************* PEDIDOS PROVEEDOR *******************************/

Route::get('/pedidosProveedor', [PedidosProveedorController::class, 'index'])
->name('pedidosProveedor.index');



Route::get('/pedidosProveedor/limpiar',[PedidosProveedorController::class, 'limpiar'])
->name('pedidosProveedor.limpiar');

Route::get('/estadoPP/{id}', [PedidosProveedorController::class, 'updateStatus'])
->name('status.update')->where('id', '[0-9]+');

Route::get('/destroyP/{id}', [PedidosProveedorController::class, 'eliminar'])
->name('status.destroy')->where('id', '[0-9]+');


/******************************* DETALLE PEDIDO PROVEEDOR *******************************/

R

Route::get('/detalle_pedidosProveedor/eliminar/{DetalleCompra}', [DetallesPedidosProveedorController::class, 'destroy'])
->name('detalle_pedidosProveedor.eliminar');

Route::post('/detalle_pedidosProveedor/editar', [DetallesPedidosProveedorController::class, 'agregar_detalle_edit'])
->name('detalle_pedidosProveedor.editar');


/******************************* SERVICIO TECNICO *******************************/
Route::get('/Servicio', [ServicioController::class, 'index'])
    ->name('servicio.index');

Route::get('/Servicio/buscar', [ServicioController::class, 'index2'])
    ->name('servicio.index2');

Route::get('/Servicio/{id}', [ServicioController::class, 'show'])
->name('servicio.mostrar')->where('id', '[0-9]+');

Route::get('/Servicio/crear', [ServicioController::class, 'crear'])
->name('servicio.crear');

Route::post('Servicio/crear', [ServicioController::class, 'store'])
->name('servicio.guardar');

Route::get('/Servicio/{id}/editar', [ServicioController::class, 'edit'])
->name('servicio.edit')->where('id', '[0-9]+');

Route::put('/Servicio/{id}/editar', [ServicioController::class, 'update'])
->name('servicio.update')->where('id', '[0-9]+');

Route::get('/estado/{id}', [ServicioController::class, 'updateStatus'])
->name('status.update')->where('id', '[0-9]+');
