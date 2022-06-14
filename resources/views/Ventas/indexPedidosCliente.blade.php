@extends('Plantillas.plantilla')
@section('titulo', 'Listado de pedidos')
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
            <form action="{{route('pedidosCliente.index')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-4 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por nombre del cliente" value="{{$cliente}}">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('pedidosCliente.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('contenido')

<br><br>
<h1>Listado de pedidos de clientes</h1>
<br><br>

<div class="d-grid gap-2 d-md-block ">
    <a class="btn btn-success float" href="{{ route('pedidosCliente.crear') }}"> Agregar pedido </a>
    <a class="btn btn-success float" href="{{ route('pedidosClienteP.index') }}"> Lista de pedidos de productos nuevos </a>
    <a class="btn btn-success float" href="{{ route('ventas.index') }}">Regresar</a>
</div>
<br>
    <table class="table table-bordered border-dark mt-3">
        <thead class="table table-striped table-hover">
            <tr  class="success">
                <th>Fecha del pedido</th>
                <th>Cliente</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $pedido)
                <tr>
                    @if ($pedido->EstadoDelPedido == 'No reclamado')
                        <td>{{date("d-m-Y", strtotime($pedido->FechaDelPedido))}}</td>
                        <td>{{$pedido->NombresDelCliente}} {{$pedido->ApellidosDelCliente}}</td>
                        <td>{{$pedido->EstadoDelPedido}}</td>
                        <td> 
                        <a class="btn btn-success" href="{{Route('pedidosCliente.show', ['id' => $pedido->id])}}"> Detalles </a>
                        <a class="btn btn-success" onclick="cambiarEstado({{ $pedido->id }})">Facturar pedido</a>
                        <a class="btn btn-danger" onclick="eliminar({{ $pedido->id }})">Eliminar</a>
                        </td>
                        
                    @endif
                </tr>
            @empty
                <tr>
                    <td rowspan="4">No hay resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
@push('alertas')
    <script>
        function cambiarEstado(id) {
            var ruta = "/estadoP/" + id;
            Swal.fire({
                title: '¿Está seguro que desea facturar y eliminar el pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
        }

        function eliminar(id) {
            var ruta = "/destroy/" + id;
            Swal.fire({
                title: '¿Está seguro que desea eliminar el pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
        }
    </script>
@endpush
