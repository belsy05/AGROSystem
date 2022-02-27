<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'IdentidadDelCliente'=>'required|max:13',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'max:9',
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


    public function edit(Request $request){
        //VALIDAR
        $request->validate([
            'IdentidadDelCliente'=>'required|max:13',
            'NombresDelCliente'=>'required||max:30',
            'ApellidosDelCliente'=>'required|max:40',
            'Telefono'=>'required',
            'LugarDeProcedencia'=>'required|max:120'
        ]);


    }

}
