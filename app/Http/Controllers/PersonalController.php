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

    //funcion para editar los datos
    public function edit($id){
        $cargos = Cargo::all();
        $personal = Personal::findOrFail($id);
        return view('formularioEditarPersonal', compact('cargos'))->with('personal', $personal);

    }

    //funcion para actualizar los datos
    public function update(Request $request, $id){

        $request->validate([
            'Cargo'=>'required|integer',
            'IdentidadPersonal'=>'required|max:255',
            'NombrePersonal'=>'required|max:255',
            'ApellidoPersonal'=>'required|max:255',
            'CorreoElectronico'=>'required|email|max:255',
            'Telefono'=>'required|max:255',
            'FechaNacimiento'=>'required|date',
            'FechaIngreso'=>'required|date',
            'Ciudad'=>'required|max:255',
            'Direccion'=>'required|max:255'
        ]);

        $personal = Personal::findOrFail($id);;
        $personal->cargo_id = $request->Cargo;
        $personal->IdentidadPersonal = $request->input('IdentidadPersonal');
        $personal->NombrePersonal = $request->input('NombrePersonal');
        $personal->ApellidoPersonal = $request->input('ApellidoPersonal');
        $personal->CorreoElectronico = $request->input('CorreoElectronico');
        $personal->Telefono = $request->input('Telefono');
        $personal->FechaNacimiento = $request->input('FechaNacimiento');
        $personal->FechaIngreso = $request->input('FechaIngreso');
        $personal->Ciudad = $request->input('Ciudad');
        $personal->Direccion = $request->input('Direccion');

        $creado = $personal->save();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El empleado fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    public function updateStatus($id){
        //  $personal = Personal::findOrFail($request->id);
        $personal = Personal::findOrFail($id);
       /* if ($request->EmpleadoActivo == 0) {
            $newStatus = false;
        } else {
            $newStatus = true;
        }
        return response()->json(['var'=>$newStatus]); */

        if($personal->EmpleadoActivo == 1){
            $personal->EmpleadoActivo = false;
        }
        else if(($personal->EmpleadoActivo == 0)){
            $personal->EmpleadoActivo = true;
        }

        $creado = $personal->save();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El empleado fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }

    }

}
