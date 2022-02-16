<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index(){
        $cargo = Cargo::paginate(10);
        return view('cargos.raizcargos')->with('cargos', $cargo);
    }

    //funcion para crear o insertar datos
    public function crear(){
        return view('cargos.formularioCargo');
    }

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR
        $request->validate([
            'NombreCargo'=>'required',
            'DescripcionCargo'=>'required',
            'Sueldo'=>'required'
        ]);

        //Formulario
        $nuevoCargo = new Cargo();
        $nuevoCargo->NombreCargo = $request->input('NombreCargo');
        $nuevoCargo->DescripcionCargo = $request->DescripcionCargo;
        $nuevoCargo->Sueldo = $request->input('Sueldo');

        $creado = $nuevoCargo->save();

        if($creado){
            return redirect()->route('cargo.index')
                ->with('mensaje', 'El cargo fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

}
