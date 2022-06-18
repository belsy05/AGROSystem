<?php

namespace App\Http\Controllers;

use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\Return_;
use Symfony\Contracts\Service\Attribute\Required;

class DetalleCompraController extends Controller
{    
    
    public function agregar_detalle(Request $request)
    {
        
        $vencimiento = Categoria::where('id', $request->input('IdCategoria'))->first();
        $elaboracion = Categoria::where('id', $request->input('IdCategoria'))->first();


        if($elaboracion == null && $vencimiento == null ){
            $rules=[
                'IdCategoria'=>'required|exists:categorias,id',
                'IdProducto'=>'required|exists:productos,id',
                'IdPresentacion'=>'required|exists:presentacions,id',
                'Precio_compra'=>'required|numeric|min:1.00',
                'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                'Cantidad'=>'required|numeric|min:1',
                'fecha'=>'required|date|after:tomorrow',
                'fecha_elaboración'=>'required|date|'
            ];
        }else{
            if($elaboracion->elaboracion == 1 && $vencimiento->vencimiento == 1){
                $rules=[
                    'IdCategoria'=>'required|exists:categorias,id',
                    'IdProducto'=>'required|exists:productos,id',
                    'IdPresentacion'=>'required|exists:presentacions,id',
                    'Precio_compra'=>'required|numeric|min:1',
                    'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                    'Cantidad'=>'required|numeric|min:1',
                ];
            }else{
                $rules=[
                    'IdCategoria'=>'required|exists:categorias,id',
                    'IdProducto'=>'required|exists:productos,id',
                    'IdPresentacion'=>'required|exists:presentacions,id',
                    'Precio_compra'=>'required|numeric|min:1',
                    'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                    'Cantidad'=>'required|numeric|min:1',
                    'fecha'=>'required|date|after:tomorrow',
                    'fecha_elaboración'=>'required|date|before:today'
                ];
            }
        }

        $mensaje=[
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Precio_venta.min' => 'El precio de venta debe de ser mayor al precio de compra',
            'fecha.required' => 'El campo fecha de vencimiento es obligatorio',
            'fecha.date' => 'El campo fecha de vencimiento debe de ser una fecha',
            'fecha.after' => 'El campo fecha de vencimiento debe de ser posterior al dia de hoy',
            'fecha_elaboración.required'=> 'El campo fecha de elaboración es obligatorio',
            'fecha_elaboración.before' => 'El campo fecha de elaboración debe de ser anterior al dia de hoy',
        ];
        $this->validate($request,$rules,$mensaje);

        $existe = DB::table('detalle_compras')->where('IdProducto', '=', $request->IdProducto)
                                                            ->where('IdPresentacion', '=', $request->IdPresentacion)
                                                            ->where('IdCompra', '=', 0)->exists();

        if ($existe) {
            $detalle = DetalleCompra::where('IdProducto', '=', $request->IdProducto)
                                ->where('IdPresentacion', '=', $request->IdPresentacion)
                                ->where('IdCompra', '=', 0)->firstOrFail();
                        
                                $detalle->IdCompra = 0;
                                $detalle->IdProducto = $request->input('IdProducto');
                                $detalle->IdPresentacion = $request->input('IdPresentacion');
                                $detalle->Cantidad = $detalle->Cantidad + $request->input('Cantidad');
                                $detalle->Precio_compra = $request->input('Precio_compra');
                                $detalle->Precio_venta = $request->input('Precio_venta');
                                $detalle->fecha_vencimiento = $request->input('fecha');
                                $detalle->fecha_elaboración = $request->input('fecha_elaboración');
                                $detalle->save();

        } else {
            $detalle = new DetalleCompra();
            $detalle->IdCompra = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->Precio_compra = $request->input('Precio_compra');
            $detalle->Precio_venta = $request->input('Precio_venta');
            $detalle->fecha_vencimiento = $request->input('fecha');
            $detalle->fecha_elaboración = $request->input('fecha_elaboración');
            $detalle->save();
        }

        return redirect()->route('compras.crear');
    }

    public function destroy($id)
    {
        DetalleCompra::findOrFail($id)->delete();
        return redirect()->route('compras.crear');
    }

    public function agregar_detalle_edit(Request $request)
    {

        $vencimiento = Categoria::where('id', $request->input('IdCategoria'))->first();
        $elaboracion = Categoria::where('id', $request->input('IdCategoria'))->first();


        if($elaboracion == null && $vencimiento == null ){
            $rules=[
                'IdCategoria'=>'required|exists:categorias,id',
                'IdProducto'=>'required|exists:productos,id',
                'IdPresentacion'=>'required|exists:presentacions,id',
                'Precio_compra'=>'required|numeric|min:1',
                'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                'Cantidad'=>'required|numeric|min:1',
                'fecha'=>'required|date|after:tomorrow',
                'fecha_elaboración'=>'required|date|'
            ];
        }else{
            if($elaboracion->elaboracion == 1 && $vencimiento->vencimiento == 1){
                $rules=[
                    'IdCategoria'=>'required|exists:categorias,id',
                    'IdProducto'=>'required|exists:productos,id',
                    'IdPresentacion'=>'required|exists:presentacions,id',
                    'Precio_compra'=>'required|numeric|min:1',
                    'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                    'Cantidad'=>'required|numeric|min:1',
                ];
            }else{
                $rules=[
                    'IdCategoria'=>'required|exists:categorias,id',
                    'IdProducto'=>'required|exists:productos,id',
                    'IdPresentacion'=>'required|exists:presentacions,id',
                    'Precio_compra'=>'required|numeric|min:1',
                    'Precio_venta'=>'required|numeric|min:'.($request->input('Precio_compra')+1),
                    'Cantidad'=>'required|numeric|min:1',
                    'fecha'=>'required|date|after:tomorrow',
                    'fecha_elaboración'=>'required|date|before:tomorrow'
                ];
            }
        }

        $mensaje=[
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Precio_venta.min' => 'El precio de venta debe de ser mayor al precio de compra',
            'fecha.required' => 'El campo fecha de vencimiento es obligatorio',
            'fecha.date' => 'El campo fecha de vencimiento debe de ser una fecha',
            'fecha.after' => 'El campo fecha de vencimiento debe de ser posterior al dia de hoy',
            'fecha_elaboración.required'=> 'El campo fecha de elaboración es obligatorio',
            'fecha_elaboración.before' => 'El campo fecha de elaboración debe de ser anterior al dia de hoy',
            
        ];
        $this->validate($request,$rules,$mensaje);

        $detalle = DetalleCompra::findOrFail($request->input('IdDetalle'));
        $detalle->IdCompra = 0;
        $detalle->IdProducto = $request->input('IdProducto');
        $detalle->IdPresentacion = $request->input('IdPresentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->Precio_compra = $request->input('Precio_compra');
        $detalle->Precio_venta = $request->input('Precio_venta');
        $detalle->fecha_vencimiento = $request->input('fecha');
        $detalle->fecha_elaboración = $request->input('fecha_elaboración');
        $detalle->save();

        return redirect()->route('compras.crear');
    }
}