<?php

namespace App\Http\Controllers;

use App\Models\DetallesPedidosClientes;
use App\Models\Inventario;
use App\Models\PedidosClientesTemporal;
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

        $existe = DB::table('detalles_pedidos_clientes')->where('IdProducto', '=', $request->IdProducto)
                                                            ->where('IdPresentacion', '=', $request->IdPresentacion)
                                                            ->where('IdVenta', '=', 0)->exists();

        if ($existe) {
            $detalle = DetallesPedidosClientes::where('IdProducto', '=', $request->IdProducto)
                                ->where('IdPresentacion', '=', $request->IdPresentacion)
                                ->where('IdVenta', '=', 0)->firstOrFail();

            $detalle->IdVenta = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $detalle->Cantidad + $request->input('Cantidad');
            $detalle->save();
        } else {
            $detalle = new DetallesPedidosClientes();
            $detalle->IdVenta = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }


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

    public function edit_agregar_detalle($id, Request $request)
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

        $existe = DB::table('pedidos_clientes_temporals')->where('IdVenta', '=', $id, 'or', 0)
            ->where('IdProducto', '=', $request->IdProducto)
            ->where('IdPresentacion', '=', $request->IdPresentacion)->exists();

        if ($existe) {
            $det = PedidosClientesTemporal::where('IdVenta', '=', $id, 'or', 0)
                ->where('IdProducto', '=', $request->IdProducto)
                ->where('IdPresentacion', '=', $request->IdPresentacion)->firstOrFail();

            $det->IdVenta = $det->IdVenta;
            $det->IdProducto = $request-> IdProducto;
            $det->IdPresentacion = $request-> IdPresentacion;
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();
        } else {
            $detalle = new PedidosClientesTemporal();
            $detalle->IdVenta = 0;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }


        return redirect()->route('pedidosClientes.edit', ['id' => $id]);
    }

    public function destroy2($idDetalle, $id)
    {
        $detalles = PedidosClientesTemporal::findOrFail($idDetalle);
        $detalles->IdVenta = null;
        $detalles->save();

        return redirect()->route('pedidosClientes.edit', ['id' => $id]);
    }


    public function edit_agregar_detalle_edit($id, Request $request)
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

        $existe = DB::table('pedidos_clientes_temporals')->where('IdVenta', '=', $id, 'or', 0)
            ->where('IdProducto', '=', $request->IdProducto)
            ->where('IdPresentacion', '=', $request->IdPresentacion)
            ->where('id', '!=', $request->input('IdDetalle'))->exists();

        if ($existe) {
            $det = PedidosClientesTemporal::where('IdVenta', '=', $id, 'or', 0)
                ->where('IdProducto', '=', $request->IdProducto)
                ->where('IdPresentacion', '=', $request->IdPresentacion)
                ->where('id', '!=', $request->input('IdDetalle'))->firstOrFail();

            $det->IdVenta = $det->IdVenta;
            $det->IdProducto = $request->input('IdProducto');
            $det->IdPresentacion = $request->input('IdPresentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();

            $detalles = PedidosClientesTemporal::findOrFail($request->input('IdDetalle'));
            $detalles->IdVenta = null;
            $detalles->save();
        } else {
            $detalle = PedidosClientesTemporal::findOrFail($request->input('IdDetalle'));

            $detalle->IdVenta = $detalle->IdVenta;
            $detalle->IdProducto = $request->input('IdProducto');
            $detalle->IdPresentacion = $request->input('IdPresentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }

        return redirect()->route('pedidosClientes.edit', ['id' => $id]);
    }


}
