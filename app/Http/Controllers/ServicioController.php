<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Cliente;
use App\Models\Personal;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ServicioController extends Controller
{

    public function index(){
        $texto = '';
        $servicio = Servicio::paginate(10);
        foreach ($servicio as $key => $value) {
            $value->personal = Personal::findOrFail($value->empleado_id);
            $value->cliente = Cliente::findOrFail($value->cliente_id);
        }
        return view('Servicios.raizservicio')->with('servicios', $servicio)
                                            ->with('texto', $texto);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $servicios = DB::table('Servicios')
                        ->select('*')
                        ->orwhere('NombresDelCliente', 'LIKE', '%'.$texto.'%')
                        ->orwhere('ApellidosDelCliente', 'LIKE', '%'.$texto.'%')
                        ->paginate(10)->withQueryString();
        return view('Servicios.raizservicio', compact('servicios', 'texto'));
    }

    //funcion para mostrar
    public function show($id){
        $servicio = Servicio::findOrFail($id);
        $id = $servicio->empleado_id;
        
        $cargo = Cargo::select('cargos.*')
        ->join('personals', 'cargos.id', '=', 'personals.cargo_id')
        ->where('personals.id', '=', $id)
        ->get();
        return view('Servicios.verServicio', compact('cargo'))->with('servicio', $servicio);
    }

    //funcion para crear o insertar datos
    public function crear(){
        $personals = Personal::select('personals.*', 'cargos.NombreDelCargo')
            ->join('cargos', 'cargos.id', '=', 'personals.cargo_id')
            ->where('NombreDelCargo', 'like', '%tecnico%')
            ->get();

        $clientes = Cliente::all();

        return view('Servicios.formularioServicio', compact('personals', 'clientes'));
    }

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR
        $request->validate([
            'tecnico'=>'required',
            'Cliente'=>'required',
            'Teléfono'=>'required',
            'FechaDeRealizacion'=>'required|date',
            'DescripciónDelServicio'=>'required|string|max:200|min:5',
            'Dirección'=>'required|max:150'
        ]);

        //Formulario
        $nuevoServicio = new Servicio();
        $nuevoServicio->empleado_id = $request->tecnico;
        $nuevoServicio->cliente_id = $request->Cliente;
        $nuevoServicio->TeléfonoCliente = $request->input('Teléfono');
        $nuevoServicio->FechaDeRealizacion = $request->input('FechaDeRealizacion');
        $nuevoServicio->Dirección = $request->input('Dirección');
        $nuevoServicio->DescripciónDelServicio = $request->DescripciónDelServicio;
        $creado = $nuevoServicio->save();

        if($creado){
            return redirect()->route('servicio.index')
                ->with('mensaje', 'El servicio técnico fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    //funcion para editar los datos
    public function edit($id){
        $cargos = Cargo::all();
        $servicio = Servicio::findOrFail($id);
        return view('Servicios.formularioEditarServicio', compact('cargos'))->with('servicio', $servicio);

    }

    //funcion para actualizar los datos
    public function update(Request $request, $id){

        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'Cargo'=>'required',
            'NombresDelCliente'=>'required|max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'NombresDelTecnico'=>'required|max:30',
            'ApellidosDelTecnico'=>'required|max:40',
            'Teléfono'=>[
                'required',
                'max:8',
                Rule::unique('servicios')->ignore($servicio->id),
            ],
            'FechaDeRealizacion'=>'required|date',
            'Dirección'=>'required|max:150',
            'DescripciónDelServicio'=>'required|string|max:200|min:5'
        ]);

        $servicio->cargo_id = $request->Cargo;
        $servicio->NombresDelCliente = $request->input('NombresDelCliente');
        $servicio->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $servicio->NombresDelTecnico = $request->input('NombresDelTecnico');
        $servicio->ApellidosDelTecnico = $request->input('ApellidosDelTecnico');
        $servicio->Teléfono = $request->input('Teléfono');
        $servicio->FechaDeRealizacion = $request->input('FechaDeRealizacion');
        $servicio->Dirección = $request->input('Dirección');
        $servicio->DescripciónDelServicio = $request->DescripciónDelServicio;

        $creado = $servicio->update();

        if($creado){
            return redirect()->route('servicio.index')
                ->with('mensaje', 'El servicio técnico fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

    public function updateStatus($id){
        $servicio = Servicio::findOrFail($id);

        if($servicio->Estado == 'Sin realizar'){
            $servicio->Estado = 'Realizado';
        }

        $creado = $servicio->save();

        if($creado){
            return redirect()->route('servicio.index')
                ->with('mensaje', 'El estado fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }

    }
}
