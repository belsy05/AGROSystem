@extends('Plantillas.plantilla')
@section('titulo', 'Gastos')
@section('barra')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form  method="GET" action="{{route('gasto.reporte')}}">
                <div class="form-row">
                    <div style="width: 17%;float: left;">
                        <label for="id">Empleado</label>
                        <select class="form-control" name="empleado" id="id">
                            @if (isset($empleado)&& $empleado !=0)
                            @foreach ($personal as $cliente)
                                @if ($cliente->id == $empleado)
                                <option style="display: none" value="{{ $cliente['id'] }}">{{ $cliente['NombresDelEmpleado'] }} {{ $cliente['ApellidosDelEmpleado'] }}</option>
                                @endif
                            @endforeach
                            @else
                                <option style="display: none" value="0">--Seleccione--</option>
                            @endif
                            @foreach ($personal as $cliente)
                                <option value="{{ $cliente['id'] }}">{{ $cliente['NombresDelEmpleado'] }} {{ $cliente['ApellidosDelEmpleado'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div style="width: 17%;float: left;margin-left: 1%">
                        <label for="tipo"> Tipo </label>
                        <select name="tipo" id="tipo" class="form-control">
                            @if (isset($TipoG)&& $TipoG !=0)
                                @if ($TipoG == 'Variable')
                                <option style="display: none" value="Variable"> Variable </option>
                                @else
                                <option style="display: none" value="Fijo"> Fijo </option>
                                @endif
                            @else
                                <option style="display: none" value="0">--Seleccione--</option>
                            @endif
                            <option style="display: none" value="0">--Seleccione--</option>
                            <option value="Variable">Variable</option>
                            <option value="Fijo">Fijo</option>
                        </select>
                    </div>

                    <div class="col-sm-2 my-1">
                        <label for="id">Fecha desde</label>
                        <input style="width: 100%" type="date" class="form-control" name="FechaDesde" id="Fechadesde"
                             maxlength="40" value="{{$fechadesde}}">
                        </div>
                        <div class="col-sm-2 my-1">
                            <label for="id">Fecha hasta</label>
                            <input style="width: 100%" type="date" class="form-control" name="FechaHasta" id="Fechahasta"
                             maxlength="40" value="{{$fechahasta}}">
                        </div>
                </div>
                <br>
                    <input type="submit" class="btn" style="background-color:gray; border-color:black; color:white" value="Buscar">
                    <a href="{{ route('gasto.index') }}" class="btn my-8" style="background-color:gray; border-color:black; color:white">Borrar búsqueda</a>
            </form>
        </div>
    </div>
</div> 
@endsection
@section('contenido')
@if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <br><br>
    <h1> Listado de gastos </h1>
    <br><br>

    <div class="d-grid gap-2 d-md-block">
        <a class="btn" style="background-color:rgb(65, 145, 126); border-color:black; color:white" href="{{route('gasto.crear')}}"> <span class="glyphicon glyphicon-plus"></span>Agregar gasto </a>
        <a class="btn" style="background-color:rgb(65, 145, 126); border-color:black; color:white" href="{{ route('gasto.pdf', ['anio1' => $fechadesde, 
            'anio2' => $fechahasta, 'empleado' => $empleado, 'tipo' => $TipoG]) }}"><span class="glyphicon glyphicon-print"></span> Imprimir reporte </a>
        <a class="btn" style="background-color:rgb(65, 145, 126); border-color:black; color:white" href=""> Regresar </a>
    </div>
    <br>
    <table class="table table-bordered border-dark">
        <thead class="table-dark">
            <tr class="info">
                <th scope="col">N°</th>
                <th scope="col">Empleado responsable</th>
                <th scope="col">Nombre del gasto</th>
                <th scope="col">Tipo</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($gastos as $gast)
            <tr class="active">
                <th scope="row">{{ $gast->id }}</th>
                <td scope="row">{{ $gast->person->NombresDelEmpleado}} {{$gast->person->ApellidosDelEmpleado}} </td>
                <td scope="col">{{ $gast->nombre }}</td>
                <td scope="col">{{ $gast->tipo }}</td>
                <td scope="col">{{ $gast->fecha }}</td>
                <td scope="col">{{ $gast->total }}</td>
                <td> 
                    <a class="btn" style="background-color:white; border-color:black; color:black" href="{{ route('gasto.update',['id' => $gast->id]) }}"> <span class="glyphicon glyphicon-eye-open">
                    </span> 
                    Más detalles 
                    </a>
                    <a class="btn" style="background-color:white; border-color:black; color:black" href="{{ route('gasto.edit', ['id' => $gast->id]) }}">
                        <span class="glyphicon glyphicon-edit"></span> 
                        Editar 
                    </a>
                </td> 
            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más gastos </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    
    {{ $gastos->links()}}
@endsection
