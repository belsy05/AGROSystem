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
                        ->paginate(10);
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
            'IdentidadDelCliente'=>'required||unique:clientes|max:13',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
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
            return redirect()->route('cliente.index')
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
            'Telefono'=>'nullable|max:9',
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
