<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use App\Http\Requests\StoreInventarioRequest;
use App\Http\Requests\UpdateInventarioRequest;
use App\Models\Categoria;
use App\Models\DetalleCompra;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Inventario::paginate(10);

        foreach ($inventarios as $key => $value) {
            $value->producto = Producto::findOrFail($value->IdProducto);
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
            $value->categoria = Categoria::findOrFail($value->producto->categoria_id);
        }

        return view('Inventario.raizInventario')->with('inventarios', $inventarios);
    }

    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $inventarios = Inventario::whereRaw('(SELECT NombreDelProducto 
                    FROM productos WHERE productos.id = inventarios.IdProducto) LIKE "%'.$texto.'%"')
                    ->orwhereRaw('(SELECT NombreDeLaCategoría
                                    FROM categorias  JOIN productos ON categorias.id = productos.categoria_id
                                    WHERE productos.id = inventarios.IdProducto ) LIKE "%'.$texto.'%"')
                    ->paginate(10);

        foreach ($inventarios as $key => $value) {
            $value->producto = Producto::findOrFail($value->IdProducto);
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
            $value->categoria = Categoria::findOrFail($value->producto->categoria_id);
        }

        return view('Inventario.raizInventario')->with('inventarios', $inventarios)->with('texto', $texto);
    }

    

    public function precios($id, $presentacion){
        $producto = Producto::findOrFail($id);
        $nombre = $producto->NombreDelProducto;
        $precios = DB::table('detalle_compras')
        ->join('compras', 'compras.id', '=', 'detalle_compras.IdCompra')
        ->where('IdProducto', '=', $id)
        ->where('IdPresentacion', '=', $presentacion)
        ->select('compras.FechaCompra', 'detalle_compras.IdPresentacion', 'detalle_compras.Precio_compra')
        ->paginate(10);

        foreach ($precios as $key => $value) {
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
        }

        return view('Inventario.precios', compact('precios', 'nombre'));
    }

    public function detalles($id, $presentacion){
        $producto = Producto::findOrFail($id);
        $nombre = $producto->NombreDelProducto;
        $precios = DB::table('precios')
        ->where('IdProducto', '=', $id)
        ->where('IdPresentación', '=', $presentacion)
        ->paginate(10);


        foreach ($precios as $key => $value) {
            $value->presentacion = Presentacion::findOrFail($value->IdPresentación);
        }

        //////////////////////////////////////////////////////////////////////////


        $vencimientos = DB::table('detalle_compras')
        ->where('IdProducto', '=', $id)
        ->where('IdPresentacion', '=', $presentacion)
        ->whereMonth('fecha_vencimiento', '>=', now())
        ->orderBy('fecha_vencimiento', 'asc')
        ->paginate(10);

        foreach ($vencimientos as $key => $value) {
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
        }

        return view('Inventario.detalles', compact('precios', 'nombre', 'vencimientos'));
    }

}
