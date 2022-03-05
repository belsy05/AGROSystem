<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function crear(){
        return view('categorias.formularioCategoria');
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
}
