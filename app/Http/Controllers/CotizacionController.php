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

    public function store(Request $request)
    {

        $request->validate([
            'TotalVenta' => 'numeric|min:1.00',
        ], [
            'TotalVenta.min' => 'Ingrese detalles para esta venta',
        ]);
        
        $fecha = now()->format('Y-m-d');

        $venta = new Cotizacion();
        
        $venta->FechaVenta = $fecha;
        $venta->TotalVenta = $request->input('TotalVenta');
        $venta->TotalImpuesto = $request->input('TotalImpuesto');
        $venta->save();

        $detalles =  DetalleCotizacion::where('IdCotizacion', 0)->get();

        $total_cantidad = 0;

        foreach ($detalles  as $key => $value) {
            $de = DetalleCotizacion::findOrFail($value->id);
            $de->IdCotizacion = $venta->id;

            $de->save();

            $total_cantidad += $de->Cantidad;
        }
        return redirect()->route('cotizaciones.mostrar', ['id' => $venta->id]);
    }

    public function show($id)
    {
        $venta = Cotizacion::findOrFail($id);
        $detalles =  DetalleCotizacion::where('IdCotizacion', $venta->id)->get();

        return view('Ventas.verCotizacion')->with('venta', $venta)
            ->with('detalles', $detalles);
    }

    public function limpiar()
    {
        $detalles =  DetalleCotizacion::where('IdCotizacion', 0)->get();
        foreach ($detalles as $key => $value) {

            DB::delete('delete from detalle_cotizacions where id = ?', [$value->id]);
        }

        return redirect()->route('cotizaciones.crear');
    }
}