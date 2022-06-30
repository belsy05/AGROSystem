<?php

namespace App\Http\Controllers;

use App\Models\DetallesPedidosProductosNuevos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallesPedidosProductosNuevosController extends Controller
{
    //
    

    public function agregar_detalle_edit(Request $request)
    {
        
        $rules = [
            'NombreDelProducto' => 'required|max:40',
            'presentacion' => 'required|max:30',
            'Cantidad' => 'required|numeric|min:1',
        ];

        $mensaje = [
            'NombreDelProducto.required' => 'El campo producto es obligatorio.',
            'presentacion.required' => 'El campo presentación es obligatorio.',
        ];
        $this->validate($request, $rules, $mensaje);

        $detalle = DetallesPedidosProductosNuevos::findOrFail($request->input('IdDetalle'));

        $detalle->IdPedido = 0;
        $detalle->Producto = $request->input('NombreDelProducto');
        $detalle->Presentacion = $request->input('presentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->save();

        return redirect()->route('pedidosClienteP.crear');
    }
}
