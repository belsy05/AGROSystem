<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    public function index(){
        $proveedor = Proveedor::paginate(10);
        return view('Proveedors.raizproveedor')->with('proveedors', $proveedor);
    }

    //funcion para la barra
    public function index2(Request $request){

        $texto =trim($request->get('texto'));

        $proveedors = DB::table('Proveedors')
                        ->where('EmpresaProveedora', 'LIKE', '%'.$texto.'%')
                        ->orwhere('NombresDelEncargado', 'LIKE', '%'.$texto.'%')
                        ->paginate(10)->withQueryString();
        return view('Proveedors.raizProveedor', compact('proveedors', 'texto'));
    }

    public function crear(){
        return view('proveedors.formularioProveedor');
    }
    
    public function show($id){
        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedors.verProveedor')->with( 'proveedor', $proveedor);
    } 

    public function store(Request $request){
        //Validar
        $request->validate([
            'EmpresaProveedora'=>'required|unique:proveedors|max:40',
            'DirecciónDeLaEmpresa'=>'required|max:150',
            'CorreoElectrónicoDeLaEmpresa'=>'nullable|email|unique:proveedors|max:40',
            'TeléfonoDeLaEmpresa'=>'required|unique:proveedors',
            'NombresDelEncargado'=>'required|string|max:30',
            'ApellidosDelEncargado'=>'required|max:40',
            'TeléfonoDelEncargado'=>'required|unique:proveedors',
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

    ///////////////////////////////////////////////////////////////////////////////////
    public function crear2(){
        return view('Compras.formularioProveedor');
    }

    public function store2(Request $request){
        //Validar
        $request->validate([
            'EmpresaProveedora'=>'required|unique:proveedors|max:40',
            'DirecciónDeLaEmpresa'=>'required|max:150',
            'CorreoElectrónicoDeLaEmpresa'=>'nullable|email|unique:proveedors|max:40',
            'TeléfonoDeLaEmpresa'=>'required|unique:proveedors',
            'NombresDelEncargado'=>'required||max:30',
            'ApellidosDelEncargado'=>'required|max:40',
            'TeléfonoDelEncargado'=>'required|unique:proveedors',
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
            return redirect()->route('compras.crear')
                ->with('mensaje', 'El proveedor fue creado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }
    ///////////////////////////////////////////////////////////////////////////////////

     //funcion para editar los datos
     public function edit($id){
        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedors.formularioEditarProveedor')->with('proveedor', $proveedor);
    }

    //funcion para actualizar los datos
    public function update(Request $request, $id){

        $proveedor = Proveedor::findOrFail($id);

            $request->validate([
            
                'EmpresaProveedora'=> [
                    'required',
                    'string',
                    'max:40',
                    Rule::unique('proveedors')->ignore($proveedor->id),
                ],
                'DirecciónDeLaEmpresa'=>'required|max:150',
                'CorreoElectrónicoDeLaEmpresa'=> [
                'nullable',
                'email',
                'max:40',
                Rule::unique('proveedors')->ignore($proveedor->id),
                ],
                'TeléfonoDeLaEmpresa'=>[
                    'required',
                    Rule::unique('proveedors')->ignore($proveedor->id),
                ],
                'NombresDelEncargado'=>'required||max:30',
                'ApellidosDelEncargado'=>'required|max:40',
                'TeléfonoDelEncargado'=>[
                    'required',
                    Rule::unique('proveedors')->ignore($proveedor->id),
                ],
            ]);
        
                $proveedor->EmpresaProveedora = $request->input('EmpresaProveedora');
                $proveedor->DirecciónDeLaEmpresa = $request->input('DirecciónDeLaEmpresa');
                $proveedor->CorreoElectrónicoDeLaEmpresa = $request->input('CorreoElectrónicoDeLaEmpresa');
                $proveedor->TeléfonoDeLaEmpresa = $request->input('TeléfonoDeLaEmpresa');
                $proveedor->NombresDelEncargado = $request->input('NombresDelEncargado');
                $proveedor->ApellidosDelEncargado = $request->input('ApellidosDelEncargado');
                $proveedor->TeléfonoDelEncargado = $request->input('TeléfonoDelEncargado');

                $creado = $proveedor->update();

                if($creado){
                    return redirect()->route('proveedor.index')
                        ->with('mensaje', 'El proveedor fue modificado exitosamente');
                }else{
                    //retornar con un mensaje de error
                }
    } 

}