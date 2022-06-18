@extends('Plantillas.plantilla')
@section('titulo', 'Ventas')
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
                <form method="GET" action="{{ route('ventas.reporte') }}">
                    <div class="form-row">
                        <div style="width: 20%;float: left;">
                            <label for="id">Cliente</label>
                            <select class="form-control" name="cliente" id="id">
                                @if (isset($clien) && $clien !=0)
                                @foreach ($clientes as $cliente)
                                    @if ($cliente->id == $clien)
                                    <option style="display: none" value="{{ $cliente['id'] }}">{{ $cliente['NombresDelCliente'] }} {{ $cliente['ApellidosDelCliente'] }}</option>
                                    @endif
                                @endforeach
                                @else
                                    <option style="display: none" value="0">--Seleccione--</option>
                                @endif
                                <option value="a">Consumidor final</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente['id'] }}">{{ $cliente['NombresDelCliente'] }} {{ $cliente['ApellidosDelCliente'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div style="width: 20%;float: left;margin-left: 1%">
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
                    <input type="submit" class="btn btn-success my-8" value="Buscar">
                    <a href="{{ route('ventas.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('contenido')

<style>
    .tabla2 {
           display: none;
       }
    @media (max-width: 868px) {
       
       /* ///////////////////////////////// */

       .tabla2 {
           display: block;
           width: 100%;
           height: 5%;
           padding: 5px;
           min-height: 5vh;
           transition: all 0.3s;
       }

       .tabla1 {
           display: none;
       }
   } 
   
</style> 
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    <br><br>
    <h1 class=""> Listado de ventas </h1>
    <br><br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float" href="{{ route('ventas.crear', ['clientepedido' => 0]) }}"> Agregar venta </a>
        <a class="btn btn-success float" href="{{ route('pedidosCliente.index') }}"> Lista de pedidos </a>
        <a class="btn btn-success float" href="{{ route('ventas.pdf', ['anio1' => $fechadesde, 
        'anio2' => $fechahasta, 'empleados' => $empleado, 'clientes' => $clien]) }}"> Imprimir reporte </a>
        <a class="btn btn-success float" href="{{ route('cotizaciones.crear') }}"> Realizar una cotización </a>
    </div>

    <br>
    <div class="tabla1">
        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Número de factura</th>
                    <th scope="col">Empleado</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Subtotal (Lps.)</th>
                    <th scope="col">Impuesto (Lps.)</th>
                    <th scope="col">Total venta (Lps.)</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $compra)
                    <tr class="active">
                        <th scope="row">{{ $compra->id }}</th>
                        <td scope="col">{{ $compra->NumFactura }}</td>
                        <td scope="col">{{ $compra->personals->NombresDelEmpleado }} {{ $compra->personals->ApellidosDelEmpleado }}</td>
                        @if ($compra->cliente_id == null)
                            <td scope="col">Consumidor final</td>
                        @else
                            <td scope="col">{{ $compra->clientes->NombresDelCliente }} {{ $compra->clientes->ApellidosDelCliente }}</td>
                        @endif
                        <td scope="col">{{\Carbon\Carbon::parse($compra->FechaVenta)->locale("es")->isoFormat("DD MMMM, YYYY")}}</td>
                        <td scope="col">{{ $compra->TotalVenta }}</td>
                        <td scope="col">{{ $compra->TotalImpuesto }}</td>
                        <td scope="col">{{ $compra->TotalVenta + $compra->TotalImpuesto}}</td>                    

                        <td>
                            <a class="btn btn-success" href="{{ route('ventas.mostrar', ['id' => $compra->id]) }}">
                                Ver <br> detalles
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4"> No hay ventas </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $ventas->links() }}
    </div>

    <div class="tabla2">
        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Número de Factura</th>
                    <th scope="col">Empleado</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Total Venta (Lps.)</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($ventas as $compra)
                    <tr class="active">
                        <th scope="row">{{ $compra->id }}</th>
                        <td scope="col">{{ $compra->NumFactura }}</td>
                        <td scope="col">{{ $compra->personals->NombresDelEmpleado }} {{ $compra->personals->ApellidosDelEmpleado }}</td>
                        @if ($compra->cliente_id == null)
                            <td scope="col">Consumidor Final</td>
                        @else
                            <td scope="col">{{ $compra->clientes->NombresDelCliente }} {{ $compra->clientes->ApellidosDelCliente }}</td>
                        @endif
                        <td scope="col">{{\Carbon\Carbon::parse($compra->FechaVenta)->locale("es")->isoFormat("DD MMMM, YYYY")}}</td>
                        <td scope="col">{{ $compra->TotalVenta + $compra->TotalImpuesto}}</td>                    

                        <td>
                            <a class="btn btn-success" href="{{ route('ventas.mostrar', ['id' => $compra->id]) }}">
                                Ver <br> Detalles
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4"> No hay ventas </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $ventas->links() }}
    </div>
@endsection