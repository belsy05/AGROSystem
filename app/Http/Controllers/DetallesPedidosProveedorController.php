<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DetallesPedidosProveedor;

class DetallesPedidosProveedorController extends Controller
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

        $existe = DB::table('detalles_pedidos_proveedors')->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('IdPedido', '=', 0)->exists();

        if ($existe) {
            $det = DetallesPedidosProveedor::where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('IdPedido', '=', 0)->firstOrFail();

            $det->IdPedido = 0;
            $det->Producto = $request->input('NombreDelProducto');
            $det->Presentacion = $request->input('presentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();
        } else {
            $detalle = new DetallesPedidosProveedor();
            $detalle->IdPedido = 0;
            $detalle->Producto = $request->input('NombreDelProducto');
            $detalle->Presentacion = $request->input('presentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }


        return redirect()->route('pedidosProveedor.crear');
    }

    public function destroy($id)
    {
        $detalles = DetallesPedidosProveedor::findOrFail($id);
        $detalles->delete();

        return redirect()->route('pedidosProveedor.crear');
    }


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

        $detalle = DetallesPedidosProveedor::findOrFail($request->input('IdDetalle'));

        $detalle->IdPedido = 0;
        $detalle->Producto = $request->input('NombreDelProducto');
        $detalle->Presentacion = $request->input('presentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->save();

        return redirect()->route('pedidosProveedor.crear');
    }
}