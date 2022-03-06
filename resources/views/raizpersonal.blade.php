
@extends('Plantillas.plantilla')

@section('titulo', 'Personal')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('personal.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por identidad, nombre, apellido o estado del empleado">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
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
    <br>



    <h1 class=""> Listado Del Personal </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('personal.crear')}}"> Agregar Personal </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>




    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Identidad</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Fecha de Ingreso</th>
                <th scope="col">Estado</th>
                <th scope="col">Más Detalles</th>
                <th scope="col">Editar</th>
                <th scope="col">Cambiar Estado</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($personals as $personal)
            <tr class="active">
                <th scope="row">{{ $personal->id }}</th>
                <td scope="col">{{ $personal->IdentidadDelEmpleado}}</td>
                <td scope="col">{{ $personal->NombresDelEmpleado }}</td>
                <td scope="col">{{ $personal->ApellidosDelEmpleado }}</td>
                <td scope="col">{{ $personal->Teléfono}}</td>
                <td scope="col">{{ $personal->FechaDeIngreso}}</td>
                <td scope="col">{{$personal->EmpleadoActivo}}
                    {{-- @if ($personal->EmpleadoActivo)
                        Activo
                    @else
                        Inactivo
                    @endif --}}
                </td>

                <td> <a class="btn btn-success" href="{{ route('personal.mostrar',['id' => $personal->id]) }}" > Más Detalles </a></td>
                <td> <a class="btn btn-success" href="{{ route('personal.edit',['id' => $personal->id]) }}"> Editar </a></td>
                <td>
                    @if ($personal->EmpleadoActivo == 'Activo')
                        <a class="btn btn-danger" href="#" onclick="desactivar({{ $personal->id}})">Desactivar</a>
                    @else
                        <a class="btn btn-success" href="#" onclick="activar({{ $personal->id}})">Activar</a>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más empleados </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $personals->links()}}

@endsection



@push('alertas')
<script>

function activar(id) {
        var ruta ="/estado/"+id;
        Swal.fire({
                title: '¿Esta seguro que desea activar al empleado?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
    }

    function desactivar(id) {

var ruta = "/estado/"+id;
Swal.fire({
        title: '¿Está seguro que desea desactivar al empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then((result) => {

        if (result.isConfirmed) {
            window.location = ruta;
        }


    })
}



</script>
@endpush
