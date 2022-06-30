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

    

    public function updateStatus($id)
    {
        $detalles =  DetallesPedidosProductosNuevos::where('IdPedido', '=', $id)->get();
        foreach ($detalles as $key => $value) {

            DetallesPedidosProductosNuevos::destroy($value->id);
        }

        PedidosProductosNuevos::destroy($id);

        return redirect()->route('pedidosClienteP.index');

        

    }
}
