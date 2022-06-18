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
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    public function index()
    {
        $id = 0;
        $fechadesde = 0;
        $fechahasta = 0;
        $proveedores = Proveedor::all();
        $compras = Compra::paginate(10);

        return view('Compras.raizCompras', compact('proveedores', 'compras', 'id', 'fechadesde', 'fechahasta'));
    }

    public function reporte(Request $request)
    {
        $proveedores = Proveedor::all();
        $id = $request->get('id');
        $fechadesde = $request->get('FechaDesde');
        $fechahasta = $request->get('FechaHasta');


        if ($id == 0) {
            if ($fechadesde == '' && $fechahasta == '') {
                $request->validate([
                    
                ]);
                $rules = [
                    'id' => 'required|numeric|min:1',
                    'FechaDesde' => 'required',
                    'FechaHasta' => 'required',
                ];
        
                $mensaje = [
                    'id.min' => 'Seleccione un proveedor o',
                    'FechaDesde.required' => 'ingrese una fecha de inicio y',
                    'FechaHasta.required' => 'una fecha de fin',
                ];
                $this->validate($request, $rules, $mensaje);

                $fechadesde = 0;
                $fechahasta = 0;
            } else {
                $request->validate([
                    'FechaDesde' => '',
                    'FechaHasta' => 'after_or_equal:FechaDesde',
                ]);
    
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->whereBetween('FechaCompra', [$fechadesde, $fechahasta])
                    ->paginate(15)->withQueryString();
            }
        } else {
            if ($fechadesde == '') {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->where('compras.proveedor_id', '=', $id)
                    ->paginate(15)->withQueryString();

                $fechadesde = 0;
                $fechahasta = 0;
            } else {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->whereBetween('FechaCompra', [$fechadesde, $fechahasta])
                    ->where('compras.proveedor_id', '=', $id)
                    ->paginate(15)->withQueryString();
            }
        }

        foreach ($compras as $key => $value) {
            $value->proveedors = Proveedor::findOrFail($value->proveedor_id);
        }

        return view('Compras.raizCompras', compact('proveedores', 'compras', 'id', 'fechadesde', 'fechahasta'));
    }

    public function create($proveedors=0)
    {
        $total_cantidad = 0;
        $total_precio = 0;
        $total_impuesto = 0;

        $detalles =  DetalleCompra::where('IdCompra', 0)->get();
        foreach ($detalles  as $key => $value) {
            $total_cantidad += $value->Cantidad;
            $total_precio += ($value->Cantidad * $value->Precio_compra);
            $produc = Producto::findorFail($value->IdProducto);
            if($produc->Impuesto == 0.15){
                $total_impuesto += ($value->Cantidad * $value->Precio_compra)-(($value->Cantidad * $value->Precio_compra)/1.15);
            }
        }

        $prov = Proveedor::find($proveedors);
        $productos = Producto::all();
        $proveedor = Proveedor::all();
        $categoria = Categoria::all();
        $presentacion = Presentacion::all();

        return view('Compras.formularioCompras')->with('detalles', $detalles)
            ->with('prov', $prov)
            ->with('proveedors', $proveedors)
            ->with('productos', $productos)
            ->with('proveedor', $proveedor)
            ->with('presentacion', $presentacion)
            ->with('categoria', $categoria)
            ->with('total_cantidad', $total_cantidad)
            ->with('total_precio', $total_precio)
            ->with('total_impuesto', $total_impuesto);
    }

    public function store(Request $request) {


        if ($request->PagoCompra == 0){
            $request->validate([
                'FechaCompra' => 'required|date|before:tomorrow',
                'TotalCompra' => 'numeric|min:10.00',
            ], [
                'FechaCompra.before' => 'El campo fecha de compra debe de ser anterior al dia de mañana',
                'TotalCompra.min' => 'Ingrese detalles para esta compra',
            ]);
        }else{
            $request->validate([
                'FechaCompra' => 'required|date|before:tomorrow',
                'FechaPago' => 'required|date|after:today',
                'TotalCompra' => 'numeric|min:10.00',
            ], [
                'FechaCompra.before' => 'El campo fecha de compra debe de ser anterior al dia de mañana',
                'FechaPago.after' => 'El campo fecha de pago debe de ser después de hoy',
                'TotalCompra.min' => 'Ingrese detalles para esta compra',
            ]);    
        }

              $compra = new Compra();

        $compra->NumFactura = $request->input('NumFactura');
        $compra->proveedor_id = $request->input('Proveedor');
        $compra->FechaCompra = $request->input('FechaCompra');
        $compra->FechaPago = $request->input('FechaPago');
        $compra->PagoCompra = $request->input('PagoCompra');
        $compra->TotalCompra = $request->input('TotalCompra');
        $compra->TotalImpuesto = $request->input('TotalImpuesto');
        $compra->save();

        $detalles =  DetalleCompra::where('IdCompra', 0)->get();

        $total_cantidad = 0;

        foreach ($detalles  as $key => $value) {
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

        return view('Compras.verCompra')->with('compra', $compra)
            ->with('detalles', $detalles);
    }

    public function show2($id)
    {
        $compra = Compra::findOrFail($id);
        $detalles =  DetalleCompra::where('IdCompra', $compra->id)->get();

        return view('Compras.verCompra2')->with('compra', $compra)
            ->with('detalles', $detalles);
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

    public function pdf($anio1, $anio2, $proveeforR)
    {

        if ($proveeforR == 0) {
            if ($anio1 == 0 && $anio2 == 0) {
                $compras = DB::table('compras')
                ->select('compras.*')
                ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                ->paginate(15);
                $provee = 0;
            } else {
                $compras = DB::table('compras')
                ->select('compras.*')
                ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                ->whereBetween('FechaCompra', [$anio1, $anio2])
                ->paginate(15);
                $provee = 0;
            }
        } else {
            if ($anio1 == 0) {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->where('compras.proveedor_id', '=', $proveeforR)
                    ->paginate(15);
            } else {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->whereBetween('FechaCompra', [$anio1, $anio2])
                    ->where('compras.proveedor_id', '=', $proveeforR)
                    ->paginate(15);
            }
            $proveedor = Proveedor::findOrFail($proveeforR);
            $provee = $proveedor->EmpresaProveedora;
        }

        foreach ($compras as $key => $value) {
            $value->proveedors = Proveedor::findOrFail($value->proveedor_id);
        }

        $pdf = PDF::loadView('compras.pdf', ['compras' => $compras, 'provee' =>$provee, 'anio1'=>$anio1, 'anio2'=>$anio2]);
        return $pdf->stream();
        //return $pdf->download('__compras.pdf');
    }

    public function edit($id)
    {
        $productos = Producto::all();
        $compra = Compra::findOrFail($id);
        $detalles =  DetalleCompra::where('IdCompra', $compra->id)->get();
        $total_precio = 0;
        foreach ($detalles  as $key => $value) {
            $total_precio += ($value->Cantidad * $value->Precio_compra);
        }


        return view('Compras.formularioEditCompras')->with('compra', $compra)
            ->with('detalles', $detalles)
            ->with('total_precio', $total_precio)
            ->with('productos', $productos);
    }
}