@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Pedidos de Clientes')
@section('contenido')

    <h1> Detalle de pedidos de productos nuevos </h1>
    <br><br>

    <!-- PARA LOS ERRORES -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table class="table">
        <thead class="table-secondary">
            <tr>
                <th scope="col">Información del pedido</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row"> Cliente </th>
                <td scope="col">{{ $pedidos->clientes->NombresDelCliente }}
                        {{ $pedidos->clientes->ApellidosDelCliente }}</td>

            </tr>
            <tr>
                <th scope="row">Teléfono</th>
                <td scope="col">{{$pedidos->clientes->Telefono}} </td>
            </tr>
            <tr>
                <th scope="row">Anticipo</th>
                <td scope="col">{{$pedidos->TotalAnticipo}} </td>
            </tr>
            <tr>
                <th scope="row">Fecha de venta</th>
                <td scope="col">{{\Carbon\Carbon::parse($pedidos->FechaDelPedido)->locale("es")->isoFormat("DD MMMM, YYYY")}} </td>
            </tr>

        </tbody>
    </table>

<br><br>
        <div class="row" style="width: 150%">
            <div class="col-sm-8">

                <table class="table table-bordered border-dark mt-3">
                    <thead class="table table-striped table-hover">
                        <tr class="success">
                            <th scope="col">N°</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Presentación</th>
                            <th scope="col">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $i => $details)
                            <tr>
                                <td>{{ $i + 1}}</td>
                                <td>{{ $details->Producto }}</td>
                                <td>{{ $details->Presentacion}}</td>
                                <td>{{ $details->Cantidad }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>


        </div>

        <br>
        <a class="btn btn-info" href="{{ route('pedidosClienteP.index') }}">Regresar</a>

        {{--  --}}

    </form>


@endsection


