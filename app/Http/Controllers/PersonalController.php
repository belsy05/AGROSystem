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

    //funcion para editar los datos
    public function edit($id){
        $cargos = Cargo::all();
        $personal = Personal::findOrFail($id);
        return view('formularioEditarPersonal', compact('cargos'))->with('personal', $personal);

    }

    //funcion para actualizar los datos
    public function update(Request $request, $id){

        $personal = Personal::findOrFail($id);

        $request->validate([
            'Cargo'=>'required',
            'IdentidadDelEmpleado'=> [
                'required',
                'max:13',
                Rule::unique('personals')->ignore($personal->id),
            ],
            'NombresDelEmpleado'=>'required|max:30',
            'ApellidosDelEmpleado'=>'required|max:40',
            'CorreoElectrónico'=> [
                'required',
                'email',
                'max:40',
                Rule::unique('personals')->ignore($personal->id),
            ],
            'Teléfono'=>'required|max:8',
            'FechaDeNacimiento'=>'required|date',
            'FechaDeIngreso'=>'required|date',
            'Ciudad'=>'required|max:20',
            'Dirección'=>'required|max:150'
        ]);

        $personal->cargo_id = $request->Cargo;
        $personal->IdentidadDelEmpleado = $request->input('IdentidadDelEmpleado');
        $personal->NombresDelEmpleado = $request->input('NombresDelEmpleado');
        $personal->ApellidosDelEmpleado = $request->input('ApellidosDelEmpleado');
        $personal->CorreoElectrónico = $request->input('CorreoElectrónico');
        $personal->Teléfono = $request->input('Teléfono');
        $personal->FechaDeNacimiento = $request->input('FechaDeNacimiento');
        $personal->FechaDeIngreso = $request->input('FechaDeIngreso');
        $personal->Ciudad = $request->input('Ciudad');
        $personal->Dirección = $request->input('Dirección');

        $creado = $personal->update();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El empleado fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    public function updateStatus($id){
        $personal = Personal::findOrFail($id);

        if($personal->EmpleadoActivo == 'Activo'){
            $personal->EmpleadoActivo = 'Inactivo';
        }
        else if(($personal->EmpleadoActivo == 'Inactivo')){
            $personal->EmpleadoActivo = 'Activo';
        }

        $creado = $personal->save();

        if($creado){
            return redirect()->route('personal.index')
                ->with('mensaje', 'El estado fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }

    }

}
