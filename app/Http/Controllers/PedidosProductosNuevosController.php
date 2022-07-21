<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\DetallesPedidosProductosNuevos;
use App\Models\PedidosProductosNuevos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidosProductosNuevosController extends Controller
{
    //

    public function index(Request $request)
    {
        $cliente = "";
        $cliente = $request->input('texto');
        $total_cantidad = 0;

        $pedidos = PedidosProductosNuevos::select('pedidos_productos_nuevos.*', 'clientes.NombresDelCliente', 'clientes.ApellidosDelCliente')
            ->join('clientes', 'clientes.id', '=', 'pedidos_productos_nuevos.cliente_id')
            ->where('NombresDelCliente', 'like', '%' . $cliente . '%')
            ->orwhere('ApellidosDelCliente', 'like', '%' . $cliente . '%')
            ->paginate(15);
            foreach ($pedidos  as $key => $value) {
                $value->cliente = Cliente::findOrFail($value->cliente_id);  
                
            }
            

        return view('Ventas.indexPedidosProductosNuevos')->with('pedidos', $pedidos)->with('cliente', $cliente) ->with('total_cantidad', $total_cantidad);
    }

    public function show($id)
    {
        $pedidos = PedidosProductosNuevos::findOrFail($id);
        $details = DetallesPedidosProductosNuevos::where('IdPedido', $id)->get();
        return view('Ventas.detallePedidosProductosNuevos')->with('pedidos', $pedidos)->with('detalles', $details);
    }

    public function create()
    {
        $total_cantidad = 0;
        $detalles =  DetallesPedidosProductosNuevos::where('IdPedido', 0)->get();
        $cliente = Cliente::all();

        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
        }

        return view('Ventas.formularioPedidosProductosNuevos')
            ->with('cliente', $cliente)
            ->with('detalles', $detalles)
            ->with('total_cantidad', $total_cantidad);
    }


    public function store(Request $request)
    {
        

        $request->validate([
            'FechaPedidoClienteP' => 'required|date|before:tomorrow|after:yesterday',
            'TotalAnticipo' => 'required|numeric|min:0.00|max:30000.00',
            'ClienteP' => 'required',
            'TotalCantidad' => 'required|numeric|min:1'
        ], [
            
            'FechaPedidoCliente.before' => 'El campo fecha de pedido debe de ser hoy',
            'FechaPedidoCliente.after' => 'El campo fecha de pedido debe de ser hoy',
            'TotalAnticipo.numeric' => 'El anticipo debe ser en número',
            'ClienteP.required' => 'El campo nombre del cliente es obligatorio',
            'TotalCantidad.min' => 'Ingrese detalles para este pedido'
           
        ]);

        $venta = new PedidosProductosNuevos();

        $venta->cliente_id = $request->input('ClienteP');
        $venta->FechaDelPedido = $request->input('FechaPedidoClienteP');
        $venta->TotalAnticipo = $request->input('TotalAnticipo');
        $venta->save();

        $detalles =  DetallesPedidosProductosNuevos::where('IdPedido', 0)->get();


        foreach ($detalles  as $key => $value) {
            $de = DetallesPedidosProductosNuevos::findOrFail($value->id);
            $de->IdPedido = $venta->id;

            $de->save();

            
        }
        return redirect()->route('pedidosClienteP.index');
    }

    public function limpiar()
    {
        $detalles =  DetallesPedidosProductosNuevos::where('IdPedido', 0)->get();
        foreach ($detalles as $key => $value) {

            DB::delete('delete from detalles_pedidos_productos_nuevos where id = ?', [$value->id]);
        }

        return redirect()->route('pedidosClienteP.crear');
    }

    public function updateStatus($id)
    {
        $detalles =  DetallesPedidosProductosNuevos::where('IdPedido', '=', $id)->get();
        foreach ($detalles as $key => $value) {

            DetallesPedidosProductosNuevos::destroy($value->id);
        }

        PedidosProductosNuevos::destroy($id);

        return redirect()->route('pedidosClienteP.index');

        

    }

    public function edit($id){
        $detallesViejos = DetallesPedidosProductosNuevos::where('IdPedido', $id)->get();
        foreach ($detallesViejos  as $key => $value) {
            $existe = DB::table('detalles_productos_nuevos_temporals')->where('IdPedido', '=', $id)
                                                            ->where('Producto', '=', $value->Producto)
                                                            ->where('Presentacion', '=', $value->Presentacion)->exists();
            
            $exis = DB::table('detalles_productos_nuevos_temporals')->where('IdPedido', '=', null)
                                                            ->where('Producto', '=', $value->Producto)
                                                            ->where('Presentacion', '=', $value->Presentacion)->exists();
            if ($existe == false && $exis == false) {
                $temporal = new DetallesProductosNuevosTemporal();
                $temporal->IdPedido = $value->IdPedido;
                $temporal->Producto = $value->Producto;
                $temporal->Presentacion = $value->Presentacion;
                $temporal->Cantidad = $value->Cantidad;
                $temporal->save();
            }
        }
        $pedido = PedidosProductosNuevos::findOrFail($id);
        $total_cantidad = 0;
        $detalles =  DetallesProductosNuevosTemporal::where('IdPedido', '=', $id)->orwhere('IdPedido', '=', 0)->get();
        $cliente = Cliente::all();

        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
        }

        return view('Ventas.formularioEditarPedidosProductosNuevos')->with('cliente', $cliente)
                                                                    ->with('pedido', $pedido)
                                                                    ->with('detalles', $detalles)
                                                                    ->with('total_cantidad', $total_cantidad);

    }

    public function update(Request $request, $id){

        $request->validate([
            'FechaPedidoClienteP' => 'required|date|before:tomorrow|after:yesterday',
            'TotalAnticipo' => 'required|numeric|min:0.00|max:30000.00',
            'ClienteP' => 'required',
            'TotalCantidad' => 'required|numeric|min:1'
        ], [
            
            'FechaPedidoCliente.before' => 'El campo fecha de pedido debe de ser hoy',
            'FechaPedidoCliente.after' => 'El campo fecha de pedido debe de ser hoy',
            'TotalAnticipo.numeric' => 'El anticipo debe ser en número',
            'ClienteP.required' => 'El campo nombre del cliente es obligatorio',
            'TotalCantidad.min' => 'Ingrese detalles para este pedido'
           
        ]);

    
}
