<?php

namespace App\Http\Controllers;

use App\Models\Gasto;
use App\Http\Requests\StoreGastoRequest;
use App\Http\Requests\UpdateGastoRequest;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function edit(Gasto $gasto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGastoRequest  $request
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGastoRequest $request, Gasto $gasto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gasto  $gasto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gasto $gasto)
    {
        //
    }
}
