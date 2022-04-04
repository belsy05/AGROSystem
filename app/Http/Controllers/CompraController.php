<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Categoria;
use App\Models\Precio;
use App\Models\Presentacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{

    public function create()
    {
        $total_cantidad = 0;
        $total_precio = 0;
        $detalles =  DetalleCompra::where('IdCompra', 0)->get();
        foreach ( $detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
            $total_precio += ($value->Cantidad * $value->Precio_compra);
        }

        $productos = Producto::all();
        $proveedor= Proveedor::all();
        $categoria= Categoria::all();
        $presentacion= Presentacion::all();

        return view('Compras.formularioCompras')->with('detalles',$detalles)
                                                ->with('productos',$productos)
                                                ->with('proveedor',$proveedor)
                                                ->with('presentacion',$presentacion)
                                                ->with('categoria',$categoria)
                                                ->with('total_cantidad',$total_cantidad)
                                                ->with('total_precio',$total_precio);
    }


    public function store(Request $request){

        $request->validate([
            'FechaCompra'=>'required|date|before:tomorrow',
        ], [
            'FechaCompra.before'=> 'El campo fecha de compra debe de ser anterior al dia de mañana',
        ]);


        $compra = new Compra();

        $compra->NumFactura = $request->input('NumFactura');
        $compra->proveedor_id = $request->input('Proveedor');
        $compra->FechaCompra = $request->input('FechaCompra');
        $compra->TotalCompra = $request->input('TotalCompra');

        $compra->save();


        $detalles =  DetalleCompra::where('IdCompra', 0)->get();

        $total_cantidad = 0;

        foreach ( $detalles  as $key => $value) {
           $de = DetalleCompra::findOrFail($value->id);
           $de->IdCompra = $compra->id;

           $de->save();

           $total_cantidad += $de->Cantidad;

        }

        return redirect()->route('compras.index');
    }


    public function limpiar()
    {
        $detalles =  DetalleCompra::where('IdCompra', 0)->get();
        foreach ($detalles as $key => $value) {
            DB::delete('delete from detalle_compras where id = ?', [$value->id]);
        }

        return redirect()->route('compras.crear');
    }
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////

}
