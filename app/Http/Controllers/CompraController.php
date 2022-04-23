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

           $existe = DB::table('inventarios')->where('IdProducto', '=', $de->IdProducto)
                        ->where('IdPresentacion', '=', $de->IdPresentacion)->exists();

            if ($existe) {
                $inve =  Inventario::where('IdProducto', '=', $de->IdProducto)
                        ->where('IdPresentacion', '=', $de->IdPresentacion)->firstOrFail();

                $inve->Existencia = $inve->Existencia + $de->Cantidad;

                $inve->CostoPromedio = ($inve->CostoPromedio + $de->Precio_compra) / 2;

                $inve->save();
            } else {

                $inve = new Inventario();

                $inve->IdProducto = $de->IdProducto;

                $inve->IdPresentacion = $de->IdPresentacion;

                $inve->Existencia = $inve->Existencia + $de->Cantidad;

                $inve->CostoPromedio =  $de->Precio_compra;

                $inve->save();
            }

            $exis = DB::table('precios')->where('IdProducto', '=', $de->IdProducto)
                ->where('IdPresentación', '=', $de->IdPresentacion)->exists();

            if ($exis) {
                $pre =  Precio::where('IdProducto', '=', $de->IdProducto)
                    ->where('IdPresentación', '=', $de->IdPresentacion)->firstOrFail();

                $pre->Precio = $de->Precio_venta;

                $pre->save();
            } else {

                $pre = new Precio();

                $pre->IdProducto = $de->IdProducto;

                $pre->IdPresentación = $de->IdPresentacion;

                $pre->Precio = $de->Precio_venta;

                $pre->save();
            }

        }

        return redirect()->route('compras.index');
    }

    public function show($id)
    {
        $compra = Compra::findOrFail($id);
        $detalles =  DetalleCompra::where('IdCompra', $compra->id)->get();

        return view('Compras.verCompra')->with('compra',$compra)
        ->with('detalles',$detalles);
    }


    public function limpiar()
    {
        $detalles =  DetalleCompra::where('IdCompra', 0)->get();
        foreach ($detalles as $key => $value) {
            DB::delete('delete from detalle_compras where id = ?', [$value->id]);
        }

        return redirect()->route('compras.crear');
    }
    
    public function pdf($anio1, $anio2, $proveeforR)
    {
        $proveedor = Proveedor::findOrFail($proveeforR);
        $provee = $proveedor->EmpresaProveedora;

        $compras = DB::table('compras')
        ->select('compras.*')
        ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
        ->whereBetween('FechaCompra', [$anio1, $anio2])
        ->where('compras.proveedor_id', '=', $proveeforR)
        ->paginate(15);

        foreach ($compras as $key => $value) {
            $value->proveedors = Proveedor::findOrFail($value->proveedor_id);
        }

        $pdf = PDF::loadView('Compras.pdf', ['compras'=>$compras, 'provee'=>$provee]);
        return $pdf->stream(); 
        //return $pdf->download('__compras.pdf');
    }

}
