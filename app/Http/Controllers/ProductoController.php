<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoController extends Controller
{
    public function index(){
        $producto = Producto::paginate(10);
        return view('Productos.raizproducto')->with('productos', $producto);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $producto = Producto::where('NombreDelProducto', 'LIKE', '%'.$texto.'%',)
                    ->orwhereRaw('(SELECT NombreDeLaCategoría
                                    FROM categorias WHERE categorias.id = productos.categoria_id ) LIKE "%'.$texto.'%"')
                    ->paginate(10);
        return view('Productos.raizproducto')->with('productos', $producto)->with('texto', $texto);
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

     public function store(Request $request){
        //VALIDAR
        $request->validate([
            'Categoria'=>'required',
            'NombreDelProducto'=>'required|unique:productos|string|max:40|min:5',
            'DescripciónDelProducto'=>'required|string|max:150|min:10',
            'PresentaciónDelProducto'=>'required|max:30'
        ]);

        //Formulario
        $nuevoProducto = new Producto();
        $nuevoProducto->categoria_id = $request->Categoria;
        $nuevoProducto->NombreDelProducto = $request->input('NombreDelProducto');
        $nuevoProducto->DescripciónDelProducto = $request->input('DescripciónDelProducto');
        $nuevoProducto->Impuesto = $request->Impuesto;
        $creado = $nuevoProducto->save();

        if($creado){
            return redirect()->route('producto.index')
                ->with('mensaje', 'El producto fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        } 
    }
    
    public function crear2(){
        $categorias = Categoria::all();
        return view('Compras.formularioProducto', compact('categorias'));
    } 

    public function store2(Request $request){
        //VALIDAR
        $request->validate([
            'Categoria'=>'required',
            'NombreDelProducto'=>'required|unique:productos|string|max:40',
            'DescripciónDelProducto'=>'required|string|max:150|min:10'
        ]);

        //Formulario
        $nuevoProducto = new Producto();
        $nuevoProducto->categoria_id = $request->Categoria;
        $nuevoProducto->NombreDelProducto = $request->input('NombreDelProducto');
        $nuevoProducto->DescripciónDelProducto = $request->input('DescripciónDelProducto');
        $nuevoProducto->Impuesto = $request->Impuesto;
        $creado = $nuevoProducto->save();

        if($creado){
            return redirect()->route('compras.crear')
                ->with('mensaje', 'El producto fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        } 
    }

    //funcion para editar los datos
    public function edit($id){
        $categorias = Categoria::all();
        $producto = Producto::findOrFail($id);
        return view('Productos.formularioEditarProducto', compact('categorias'))->with('producto', $producto);
    }


    //funcion para editar los datos
    public function update(Request $request, $id){

        $producto = Producto::findOrFail($id);

        $request->validate([
            'Categoria'=>'required',
            'NombreDelProducto'=> [
                'required',
                'max:40',
                'min:5',
                Rule::unique('productos')->ignore($producto->id),
            ],    
            'DescripciónDelProducto'=>'required|string|max:150|min:10',
            'PresentaciónDelProducto'=>'required|max:60'
        ]);

        //Formulario
        $producto->categoria_id = $request->input('Categoria');
        $producto->NombreDelProducto = $request->input('NombreDelProducto');
        $producto->DescripciónDelProducto = $request->input('DescripciónDelProducto');
        $producto->PresentaciónDelProducto = $request->input('PresentaciónDelProducto');
        $producto->Impuesto= $request->Impuesto;
        $creado = $producto->save();

        if($creado){
            return redirect()->route('producto.index')
                ->with('mensaje', 'El producto fue actualizado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }
}
