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
    

    public function show($id)
    {
        $pedidos = PedidosClientes::where('id', $id)->first();
        $details = DetallesPedidosClientes::where('IdVenta', $pedidos->id)->get();
        return view('Ventas.detallePedidosCliente')->with('pedidos', $pedidos)->with('detalles', $details);
    }

    public function create()
    {
        // ////////////////////////////////////////////////////
        // //////////////////////////////////////////////////////////
        $detalles =  DetallesPedidosClientes::where('IdVenta', 0)->get();
        $productos = Producto::all();
        $cliente = Cliente::all();
        $categoria = Categoria::all();
        $presentacion = Presentacion::all();
        $inventarios = Inventario::all();
        $total_cantidad = 0;

        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
        }

        return view('Ventas.formularioPedidosCliente')
            ->with('cliente', $cliente)
            ->with('productos', $productos)
            ->with('presentacion', $presentacion)
            ->with('categoria', $categoria)
            ->with('inventarios', $inventarios)
            ->with('detalles', $detalles)
            ->with('total_cantidad', $total_cantidad);
    }




    public function store(Request $request)
    {


        $request->validate([
            'FechaPedidoCliente' => 'required|date|before:tomorrow|after:yesterday',
            'TotalCantidad' => 'required|numeric|min:1'
        ], [

            'FechaPedidoCliente.before' => 'El campo fecha de pedido debe de ser hoy',
            'FechaPedidoCliente.after' => 'El campo fecha de pedido debe de ser hoy',
            'TotalCantidad.min' => 'Ingrese detalles para este pedido'

        ]);


        $venta = new PedidosClientes();

        $venta->cliente_id = $request->input('Cliente');
        $venta->FechaDelPedido = $request->input('FechaPedidoCliente');
        $venta->save();

        $detalles =  DetallesPedidosClientes::where('IdVenta', 0)->get();


        foreach ($detalles  as $key => $value) {
            $de = DetallesPedidosClientes::findOrFail($value->id);
            $de->IdVenta = $venta->id;

            $de->save();
        }
        return redirect()->route('pedidosCliente.index');
    }

    
   

   
}
