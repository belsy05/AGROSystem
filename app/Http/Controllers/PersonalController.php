<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

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

        $personals = DB::table('Personals')
                        ->where('IdentidadDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orwhere('NombresDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orwhere('ApellidosDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orWhere('EmpleadoActivo', 'LIKE', $texto)
                        ->paginate(10);
        return view('raizPersonal', compact('personals', 'texto'));
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
            'IdentidadDelEmpleado'=>'required|unique:personals|max:13',
            'NombresDelEmpleado'=>'required||max:30',
            'ApellidosDelEmpleado'=>'required|max:40',
            'CorreoElectrónico'=>'required|email|unique:personals|max:40',
            'Teléfono'=>'required',
            'FechaDeNacimiento'=>'required|date',
            'FechaDeIngreso'=>'required|date',
            'Ciudad'=>'required|max:20',
            'Dirección'=>'required|max:150'
        ]);

        //Formulario
        $nuevoPersonal = new Personal();
        $nuevoPersonal->cargo_id = $request->Cargo;
        $nuevoPersonal->IdentidadDelEmpleado = $request->input('IdentidadDelEmpleado');
        $nuevoPersonal->NombresDelEmpleado = $request->input('NombresDelEmpleado');
        $nuevoPersonal->ApellidosDelEmpleado = $request->input('ApellidosDelEmpleado');
        $nuevoPersonal->CorreoElectrónico = $request->input('CorreoElectrónico');
        $nuevoPersonal->Teléfono = $request->input('Teléfono');
        $nuevoPersonal->FechaDeNacimiento = $request->input('FechaDeNacimiento');
        $nuevoPersonal->FechaDeIngreso = $request->input('FechaDeIngreso');
        $nuevoPersonal->Ciudad = $request->input('Ciudad');
        $nuevoPersonal->Dirección = $request->input('Dirección');
        $creado = $nuevoPersonal->save();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El empleado fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }