<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use App\Models\Personal;
use App\Models\Precio;
use App\Models\Presentacion;
use App\Models\Producto;
use App\Models\Rango;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{

    public function index()
    {
        $clien = 0;
        $empleado = 0;
        $fechadesde = 0;
        $fechahasta = 0;
        $clientes = Cliente::all();
        $personal = Personal::all();
        $ventas = Venta::paginate(10);
        foreach ($ventas as $key => $value) {
            if ($value->cliente_id != null) {
                $value->clientes = Cliente::findOrFail($value->cliente_id);
            }
        }

        return view('Ventas.raizVentas', compact('clientes', 'ventas', 'personal', 'fechadesde', 'fechahasta', 'clien', 'empleado'));
    }
    
     public function reporte(Request $request)
    {
        $clientes = Cliente::all();
        $personal = Personal::all();
        $clien = $request->get('cliente');
        $empleado = $request->get('empleado');
        $fechadesde = $request->get('FechaDesde');
        $fechahasta = $request->get('FechaHasta');

        if ($fechadesde == '' && $clien != 0 && $empleado != 0) {
            if ($clien == 'a') {
                $clien = null;
            }
            $ventas = Venta::select('ventas.*')
                ->whereBetween('personal_id', [$empleado, $empleado])
                ->where('cliente_id', '=', $clien)
                ->paginate(15);
        } else {
            if ($fechadesde != '' && $clien == 0 && $empleado == 0) {
                $ventas = Venta::select('ventas.*')
                    ->whereBetween('FechaVenta', [$fechadesde, $fechahasta])
                    ->paginate(15);
            } else {
                if ($fechadesde != '' && $clien == 0 && $empleado != 0) {
                    $ventas = Venta::select('ventas.*')
                        ->whereBetween('FechaVenta', [$fechadesde, $fechahasta])
                        ->where('personal_id', '=', $empleado)
                        ->paginate(15);
                } else {
                    if ($fechadesde != '' && $clien != 0 && $empleado == 0) {
                        if ($clien == 'a') {
                            $clien = null;
                        }

                        $ventas = Venta::select('ventas.*')
                            ->whereBetween('FechaVenta', [$fechadesde, $fechahasta])
                            ->where('cliente_id', '=', $clien)
                            ->paginate(15);
                    } else {
                        if ($fechadesde == '' && $clien != 0 && $empleado == 0) {
                            if ($clien == 'a') {
                                $clien = null;
                            }

                            $ventas = Venta::select('ventas.*')
                                ->where('cliente_id', '=', $clien)
                                ->paginate(15);
                        } else {
                            if ($fechadesde == '' && $clien == 0 && $empleado != 0) {
                                $ventas = Venta::select('ventas.*')
                                    ->where('personal_id', '=', $empleado)
                                    ->paginate(15);
                            } else {
                                if ($clien == 'a') {
                                    $clien = null;
                                }

                                $ventas = Venta::select('ventas.*')
                                    ->whereBetween('FechaVenta', [$fechadesde, $fechahasta])
                                    ->where('personal_id', '=', $empleado)
                                    ->where('cliente_id', '=', $clien)
                                    ->paginate(15);
                            }
                        }
                    }
                }
            }
        }

        foreach ($ventas as $key => $value) {
            if ($value->cliente_id != null) {
                $value->clientes = Cliente::findOrFail($value->cliente_id);
            }
        }

        if ($fechadesde == '') {
            $fechadesde = 0;
        }
        if ($fechahasta == '') {
            $fechahasta = 0;
        }
        if ($clien == null) {
            $clien = '*';
        }

        return view('Ventas.raizVentas', compact('clientes', 'personal', 'ventas', 'fechadesde', 'fechahasta', 'clien', 'empleado'));
    }
   
    public function create()
    {
        $total_cantidad = 0;
        $total_precio = 0;
        $total_impuesto = 0;
        $now = now();

        $fac = DB::table('rangos')->where('FechaLimite', '>=', $now->format('Y-m-d'))->exists();
        if ($fac) {
            $fa = DB::table('rangos')->where('FechaLimite', '>=', $now->format('Y-m-d'))->get();
            foreach ($fa as $f) {
                $numfactura = $f->FacturaInicio;
            }
        } else {
            $numfactura = 0;
        }


        $facEx = DB::table('ventas')->where('NumFactura', '=', $numfactura)->exists();
        if ($facEx) {
            $venta = Venta::all();
            foreach ($venta as $v) {
                $numfactura = $v->NumFactura;
            }
            $numfactura += 1;
        }

        $detalles =  DetalleVenta::where('IdVenta', 0)->get();
        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
            $total_precio += ($value->Cantidad * $value->Precio_venta);
            $produc = Producto::findorFail($value->IdProducto);
            if ($produc->Impuesto == 0.15) {
                $total_impuesto += ($value->Cantidad * $value->Precio_venta) - (($value->Cantidad * $value->Precio_venta) / 1.15);
            }
        }

        $productos = Producto::all();
        $empleado = Personal::all();
        $cliente = Cliente::all();
        $categoria = Categoria::all();
        $presentacion = Presentacion::all();
        $precios = Precio::all();
        $inventarios = Inventario::all();

        return view('Ventas.formularioVentas')->with('detalles', $detalles)
            ->with('empleado', $empleado)
            ->with('cliente', $cliente)
            ->with('productos', $productos)
            ->with('presentacion', $presentacion)
            ->with('categoria', $categoria)
            ->with('total_cantidad', $total_cantidad)
            ->with('total_precio', $total_precio)
            ->with('total_impuesto', $total_impuesto)
            ->with('inventarios', $inventarios)
            ->with('numfactura', $numfactura)
            ->with('precios', $precios);
    }


    public function store(Request $request)
    {
        $max = 2;
        $now = now();
        $limite = DB::table('rangos')->where('FechaLimite', '>=', $now->format('Y-m-d'))->get();
        foreach ($limite as $l) {
            $max = $l->FacturaFin;
        }

        $request->validate([
            'NumFactura' => 'required|unique:ventas|numeric|min:1|max:' . ($max),
            'FechaVenta' => 'required|date|before:tomorrow|after:yesterday',
            'TotalVenta' => 'numeric|min:10.00',
        ], [
            'NumFactura.max' => 'El número de la factura sobrepasa el rango. Ingrese un nuevo rango',
            'NumFactura.min' => 'El rango de números de facturas ya sobrepaso la fecha limite de emisión. Ingrese un nuevo rango',
            'FechaVenta.before' => 'El campo fecha de venta debe de ser hoy',
            'FechaVenta.after' => 'El campo fecha de venta debe de ser hoy',
            'TotalVenta.min' => 'Ingrese detalles para esta venta',
        ]);


        $venta = new Venta();

        $venta->NumFactura = $request->input('NumFactura');
        $venta->personal_id = $request->input('Empleado');
        $venta->cliente_id = $request->input('Cliente');
        $venta->FechaVenta = $request->input('FechaVenta');
        $venta->TotalVenta = $request->input('TotalVenta');
        $venta->TotalImpuesto = $request->input('TotalImpuesto');
        $venta->save();

        $detalles =  DetalleVenta::where('IdVenta', 0)->get();

        $total_cantidad = 0;

        foreach ($detalles  as $key => $value) {
            $de = DetalleVenta::findOrFail($value->id);
            $de->IdVenta = $venta->id;

            $de->save();

            $total_cantidad += $de->Cantidad;
        }
        return redirect()->route('ventas.mostrar', ['id' => $venta->id]);
    }
    public function limpiar()
    {
        $detalles =  DetalleVenta::where('IdVenta', 0)->get();
        foreach ($detalles as $key => $value) {
            $inve =  Inventario::where('IdProducto', '=', $value->IdProducto)
                ->where('IdPresentacion', '=', $value->IdPresentacion)->firstOrFail();

            $inve->Existencia = $inve->Existencia + $value->Cantidad;

            $inve->save();

            DB::delete('delete from detalle_ventas where id = ?', [$value->id]);
        }

        return redirect()->route('ventas.crear');
    }

   
}
