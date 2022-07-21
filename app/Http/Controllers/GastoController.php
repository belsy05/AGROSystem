<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Models\Personal;
use App\Http\Requests\StoreGastoRequest;
use App\Http\Requests\UpdateGastoRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class GastoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index()
    {
        $empleado = 0;
        $TipoG = 0;
        $fechadesde = 0;
        $fechahasta = 0;
        $personal = Personal::all();
        $gastos = Gasto::paginate(10);
        return view('Gasto.raizGasto', compact('gastos','personal', 'empleado', 'fechadesde', 'fechahasta', 'TipoG'));
    }
    
    public function reporte(Request $request)
    {

        $personal = Personal::all();
        $gastos = Gasto::all();
        $TipoG = $request->get('tipo');
        $empleado = $request->get('empleado');
        $fechadesde = $request->get('FechaDesde');
        $fechahasta = $request->get('FechaHasta');

            if ($fechadesde != '' && $TipoG == 0 && $empleado == 0) {
                $gastos = Gasto::select('gastos.*')
                    ->whereBetween('fecha', [$fechadesde, $fechahasta])
                    ->paginate(15)->withQueryString();
            } else {
                if ($fechadesde != '' && $TipoG == 0 && $empleado != 0) {
                    $gastos = Gasto::select('gastos.*')
                        ->whereBetween('fecha', [$fechadesde, $fechahasta])
                        ->where('responsable', '=', $empleado)
                        ->paginate(15)->withQueryString();
                } else {
                    if ($fechadesde != '' && $TipoG != 0 && $empleado == 0) {
                        $gastos = Gasto::select('gastos.*')
                            ->whereBetween('fecha', [$fechadesde, $fechahasta])
                            ->where('tipo', '=', $TipoG)
                            ->paginate(15)->withQueryString();
                    } else {
                        if ($fechadesde == '' && $TipoG != 0 && $empleado == 0) {
                            $gastos = Gasto::select('gastos.*')
                                ->where('tipo', '=', $TipoG)
                                ->paginate(15)->withQueryString();
                        } else {
                            if ($fechadesde == '' && $TipoG == 0 && $empleado != 0) {
                                $gastos = Gasto::select('gastos.*')
                                    ->where('responsable', '=', $empleado)
                                    ->paginate(15)->withQueryString();
                            } else {
                                if ($fechadesde == '' && $TipoG != 0 && $empleado != 0) {
                                    $gastos = Gasto::select('gastos.*')
                                        ->where('responsable', '=', $empleado)
                                        ->where('tipo', '=', $TipoG)
                                        ->paginate(15)->withQueryString();
                                } else {
                                    $gastos = Gasto::select('gastos.*')
                                    ->whereBetween('fecha', [$fechadesde, $fechahasta])
                                    ->where('responsable', '=', $empleado)
                                    ->where('tipo', '=', $TipoG)
                                    ->paginate(15)->withQueryString();
                                }
                            }
                        }
                    }
                }
            }

        if ($fechadesde == '') {
            $fechadesde = 0;
        }
        if ($fechahasta == '') {
            $fechahasta = 0;
        }

        return view('Gasto.raizGasto', compact('gastos','personal', 'empleado', 'fechadesde', 'fechahasta', 'TipoG'));
    } 
    
    public function pdf($fechadesde, $fechahasta, $TipoG, $empleado)
    {

        if ($fechadesde == 0 && $TipoG != 0 && $empleado != 0) {
            $gastos = Gasto::select('gastos.*')
                ->whereBetween('responsable', [$empleado, $empleado])
                ->where('tipo', '=', $TipoG)
                ->paginate(15);
        }elseif($fechadesde != 0 && $TipoG == 0 && $empleado == 0) {
                $gastos = Gasto::select('gastos.*')
                    ->whereBetween('fecha', [$fechadesde, $fechahasta])
                    ->paginate(15);
            } elseif ($fechadesde != 0 && $TipoG == 0 && $empleado != 0) {
                    $gastos = Gasto::select('gastos.*')
                        ->whereBetween('fecha', [$fechadesde, $fechahasta])
                        ->where('responsable', '=', $empleado)
                        ->paginate(15);
                } elseif ($fechadesde != 0 && $TipoG != 0 && $empleado == 0) {
                        $gastos = Gasto::select('gastos.*')
                            ->whereBetween('fecha', [$fechadesde, $fechahasta])
                            ->where('tipo', '=', $TipoG)
                            ->paginate(15);
                    } elseif ($fechadesde == 0 && $TipoG != 0 && $empleado == 0) {
                            $gastos = Gasto::select('gastos.*')
                                ->where('tipo', '=', $TipoG)
                                ->paginate(15);
                        } elseif ($fechadesde == 0 && $TipoG == 0 && $empleado != 0) {
                                $gastos = Gasto::select('gastos.*')
                                    ->whereBetween('responsable', [$empleado, $empleado])
                                    ->paginate(15);
                            } elseif($fechadesde == 0 && $TipoG == 0 && $empleado == 0) {
                                $gastos = Gasto::select('gastos.*')
                                    ->paginate(15);
                            }else {
                                $gastos = Gasto::select('gastos.*')
                                    ->whereBetween('fecha', [$fechadesde, $fechahasta])
                                    ->where('responsable', '=', $empleado)
                                    ->where('tipo', '=', $TipoG)
                                    ->paginate(15);
                            }


        $e = Personal::where('id', $empleado)->first();

       
        if ($empleado != 0) {
            $nombre_empleado = $e->NombresDelEmpleado . ' ' . $e->ApellidosDelEmpleado;
        } else {
            $nombre_empleado = '';
        }


        $pdf = PDF::loadView('Gasto.pdf', [
            'gastos' => $gastos, 'tipo' => $TipoG, 'empleado' => $empleado,
            'fechadesde' => $fechadesde, 'fechahasta' => $fechahasta,'n_e' => $nombre_empleado
        ]);
        return $pdf->stream();
        //return $pdf->download('__compras.pdf');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('gasto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGastoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'=>'required|string|max:40|min:5',
            'descripcion'=>'required|string|max:150|min:5',
            'tipo'=>'required|string|max:150|min:5',
            'fecha'=>'required|string|max:150|min:5',
            'total'=>'required|numeric',
            'responsable'=>'required|string|max:150|min:5',
        ]);

        //Formulario
        $cargo = new Gasto();
        $cargo->nombre = $request->input('nombre');
        $cargo->descripcion = $request->input('descripcion');
        $cargo->tipo = $request->input('tipo');
        $cargo->fecha = $request->input('fecha');
        $cargo->total = $request->input('total');
        $cargo->responsable = $request->input('responsable');

        $creado = $cargo->save();

        return redirect()->route('gasto.index')
                ->with('mensaje', 'El gasto fue creada exitosamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gasto = Gasto::findOrFail($id);
        return view('gasto.show')->with('gasto',$gasto);
    }

   
     //funcion para editar los datos
     public function edit($id){
        $personal = Personal::all();
        $gasto = Gasto::findOrFail($id);
        return view('Gasto.formularioEditarGasto')->with('personal', $personal)->with('gasto', $gasto);
    }
    //funcion para actualizar los datos
    public function update(Request $request, $id){
        $gasto = Gasto::findOrFail($id);

        
        $request->validate([
            'nombre'=>'required|string|max:40',
            'descripcion'=>'required|string|max:150|min:5',
            'tipo'=>'required|string',
            'fecha'=>'required|string|max:150|min:5',
            'total'=>'required|numeric|min:1.00|max:50000.00',
            'responsable'=>'required|numeric',
        ], [
            'descripcion.required'=>'Agregue una descripción para el gasto'
        ]);
        $gasto->nombre = $request->input('nombre');
        $gasto->descripcion = $request->input('descripcion');
        $gasto->tipo = $request->input('tipo');
        $gasto->fecha = $request->input('fecha');
        $gasto->total = $request->input('total');
        $gasto->responsable = $request->responsable;

        $creado = $gasto->update();

        if($creado){
            return redirect()->route('gasto.index')
                ->with('mensaje', 'El gasto fue modificado exitosamente');
        }else{
            //retornar con un mensaje de error
        }
    }
}
