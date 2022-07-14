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

        $existe = DB::table('detalles_pedidos_proveedors')->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('id', '!=', $request->input('IdDetalle'))
                                                            ->where('IdPedido', '=', 0)->exists();

        if ($existe) {
            $det = DetallesPedidosProveedor::where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('id', '!=', $request->input('IdDetalle'))
                                                            ->where('IdPedido', '=', 0)->firstOrFail();

            $det->IdPedido = 0;
            $det->Producto = $request->input('NombreDelProducto');
            $det->Presentacion = $request->input('presentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();

            $detalles = DetallesPedidosProveedor::findOrFail($request->input('IdDetalle'));
            $detalles->delete();
        } else {
            $detalle = DetallesPedidosProveedor::findOrFail($request->input('IdDetalle'));

            $detalle->IdPedido = 0;
            $detalle->Producto = $request->input('NombreDelProducto');
            $detalle->Presentacion = $request->input('presentacion');
            $detalle->Cantidad = $request->input('Cantidad');
            $detalle->save();
        }

        return redirect()->route('pedidosProveedor.crear');
    }

    public function edit_agregar_detalle($id, Request $request)
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

        $existe = DB::table('detalles_pedidos_proveedores_temporals')->where('IdPedido', '=', $id)
                                                            ->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)->exists();

        $exis = DB::table('detalles_pedidos_proveedores_temporals')->where('IdPedido', '=', 0)
                                                            ->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)->exists();

        if ($existe) {
            $det = DetallesPedidosProveedoresTemporal::where('IdPedido', '=', $id)
                                                ->where('Producto', '=', $request->NombreDelProducto)
                                                ->where('Presentacion', '=', $request->presentacion)->firstOrFail();

            $det->IdPedido = $det->IdPedido;
            $det->Producto = $request->input('NombreDelProducto');
            $det->Presentacion = $request->input('presentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();
        }else{
            if($exis){
                $det = DetallesPedidosProveedoresTemporal::where('IdPedido', '=', 0)
                                                ->where('Producto', '=', $request->NombreDelProducto)
                                                ->where('Presentacion', '=', $request->presentacion)->firstOrFail();

                $det->IdPedido = $det->IdPedido;
                $det->Producto = $request->input('NombreDelProducto');
                $det->Presentacion = $request->input('presentacion');
                $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
                $det->save();
            }else {
                $detalle = new DetallesPedidosProveedoresTemporal();
                $detalle->IdPedido = 0;
                $detalle->Producto = $request->input('NombreDelProducto');
                $detalle->Presentacion = $request->input('presentacion');
                $detalle->Cantidad = $request->input('Cantidad');
                $detalle->save();
            }
        }


        return redirect()->route('pedidosProveedor.edit', ['id' => $id]);
    }

    public function destroy2($idDetalle, $id)
    {
        $detalles = DetallesPedidosProveedoresTemporal::findOrFail($idDetalle);
        $detalles->IdPedido = null;
        $detalles->save();

        return redirect()->route('pedidosProveedor.edit', ['id' => $id]);
    }


    public function edit_agregar_detalle_edit($id, Request $request)
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

        $existe = DB::table('detalles_pedidos_proveedores_temporals')->where('IdPedido', '=', $id)
                                                            ->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('id', '!=', $request->input('IdDetalle'))->exists();

        $exis = DB::table('detalles_pedidos_proveedores_temporals')->where('IdPedido', '=', 0)
                                                            ->where('Producto', '=', $request->NombreDelProducto)
                                                            ->where('Presentacion', '=', $request->presentacion)
                                                            ->where('id', '!=', $request->input('IdDetalle'))->exists();

        if ($existe) {
            $det = DetallesPedidosProveedoresTemporal::where('IdPedido', '=', $id)
                                                ->where('Producto', '=', $request->NombreDelProducto)
                                                ->where('Presentacion', '=', $request->presentacion)
                                                ->where('id', '!=', $request->input('IdDetalle'))->firstOrFail();

            $det->IdPedido = $det->IdPedido;
            $det->Producto = $request->input('NombreDelProducto');
            $det->Presentacion = $request->input('presentacion');
            $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
            $det->save();

            $detalles = DetallesPedidosProveedoresTemporal::findOrFail($request->input('IdDetalle'));
            $detalles->IdPedido = null;
            $detalles->save();
        }else{
            if($exis){
                $det = DetallesPedidosProveedoresTemporal::where('IdPedido', '=', 0)
                                                ->where('Producto', '=', $request->NombreDelProducto)
                                                ->where('Presentacion', '=', $request->presentacion)
                                                ->where('id', '!=', $request->input('IdDetalle'))->firstOrFail();

                $det->IdPedido = $det->IdPedido;
                $det->Producto = $request->input('NombreDelProducto');
                $det->Presentacion = $request->input('presentacion');
                $det->Cantidad = $det->Cantidad + $request->input('Cantidad');
                $det->save();

                $detalles = DetallesPedidosProveedoresTemporal::findOrFail($request->input('IdDetalle'));
                $detalles->IdPedido = null;
                $detalles->save();
            } else {
                    $detalle = DetallesPedidosProveedoresTemporal::findOrFail($request->input('IdDetalle'));

                    $detalle->IdPedido = $detalle->IdPedido;
                    $detalle->Producto = $request->input('NombreDelProducto');
                    $detalle->Presentacion = $request->input('presentacion');
                    $detalle->Cantidad = $request->input('Cantidad');
                    $detalle->save();
            }
            
        }

        return redirect()->route('pedidosProveedor.edit', ['id' => $id]);
    }
}
