<?php

namespace App\Http\Controllers;

use App\Models\DetalleCotizacion;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallesCotizacionController extends Controller
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

        $existe = DB::table('detalle_cotizacions')->where('IdProducto', '=', $request->IdProducto)
                                                            ->where('IdPresentacion', '=', $request->IdPresentacion)
                                                            ->where('IdCotizacion', '=', 0)->exists();

        if ($existe) {
            $detalle = DetalleCotizacion::where('IdProducto', '=', $request->IdProducto)
                                ->where('IdPresentacion', '=', $request->IdPresentacion)
                                ->where('IdCotizacion', '=', 0)->firstOrFail();
                        
            $detalle->IdCotizacion = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $detalle->Cantidad + $request->input('Cantidad');
            $detalle->Precio_venta = $request->input('Precio_venta');
            $detalle->save();

        } else {
            $detalle = new DetalleCotizacion();
            $detalle->IdCotizacion = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->Precio_venta = $request->input('Precio_venta');
            $detalle->save();
        }


        return redirect()->route('cotizaciones.crear');
    }

    public function destroy($id)
    {
        $detalles = DetalleCotizacion::findOrFail($id);

        $inve =  Inventario::where('IdProducto', '=', $detalles->IdProducto)
        ->where('IdPresentacion', '=', $detalles->IdPresentacion)->firstOrFail();

        $detalles->delete();

        return redirect()->route('cotizaciones.crear');
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

        $detalle = DetalleCotizacion::findOrFail($request->input('IdDetalle'));
        
        $detalle->IdCotizacion = 0;
        $detalle->IdProducto = $request->input('IdProducto');
        $detalle->IdPresentacion = $request->input('IdPresentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->Precio_venta = $request->input('Precio_venta');
        $detalle->save();

        return redirect()->route('cotizaciones.crear');
    }
}
