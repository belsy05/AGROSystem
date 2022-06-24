<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetallesPedidosClientes;
use App\Models\DetallesPedidosProductosNuevos;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use App\Models\PedidosClientes;
use App\Models\Precio;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosClientesController extends Controller
{
    public function index(Request $request)
    {
        $total_cantidad = 0;
        $cliente = "";
        $cliente = $request->input('texto');

        $pedidos = PedidosClientes::select('pedidos_clientes.id', 'clientes.NombresDelCliente', 'clientes.ApellidosDelCliente', 'EstadoDelPedido', 'FechaDelPedido')
            ->join('clientes', 'clientes.id', '=', 'pedidos_clientes.cliente_id')
            ->where('NombresDelCliente', 'like', '%' . $cliente . '%')
            ->orwhere('ApellidosDelCliente', 'like', '%' . $cliente . '%')
            ->get();

        return view('Ventas.indexPedidosCliente')->with('pedidos', $pedidos)->with('cliente', $cliente)->with('total_cantidad', $total_cantidad);
    }



    public function limpiar()
    {
        $detalles =  DetallesPedidosClientes::where('IdVenta', 0)->get();
        foreach ($detalles as $key => $value) {

            DB::delete('delete from detalles_pedidos_clientes where id = ?', [$value->id]);
        }

        return redirect()->route('pedidosCliente.crear');
    }

    public function updateStatus($id)
    {
        $clientepedido = "";
        $pedido = PedidosClientes::findOrFail($id);
        $clientepedido = $pedido->cliente_id;


        $productos = DetallesPedidosClientes::where('IdVenta', $id)->get();
        foreach ($productos as $key => $value) {
            $precio = Precio::where('IdProducto', '=', $value->IdProducto)
                                ->where('IdPresentación', '=', $value->IdPresentacion)->first();
            $p = $precio->Precio;

            $producto = new DetalleVenta();
            $producto->IdVenta = 0;
            $producto->IdProducto = $value->IdProducto;
            $producto->IdPresentacion = $value->IdPresentacion;
            $producto->Cantidad = $value->Cantidad;
            $producto->Precio_venta = $p;
            $producto->save();

            $inve =  Inventario::where('IdProducto', '=', $value->IdProducto)
            ->where('IdPresentacion', '=', $value->IdPresentacion)->firstOrFail();
    
            $inve->Existencia = $inve->Existencia - $value->Cantidad;
    
            $inve->save();
        }

        $detalles =  DetallesPedidosClientes::where('IdVenta', '=', $id)->get();
        foreach ($detalles as $key => $value) {

            DetallesPedidosProductosNuevos::destroy($value->id);
        }

        PedidosClientes::destroy($id);


        return redirect()->route('ventas.crear', ['clientepedido' => $clientepedido])
             ->with('mensaje', 'El estado fue modificado exitosamente');
    }

    public function eliminar($id)
    {
        $detalles =  DetallesPedidosClientes::where('IdVenta', '=', $id)->get();
        foreach ($detalles as $key => $value) {

            DetallesPedidosProductosNuevos::destroy($value->id);
        }

        PedidosClientes::destroy($id);

        return redirect()->route('pedidosCliente.index');

        

    }
}
