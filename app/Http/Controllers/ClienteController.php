<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    

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
            'Telefono'=>'required',
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
