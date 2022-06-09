<?php

namespace App\Http\Controllers;

use App\Models\DetallesPedidosProductosNuevos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallesPedidosProductosNuevosController extends Controller
{
    //
    public function agregar_detalle(Request $request)
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

        $existe = Db::table('detalles_pedidos_productos_nuevos')->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('IdPedido', '=', 0)->exists();

        if ($existe) {
            $det = DetallesPedidosProductosNuevos::where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('IdPedido', '=', 0)->firstOrFail();

            $det->IdPedido = 0;
            $det->Producto = $request->input('NombreDelProducto');
            $det->Presentacion = $request->input('presentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();
        } else {
            $detalle = new DetallesPedidosProductosNuevos();
            $detalle->IdPedido = 0;
            $detalle->Producto = $request->input('NombreDelProducto');
            $detalle->Presentacion = $request->input('presentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }


        return redirect()->route('pedidosClienteP.crear');
    }

    public function destroy($id)
    {
        $detalles = DetallesPedidosProductosNuevos::findOrFail($id);


        $detalles->delete();

        return redirect()->route('pedidosClienteP.crear');
    }
}
