<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;

class PersonalController extends Controller
{

    public function index(){
        $personal = Personal::paginate(10);
        return view('raizpersonal')->with('personals', $personal);
    }

    //funcion para la barra
    public function index2(Request $request){
        
        $texto =trim($request->get('texto'));

        if($texto == 'Activo'){
            $texto = 1;
        }else if(($texto == 'Inactivo')){
            $texto = 0;
        }

        $personals = DB::table('Personals')
                        ->where('NombrePersonal', 'LIKE', '%'.$texto.'%')
                        ->where('ApellidoPersonal', 'LIKE', '%'.$texto.'%')
                        ->orWhere('EmpleadoActivo', '=', $texto)
                        ->paginate(10);
        return view('buscarPersonal', compact('personals', 'texto'));
    }

    //funcion para mostrar
    public function show($id){
        $cargos = Cargo::all();
        $personal = Personal::findOrFail($id);
        return view('verPersonal', compact('cargos'))->with('personal', $personal);
    }

    //funcion para crear o insertar datos
    public function crear(){
        $cargos = Cargo::all();
        return view('formularioPersonal', compact('cargos'));
    }

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR
        $request->validate([
            'Cargo'=>'required',
            'IdentidadPersonal'=>'required|unique:personals',
            'NombrePersonal'=>'required',
            'ApellidoPersonal'=>'required',
            'CorreoElectronico'=>'required|email|unique:personals',
            'Telefono'=>'required',
            'FechaNacimiento'=>'required',
            'Ciudad'=>'required',
            'Direccion'=>'required'
        ]);

        //Formulario
        $nuevoPersonal = new Personal();
        $nuevoPersonal->cargo_id = $request->Cargo;
        $nuevoPersonal->IdentidadPersonal = $request->input('IdentidadPersonal');
        $nuevoPersonal->NombrePersonal = $request->input('NombrePersonal');
        $nuevoPersonal->ApellidoPersonal = $request->input('ApellidoPersonal');
        $nuevoPersonal->CorreoElectronico = $request->input('CorreoElectronico');
        $nuevoPersonal->Telefono = $request->input('Telefono');
        $nuevoPersonal->FechaNacimiento = $request->input('FechaNacimiento');
        $nuevoPersonal->FechaIngreso = $request->input('FechaIngreso');
        $nuevoPersonal->Ciudad = $request->input('Ciudad');
        $nuevoPersonal->Direccion = $request->input('Direccion');
        $creado = $nuevoPersonal->save();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El empleado fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    
}