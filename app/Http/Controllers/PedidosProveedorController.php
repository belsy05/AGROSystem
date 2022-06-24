<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DetallesPedidosProveedor;
use App\Models\PedidosProveedor;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class PedidosProveedorController extends Controller
{

    public function index(Request $request)
    {
        $proveedor = "";
        $proveedor = $request->input('texto');
        $total_cantidad = 0;

        $pedidos = PedidosProveedor::select('pedidos_proveedors.*', 'proveedors.EmpresaProveedora')
            ->join('proveedors', 'proveedors.id', '=', 'pedidos_proveedors.proveedor_id')
            ->where('EmpresaProveedora', 'like', '%' . $proveedor . '%')
            ->paginate(15);
            foreach ($pedidos  as $key => $value) {
                $value->proveedor = Proveedor::findOrFail($value->proveedor_id);  
                
            }
            
        return view('Compras.indexPedidosProveedor')->with('pedidos', $pedidos)->with('proveedor', $proveedor) ->with('total_cantidad', $total_cantidad);
    }


    public function show($id)
    {
        $pedidos = PedidosProveedor::where('id', $id)->first();
        $details = DetallesPedidosProveedor::where('IdPedido', $pedidos->id)->get();
        return view('Compras.detallePedidosProveedor')->with('pedidos', $pedidos)->with('detalles', $details);
    }

    public function create()
    {
        $total_cantidad = 0;
        $detalles =  DetallesPedidosProveedor::where('IdPedido', 0)->get();
        $proveedor = Proveedor::all();

        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
        }

        return view('Compras.formularioPedidosProveedor')
            ->with('proveedor', $proveedor)
            ->with('detalles', $detalles)
            ->with('total_cantidad', $total_cantidad);
    }

    public function store(Request $request)
    {
        $request->validate([
            'FechaPedidoProveedor' => 'required|date|before:tomorrow|after:yesterday',
            'Proveedor'=> 'required',
            'TotalCantidad' => 'required|numeric|min:1'
        ], [

            'FechaPedidoProveedor.before' => 'El campo fecha de pedido debe de ser hoy',
            'FechaPedidoProveedor.after' => 'El campo fecha de pedido debe de ser hoy',
            'TotalCantidad.min' => 'Ingrese detalles para este pedido'

        ]);

        $venta = new PedidosProveedor();

        $venta->proveedor_id = $request->input('Proveedor');
        $venta->FechaDelPedido = $request->input('FechaPedidoProveedor');
        $venta->save();

        $detalles =  DetallesPedidosProveedor::where('IdPedido', 0)->get();


        foreach ($detalles  as $key => $value) {
            $de = DetallesPedidosProveedor::findOrFail($value->id);
            $de->IdPedido = $venta->id;

            $de->save();
        }
        return redirect()->route('pedidosProveedor.index');
    }

    public function limpiar()
    {
        $detalles =  DetallesPedidosProveedor::where('IdPedido', 0)->get();
        foreach ($detalles as $key => $value) {

            DB::delete('delete from detalles_pedidos_proveedors where id = ?', [$value->id]);
        }

        return redirect()->route('pedidosProveedor.crear');
    }


    public function eliminar($id)
    {
        $detalles =  DetallesPedidosProveedor::where('IdPedido', '=', $id)->get();
        foreach ($detalles as $key => $value) {

            DetallesPedidosProveedor::destroy($value->id);
        }

        PedidosProveedor::destroy($id);

        return redirect()->route('pedidosProveedor.index');
    } 

  /*   public function updateStatus($id)
    {
        $proveedorpedido = "";
        $pedido = PedidosProveedor::findOrFail($id);
        $proveedorpedido  = $pedido->proveedor_id;


        $productos = DetallesPedidosProveedor::where('IdVenta', $id)->get();
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
    } */



}