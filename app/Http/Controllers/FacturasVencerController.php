<?php

namespace App\Http\Controllers;

use App\Models\Compra;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacturasVencerController extends Controller
{
    public function index()
    {

        $fechalimite = date_add(now(), date_interval_create_from_date_string("7 days"));
        $compras = Compra::where('FechaPago', '<=', $fechalimite)->paginate(10);
        
        $id = 0;
        $fechadesde = now();
        $fechahasta = now();
        $proveedores = Proveedor::all();

        return view('Compras.facturasVencer', compact('proveedores', 'fechalimite' ,'compras', 'id', 'fechadesde', 'fechahasta'));
        
    }

    public function reporte(Request $request)
    {
        $fechalimite = date_add(now(), date_interval_create_from_date_string("7 days"));
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
            } else {
                $request->validate([
                    'FechaDesde' => '',
                    'FechaHasta' => 'after_or_equal:FechaDesde',
                ]);
    
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->whereBetween('FechaCompra', [$fechadesde, $fechahasta])
                    ->where('FechaPago', '<=', $fechalimite)
                    ->paginate(15)->withQueryString();
            }
        } else {
            if ($fechadesde == '') {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->where('compras.proveedor_id', '=', $id)
                    ->where('FechaPago', '<=', $fechalimite)
                    ->paginate(15)->withQueryString();

                $fechadesde = 0;
                $fechahasta = 0;
            } else {
                $compras = DB::table('compras')
                    ->select('compras.*')
                    ->join('proveedors', 'proveedors.id', '=', 'compras.proveedor_id')
                    ->whereBetween('FechaCompra', [$fechadesde, $fechahasta])
                    ->where('compras.proveedor_id', '=', $id)
                    ->where('FechaPago', '<=', $fechalimite)
                    ->paginate(15)->withQueryString();
            }
        }

        foreach ($compras as $key => $value) {
            $value->proveedors = Proveedor::findOrFail($value->proveedor_id);
        }

        return view('Compras.facturasVencer', compact('proveedores', 'compras', 'id', 'fechadesde', 'fechahasta'));
    }
    
}