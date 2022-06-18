<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ClienteController extends Controller
{
    public function index(){
        $cliente = Cliente::paginate(10);
        return view('Clientes.raizcliente')->with('clientes', $cliente);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $clientes = DB::table('clientes')
                        ->where('NombresDelCliente', 'LIKE', '%'.$texto.'%')
                        ->orwhere('ApellidosDelCliente', 'LIKE', '%'.$texto.'%')
                        ->orwhere('IdentidadDelCliente', 'LIKE', '%'.$texto.'%')
                        ->orwhere('LugarDeProcedencia', 'LIKE', '%'.$texto.'%')
                        ->paginate(10)->withQueryString();
        return view('Clientes.raizcliente', compact('clientes', 'texto'));
    }

    public function show($id){
        $cliente = Cliente::findOrFail($id);
        return view('Clientes.verClientes')->with( 'cliente', $cliente);
    }

    public function crear(){
        return view('Clientes.formularioCliente');
    }

    //funcion para guardar los datos creados o insertados
    public function store(Request $request){
        //VALIDAR

        $request->validate([
            'IdentidadDelCliente'=>'required|unique:clientes|max:15',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'nullable|max:8|unique:clientes',
            'LugarDeProcedencia'=>'required|max:120'
        ], [
            'IdentidadDelCliente.require'=>'El numero de identidad debe comenzar con 0 o con 1'
        ]);

        $nuevoCliente = new Cliente();
        $nuevoCliente->IdentidadDelCliente = $request->input('IdentidadDelCliente');
        $nuevoCliente->NombresDelCliente = $request->input('NombresDelCliente');
        $nuevoCliente->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $nuevoCliente->Telefono = $request->input('Telefono');
        $nuevoCliente->LugarDeProcedencia = $request->input('LugarDeProcedencia');
        $creado = $nuevoCliente->save();

        if($creado){
            return redirect()->route('cliente.index')
                ->with('mensaje', 'El cliente fue creado exitosamente.');
        }else{
            //retornar con un mensaje de error
        }
    }

    public function crear2(){
        return view('Ventas.formularioCliente');
    }

    //funcion para guardar los datos creados o insertados
    public function store2(Request $request){
        //VALIDAR

        $request->validate([
            'IdentidadDelCliente'=>'required|unique:clientes|max:15',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'nullable|max:8|unique:clientes',
            'LugarDeProcedencia'=>'required|max:120'
        ]);

        $nuevoCliente = new Cliente();
        $nuevoCliente->IdentidadDelCliente = $request->input('IdentidadDelCliente');
        $nuevoCliente->NombresDelCliente = $request->input('NombresDelCliente');
        $nuevoCliente->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $nuevoCliente->Telefono = $request->input('Telefono');
        $nuevoCliente->LugarDeProcedencia = $request->input('LugarDeProcedencia');
        $creado = $nuevoCliente->save();

        if($creado){
            return redirect()->route('ventas.crear', ['clientepedido' => $nuevoCliente->id])
                ->with('mensaje', 'El cliente fue creado exitosamente.');
        }else{
            //retornar con un mensaje de error
        }
    }


    public function crear3(){
        return view('Ventas.formularioClienteDos');
    }

    //funcion para guardar los datos creados o insertados
    public function store3(Request $request){
        //VALIDAR

        $request->validate([
            'IdentidadDelCliente'=>'required|unique:clientes|max:15',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'nullable|max:8|unique:clientes',
            'LugarDeProcedencia'=>'required|max:120'
        ]);

        $nuevoCliente = new Cliente();
        $nuevoCliente->IdentidadDelCliente = $request->input('IdentidadDelCliente');
        $nuevoCliente->NombresDelCliente = $request->input('NombresDelCliente');
        $nuevoCliente->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $nuevoCliente->Telefono = $request->input('Telefono');
        $nuevoCliente->LugarDeProcedencia = $request->input('LugarDeProcedencia');
        $creado = $nuevoCliente->save();

        if($creado){
            return redirect()->route('pedidosCliente.crear')
                ->with('mensaje', 'El cliente fue creado exitosamente.');
        }else{
            //retornar con un mensaje de error
        }
    }

    public function crear4(){
        return view('Ventas.formularioClienteTres');
    }

    //funcion para guardar los datos creados o insertados
    public function store4(Request $request){
        //VALIDAR

        $request->validate([
            'IdentidadDelCliente'=>'required|unique:clientes|max:15',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'nullable|max:8|unique:clientes',
            'LugarDeProcedencia'=>'required|max:120'
        ]);

        $nuevoCliente = new Cliente();
        $nuevoCliente->IdentidadDelCliente = $request->input('IdentidadDelCliente');
        $nuevoCliente->NombresDelCliente = $request->input('NombresDelCliente');
        $nuevoCliente->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $nuevoCliente->Telefono = $request->input('Telefono');
        $nuevoCliente->LugarDeProcedencia = $request->input('LugarDeProcedencia');
        $creado = $nuevoCliente->save();

        if($creado){
            return redirect()->route('pedidosClienteP.crear')
                ->with('mensaje', 'El cliente fue creado exitosamente.');
        }else{
            //retornar con un mensaje de error
        }
    }

    //funcion para editar los datos
    public function edit($id){
        $cliente = Cliente::findOrFail($id);
        return view('Clientes.formularioEditarCliente')->with('cliente', $cliente);
    }

    public function update(Request $request, $id){

        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'IdentidadDelCliente'=> [
                'required',
                'max:13',
                Rule::unique('clientes')->ignore($cliente->id),
            ],
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>[
                'nullable',
                'max:9',
                Rule::unique('clientes')->ignore($cliente->id),
            ],
            'LugarDeProcedencia'=>'required|max:120'
        ]);

        $cliente->IdentidadDelCliente = $request->input('IdentidadDelCliente');
        $cliente->NombresDelCliente = $request->input('NombresDelCliente');
        $cliente->ApellidosDelCliente = $request->input('ApellidosDelCliente');
        $cliente->Telefono = $request->input('Telefono');
        $cliente->LugarDeProcedencia = $request->input('LugarDeProcedencia');

        $creado = $cliente->update();

        if($creado){
            return redirect()->route('cliente.index')
                ->with('mensaje', 'El cliente fue modificado exitosamente.');
        }else{
            //retornar con un mensaje de error
        }

    }


}
