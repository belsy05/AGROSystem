@extends('Plantillas.plantilla')
@section('titulo', 'Compras')
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
            <form method="GET" action="{{ route('compra.reporte') }}">
                <div class="form-row">
                    <div class="col-sm-3 my-1">
                        <label for="id">Proveedor</label>
                        <select class="form-control" name="id" id="id">
                            <option value="0">--Seleccione--</option>
                            @foreach ($proveedores as $proveedor)
                                <option value="{{ $proveedor['id'] }}">{{ $proveedor['EmpresaProveedora'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2 my-1">
                    <label for="id">Fecha desde</label>
                    <input style="width: 100%" type="date" class="form-control" name="FechaDesde" id="Fechadesde"
                         maxlength="40" >
                    </div>
                    <div class="col-sm-2 my-1">
                        <label for="id">Fecha hasta</label>
                        <input style="width: 100%" type="date" class="form-control" name="FechaHasta" id="Fechahasta"
                         maxlength="40" >
                    </div>

                </div>
                <br>
                <input type="submit" class="btn btn-success my-8" value="Buscar">
                <a href="{{ route('compra.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
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
    <br> <br>  

    <h1 class=""> Listado de facturas próximas a vencer </h1>
    <br><br>
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{route('compras.index')}}" class="btn btn-success">Regresar</a>
    </div>

    <br>

    <table class="table table-bordered border-dark mt-3">
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Número de factura</th>
                <th scope="col">Proveedor</th>
                <th scope="col">Fecha</th>
                <th scope="col">Subtotal (Lps.)</th>
                <th scope="col">Impuesto (Lps.)</th>
                <th scope="col">Total compra (Lps.)</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($compras as $compra)
                <tr class="active">
                    <th scope="row">{{ $compra->id }}</th>
                    <td scope="col">{{ $compra->NumFactura }}</td>
                    <td scope="col">{{ $compra->proveedors->EmpresaProveedora }}</td>
                    <td scope="col">{{\Carbon\Carbon::parse($compra->FechaCompra)->locale("es")->isoFormat("DD MMMM, YYYY")}}</td>
                    <td scope="col">{{ $compra->TotalCompra }}</td>
                    <td scope="col">{{ $compra->TotalImpuesto }}</td>
                    <td scope="col">{{ $compra->TotalCompra + $compra->TotalImpuesto}}</td>

                    <td>
                        <a class="btn btn-success" href="{{ route('compra.mostrar', ['id' => $compra->id]) }}">
                            Ver detalles
                        </a>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="4"> No hay compras </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    {{ $compras->links() }}

@endsection
