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
            <form action="{{route('pedidosProveedor.index')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-4 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por nombre de la empresa" value="{{$proveedor}}">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('pedidosProveedor.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('contenido')

<br><br>
<h1> Listado de pedidos de proveedores </h1>
<br><br>

<div class="d-grid gap-2 d-md-block ">
    <a class="btn btn-success float" href="{{ route('pedidosProveedor.crear') }}"> Agregar pedido </a>
    <a class="btn btn-success float" href="{{ route('compras.index') }}">Regresar</a>
</div>
<br>
    <table class="table table-bordered border-dark mt-3">
        <thead class="table table-striped table-hover">
            <tr  class="success">
                <th>Fecha del pedido</th>
                <th>Proveedor</th>
                <th>Estado</th>
                <th> </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pedidos as $pedido)
                    <tr>
                        <td>{{date("d-m-Y", strtotime($pedido->FechaDelPedido))}}</td>
                        <td>{{$pedido->proveedor->EmpresaProveedora}}</td>
                        <td>{{$pedido->EstadoDelPedidoDelProveedor}}</td>
                        <td> 
                            <a class="btn btn-success" href="{{Route('pedidosProveedor.show', ['id' => $pedido->id])}}"> Detalles </a>
                            <a class="btn btn-success" href="{{Route('pedidosProveedor.show', ['id' => $pedido->id])}}"> Realizado </a> 
                            <a class="btn btn-danger" onclick="eliminarP({{ $pedido->id }})"> Eliminar </a> 
                        </td>
                    </tr>
            @empty
                <tr>
                    <td rowspan="4">No hay resultados</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    {{ $pedidos->links() }}

    
@endsection
@push('alertas')
    <script>
        function cambiarEstadoP(id) {
            var ruta = "/estadoPP/" + id;
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

        function eliminarP(id) {
            var ruta = "/destroyP/" + id;
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

