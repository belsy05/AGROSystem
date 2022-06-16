<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Models\Inventario;
use App\Models\Precio;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CotizacionController extends Controller
{

    public function create()  {
        
        $total_cantidad = 0;
        $total_precio = 0;
        $total_impuesto = 0;

        $detalles =  DetalleCotizacion::where('IdCotizacion', 0)->get();
        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
            $total_precio += ($value->Cantidad * $value->Precio_venta);
            $produc = Producto::findorFail($value->IdProducto);
            if ($produc->Impuesto == 0.15) {
                $total_impuesto += ($value->Cantidad * $value->Precio_venta) * 0.15;
            }
        }

        $productos = Producto::all();
        $categoria = Categoria::all();
        $presentacion = Presentacion::all();
        $precios = Precio::all();
        $inventarios = Inventario::all();

        return view('Ventas.cotizacionCliente')->with('detalles', $detalles)
            ->with('productos', $productos)
            ->with('presentacion', $presentacion)
            ->with('categoria', $categoria)
            ->with('total_cantidad', $total_cantidad)
            ->with('total_precio', $total_precio)
            ->with('total_impuesto', $total_impuesto)
            ->with('inventarios', $inventarios)
            ->with('precios', $precios);
    }


    public function limpiar()
    {
        $detalles =  DetalleCotizacion::where('IdCotizacion', 0)->get();
        foreach ($detalles as $key => $value) {
            $inve =  Inventario::where('IdProducto', '=', $value->IdProducto)
                ->where('IdPresentacion', '=', $value->IdPresentacion)->firstOrFail();
                
            DB::delete('delete from detalle_cotizacions where id = ?', [$value->id]);
        }

        return redirect()->route('cotizaciones.crear');
    }
}
