<?php

namespace App\Http\Controllers;

use App\Models\Rango;
use Illuminate\Http\Request;

class RangoController extends Controller
{
    public function agregar_detalle(Request $request)
    {

            $rules=[
                'Inicio'=>'required',
                'Fin'=>'required|',
                'fecha_limite'=>'required|date|after:today',
            ];
        

        $mensaje=[
            'Inicio.required' => 'El campo inicio del rango es obligatorio.',
            'Fin.required' => 'El campo fin del rango es obligatorio.',
            'fecha_limite.required' => 'El campo fecha limite de emisión es obligatorio.',
            'fecha_limite.after' => 'El campo fecha limite de emisión debe de ser posterior al dia de hoy',
            'fecha_limite.date' => 'El campo fecha de vencimiento debe de ser una fecha',
        ];
        $this->validate($request,$rules,$mensaje);

        $rango = new Rango();
        $rango->FacturaInicio = $request->input('Inicio');
        $rango->FacturaFin = $request->input('Fin');
        $rango->FechaLimite = $request->input('fecha_limite');
        $rango->save();

        return redirect()->route('ventas.crear', ['clientepedido' => $request->r_Idcliente]);
    }

}
