<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoriaController extends Controller
{
    public function index(){
        $categoria = Categoria::paginate(10);
        return view('Categorias.raizcategorias')->with('categorias', $categoria);
    }

    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $categorias = DB::table('Categorias')
                        ->where('NombreDeLaCategoría', 'LIKE', '%'.$texto.'%')
                        ->paginate(10);
        return view('Categorias.raizcategorias', compact('categorias', 'texto'));
    }

    public function crear(){
        return view('Categorias.formularioCategoria');
    }

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR
        $request->validate([
            'NombreDeLaCategoría'=>'required|unique:categorias|string|max:40|min:5',
            'DescripciónDeLaCategoría'=>'required|string|max:150|min:5'
        ]);

        //Formulario
        $nuevaCategoria = new Categoria();
        $nuevaCategoria->NombreDeLaCategoría = $request->input('NombreDeLaCategoría');
        $nuevaCategoria->DescripciónDeLaCategoría = $request->DescripciónDeLaCategoría;

        $creado = $nuevaCategoria->save();

        if($creado){
            return redirect()->route('categoria.index')
                ->with('mensaje', 'La categoría fue creada exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    //funcion para editar los datos
    public function edit($id){
        $categoria = Categoria::findOrFail($id);
        return view('categorias.formularioEditarCategoria')->with('categoria', $categoria);

    }

     //funcion para actualizar los datos
     public function update(Request $request, $id){

        $categoria = Categoria::findOrFail($id);
        $request->validate([
            'NombreDeLaCategoría'=> [
                'required',
                'string',
                'max:40',
                'min:5',
                Rule::unique('categorias')->ignore($categoria->id),
            ],
            'DescripciónDeLaCategoría'=>'required|string|max:150',
        ]);


        $categoria->NombreDeLaCategoría = $request->input('NombreDeLaCategoría');
        $categoria->DescripciónDeLaCategoría = $request->DescripciónDeLaCategoría;

        $creado = $categoria->save();

        if($creado){
            return redirect()->route('categoria.index')
                ->with('mensaje', 'La categoría fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }
}
