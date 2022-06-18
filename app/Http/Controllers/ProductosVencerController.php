<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Presentacion;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductosVencerController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventarios = Inventario::where('Existencia', '<=', 10)
                                   ->paginate(10);

        foreach ($inventarios as $key => $value) {
            $value->producto = Producto::findOrFail($value->IdProducto);
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
            $value->categoria = Categoria::findOrFail($value->producto->categoria_id);
        }

        return view('Inventario.productosVencer')->with('inventarios', $inventarios);
    }

    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $inventarios = Inventario::whereRaw('(SELECT NombreDelProducto 
                    FROM productos WHERE productos.id = inventarios.IdProducto) LIKE "%'.$texto.'%"')
                    ->orwhereRaw('(SELECT NombreDeLaCategoría
                                    FROM categorias  JOIN productos ON categorias.id = productos.categoria_id
                                    WHERE productos.id = inventarios.IdProducto ) LIKE "%'.$texto.'%"')
                    ->paginate(10)->withQueryString();

        foreach ($inventarios as $key => $value) {
            $value->producto = Producto::findOrFail($value->IdProducto);
            $value->presentacion = Presentacion::findOrFail($value->IdPresentacion);
            $value->categoria = Categoria::findOrFail($value->producto->categoria_id);
        }

        return view('Inventario.productosVencer')->with('inventarios', $inventarios)->with('texto', $texto);
    }
}