@extends('Plantillas.plantilla')

@section('titulo', 'Servicio')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('servicio.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-8 my-1">
                        <input type="search" class="form-control" name="texto" value="{{$texto}}" placeholder="Buscar por nombre o apellido del cliente">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('servicio.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
                    </div>
                </div>
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

    <h1 class="">Servicios Técnicos</h1>
    <br><br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float" href="{{ route('servicio.crear') }}"> Agregar servicio </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

    <br>

        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Técnico</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha del servicio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Cambiar estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($servicios as $serv)
                    <tr class="active">
                        <th scope="row">{{ $serv->id }}</th>
                        <td scope="col">{{ $serv->personal->NombresDelEmpleado }} {{ $serv->personal->ApellidosDelEmpleado }}</td>
                        <td scope="col">{{ $serv->cliente->NombresDelCliente }} {{ $serv->cliente->ApellidosDelCliente }}</td>
                        <td scope="col">{{ $serv->FechaDeRealizacion}}</td>
                        <td scope="col">{{ $serv->Estado}}</td>
                        <td> <a class="btn btn-success" onclick="cambiarEstado({{$serv->id}})">Realizado</a>
                        </td>
                        <td> <a class="btn btn-success" href="{{ route('servicio.mostrar', ['id' => $serv->id]) }}"> <span class=" 	glyphicon glyphicon-eye-open"></span> Visualizar</a>
                            <a class="btn btn-primary" href="{{ route('servicio.edit', ['id' => $serv->id]) }}"> <span class="glyphicon glyphicon-edit"></span> Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"> No hay más servicios </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
        {{ $servicios->links() }}

@endsection

@push('alertas')
    <script>
        function cambiarEstado(id) {
            var ruta = "/estado/" + id;
            Swal.fire({
                title: '¿Está seguro que desea cambiar el estado del pedido?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
                cancelButtonText: 'Cancelar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
        }
    </script>
@endpush
