<?php

namespace App\Http\Controllers;
use Illuminate\Validation\Rule;

use App\Models\Cargo;
use App\Models\Personal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use withQueryString;

class PersonalController extends Controller
{

    public function index(){
        $texto = '';
        $personal = Personal::paginate(10);
        return view('Personal.raizpersonal')->with('personals', $personal)
                                            ->with('texto', $texto);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $personals = DB::table('Personals')
                        ->select('*')
                        ->where('IdentidadDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orwhere('NombresDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orwhere('ApellidosDelEmpleado', 'LIKE', '%'.$texto.'%')
                        ->orWhere('EmpleadoActivo', 'LIKE', $texto)
                        ->paginate(10)->withQueryString();
        return view('Personal.raizpersonal', compact('personals', 'texto'));
    }

    //funcion para mostrar
    public function show($id){
        $cargos = Cargo::all();
        $personal = Personal::findOrFail($id);
        return view('Personal.verPersonal', compact('cargos'))->with('personal', $personal);
    }

    //funcion para crear o insertar datos
    public function crear(){
        $cargos = Cargo::all();
        return view('Personal.formularioPersonal', compact('cargos'));
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
            'Teléfono'=>'required|unique:personals',
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
        return view('Personal.formularioEditarPersonal', compact('cargos'))->with('personal', $personal);

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
            'Teléfono'=>[
                'required',
                'max:8',
                Rule::unique('personals')->ignore($personal->id),
            ],
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
