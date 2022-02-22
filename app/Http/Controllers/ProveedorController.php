<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    //
    public function crear(){
        return view('proveedor.formularioProveedor');
    }
    
    public function show($id){
        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedor.verProveedor')->with( 'proveedor', $proveedor);
    } 

    public function store(Request $request){
        //Validar
        $request->validate([
            'EmpresaProveedora'=>'required|max:40',
            'DirecciónDeLaEmpresa'=>'required|max:150',
            'CorreoElectrónicoDeLaEmpresa'=>'required|email|unique:proveedors|max:40',
            'TeléfonoDeLaEmpresa'=>'required',
            'NombresDelEncargado'=>'required||max:30',
            'ApellidosDelEncargado'=>'required|max:40',
            'TeléfonoDelEncargado'=>'required',
        ]);

        //Formulario
        $nuevoProveedor = new Proveedor();
        $nuevoProveedor->EmpresaProveedora = $request->input('EmpresaProveedora');
        $nuevoProveedor->DirecciónDeLaEmpresa = $request->input('DirecciónDeLaEmpresa');
        $nuevoProveedor->CorreoElectrónicoDeLaEmpresa = $request->input('CorreoElectrónicoDeLaEmpresa');
        $nuevoProveedor->TeléfonoDeLaEmpresa = $request->input('TeléfonoDeLaEmpresa');
        $nuevoProveedor->NombresDelEncargado = $request->input('NombresDelEncargado');
        $nuevoProveedor->ApellidosDelEncargado = $request->input('ApellidosDelEncargado');
        $nuevoProveedor->TeléfonoDelEncargado = $request->input('TeléfonoDelEncargado');
        $creado = $nuevoProveedor->save();

        if($creado){
            return redirect()->route('proveedor.index')
                ->with('mensaje', 'El proveedor fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }

}

}
