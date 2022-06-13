<?php

namespace App\Http\Controllers;

use App\Models\DetallesPedidosClientes;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DetallesPedidosClientesController extends Controller
{
    //
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
            'Cantidad' => 'required|numeric|min:1|max:'.($max),
        ];

        $mensaje = [
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Cantidad.max' => 'No hay suficiente producto para realizar este pedido',
        ];
        $this->validate($request, $rules, $mensaje);

        $detalle = new DetallesPedidosClientes();
        $detalle->IdVenta = 0;
        $detalle->IdProducto = $request->input('IdProducto');
        $detalle->IdPresentacion = $request->input('IdPresentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->save();


        return redirect()->route('pedidosCliente.crear');
    }

    public function destroy($id)
    {
        $detalles = DetallesPedidosClientes::findOrFail($id);


        $detalles->delete();

        return redirect()->route('pedidosCliente.crear');
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
                'Cantidad' => 'required|numeric|min:1|max:'.($max),
            ];

        $mensaje = [
            'IdCategoria.required' => 'El campo categoria es obligatorio.',
            'IdProducto.required' => 'El campo producto es obligatorio.',
            'IdPresentacion.required' => 'El campo presentación es obligatorio.',
            'Cantidad.max' => 'No hay suficiente producto para realizar esta venta'

        ];
        $this->validate($request, $rules, $mensaje);

        $detalle = DetallesPedidosClientes::findOrFail($request->input('IdDetalle'));
        $detalle->IdVenta = 0;
        $detalle->IdProducto = $request->input('IdProducto');
        $detalle->IdPresentacion = $request->input('IdPresentacion');
        $detalle->Cantidad = $request->input('Cantidad');
        $detalle->save();

        return redirect()->route('pedidosCliente.crear');
    }

}