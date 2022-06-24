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
