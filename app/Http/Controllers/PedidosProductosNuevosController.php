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

}
