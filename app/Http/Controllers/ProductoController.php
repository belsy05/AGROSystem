<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{


    public function index(){
        $producto = Producto::paginate(10);
        return view('Productos.raizproducto')->with('productos', $producto);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $personals = DB::table('Productos')
                        ->where('NombreDelProducto', 'LIKE', '%'.$texto.'%')
                        ->orwhere('NombreDeLaCategoría', 'LIKE', '%'.$texto.'%')
                        ->orwhere('CódigoDelProducto', 'LIKE', '%'.$texto.'%')
                        ->paginate(10);

        return view('Productos.raizproducto', compact('productos', 'texto'));
    }

    public function show($id){
        $producto = Producto::findOrFail($id);
        $categoriaId = $producto->categoria_id;
        $categorias = Categoria::findOrFail($categoriaId);
        return view('Productos.verProducto', compact('categorias'))->with('producto', $producto);
    }
    
    public function crear(){
        $categorias = Categoria::all();
        return view('Productos.formularioProducto', compact('categorias'));
    } 

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR
        $request->validate([
            'Categoria'=>'required',
            'CódigoDelProducto'=>'required|unique:productos|max:8',
            'NombreDelProducto'=>'required||max:20',
            'DescripciónDelProducto'=>'required|string|max:150|min:10',
            'PresentaciónDelProducto'=>'required|max:30',
            'Impuesto'=>'required|max:10',
            'FechaDeElaboración'=>'required|date',
            'FechaDeVencimiento'=>'required|date',
        ]);

        //Formulario
        $nuevoProducto = new Producto();
        $nuevoProducto->categorias_id = $request->categoria;
        $nuevoProducto->CódigoDelProducto = $request->input('CódigoDelProducto');
        $nuevoProducto->NombreDelProducto = $request->input('NombreDelProducto');
        $nuevoProducto->DescripciónDelProducto = $request->input('DescripciónDelProducto');
        $nuevoProducto->PresentaciónDelProducto = $request->input('PresentaciónDelProducto');
        $nuevoProducto->Impuesto = $request->input('Impuesto');
        $nuevoProducto->FechaDeElaboración = $request->input('FechaDeElaboración');
        $nuevoProducto->FechaDeVencimiento = $request->input('FechaDeVencimiento');
        $creado = $nuevoProducto->save();

        if($creado){
            return redirect()->route('producto.index')
                ->with('mensaje', 'El producto fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        } 
    }
}
