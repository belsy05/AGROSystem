<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetalleVentaController extends Controller
{
    public function agregar_detalle(Request $request)
    {
        $max=0;
        $lim = $request->IdProducto;
        $limite = DB::table('inventarios')->where('IdProducto', '=', $lim)->get();
        foreach($limite as $l){
            $max = $l->Existencia;
        }

        $rules = [
            'IdCategoria' => 'required|exists:categorias,id',
            'IdProducto' => 'required|exists:productos,id',
            'IdPresentacion' => 'required|exists:presentacions,id',
            'Precio_venta' => 'required|numeric|min:1',
            'Cantidad' => 'required|numeric|min:1|max:'.($max),
        ];

        $mensaje = [
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Precio_venta.min' => 'No hay producto en existencia.',
            'Cantidad.max' => 'No hay suficiente producto para realizar esta venta',
        ];
        $this->validate($request, $rules, $mensaje);

        $existe = Db::table('detalle_ventas')->where('IdProducto', '=', $request->IdProducto)
                                                            ->where('IdPresentacion', '=', $request->IdPresentacion)
                                                            ->where('IdVenta', '=', 0)->exists();

        if ($existe) {
            $detalle = DetalleVenta::where('IdProducto', '=', $request->IdProducto)
                                ->where('IdPresentacion', '=', $request->IdPresentacion)
                                ->where('IdVenta', '=', 0)->firstOrFail();

            $inve =  Inventario::where('IdProducto', '=', $request->input('IdProducto'))
            ->where('IdPresentacion', '=', $request->input('IdPresentacion'))->firstOrFail();
                        
            $detalle->IdVenta = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $detalle->Cantidad + $request->input('Cantidad');
            $detalle->Precio_venta = $request->input('Precio_venta');
            $detalle->save();
                        
            $inve->Existencia = $inve->Existencia - $request->input('Cantidad');
            $inve->save();
        } else {
            $detalle = new DetalleVenta();
            $detalle->IdVenta = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->Precio_venta = $request->input('Precio_venta');
            $detalle->save();

            $inve =  Inventario::where('IdProducto', '=', $request->input('IdProducto'))
            ->where('IdPresentacion', '=', $request->input('IdPresentacion'))->firstOrFail();

            $inve->Existencia = $inve->Existencia - $request->input('Cantidad');

            $inve->save();
        }

        return redirect()->route('ventas.crear', ['clientepedido' => $request->Idcliente]);
    }

    public function destroy($id, $cliente)
    {
        $detalles = DetalleVenta::findOrFail($id);

        $inve =  Inventario::where('IdProducto', '=', $detalles->IdProducto)
        ->where('IdPresentacion', '=', $detalles->IdPresentacion)->firstOrFail();

        $inve->Existencia = $inve->Existencia + $detalles->Cantidad;

        $inve->save();

        $detalles->delete();

        return redirect()->route('ventas.crear', ['clientepedido' => $cliente]);
    }

    public function agregar_detalle_edit(Request $request)
    { 
        $max=0;
        $lim = $request->IdProducto;
        $limite = DB::table('inventarios')->where('IdProducto', '=', $lim)->get();
        foreach($limite as $l){
            $max = $l->Existencia;
        }
        
            $rules = [
                'IdCategoria' => 'required|exists:categorias,id',
                'IdProducto' => 'required|exists:productos,id',
                'IdPresentacion' => 'required|exists:presentacions,id',
                'Precio_venta' => 'required|numeric|min:1',
                'Cantidad' => 'required|numeric|min:1|max:'.($max),
            ];

        $mensaje = [
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Precio_venta.min' => 'El artículo no tiene precio establecido',
            'Cantidad.max' => 'No hay suficiente producto para realizar esta venta'

        ];
        $this->validate($request, $rules, $mensaje);

        $detalle = DetalleVenta::findOrFail($request->input('IdDetalle'));

        $inve =  Inventario::where('IdProducto', '=', $request->input('IdProducto'))
        ->where('IdPresentacion', '=', $request->input('IdPresentacion'))->firstOrFail();

        $inve->Existencia = $inve->Existencia + $detalle->Cantidad;

        $detalle->IdVenta = 0;
        $detalle->IdProducto = $request->input('IdProducto');
        $detalle->IdPresentacion = $request->input('IdPresentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->Precio_venta = $request->input('Precio_venta');
        $detalle->save();

        $inve->Existencia = $inve->Existencia - $request->input('Cantidad');

        $inve->save();

        return redirect()->route('ventas.crear', ['clientepedido' => $request->e_Idcliente]);
    }
}