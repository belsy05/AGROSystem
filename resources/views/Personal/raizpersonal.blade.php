@extends('Plantillas.plantilla')

@section('titulo', 'Personal')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('personal.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-8 my-1">
                        <input type="search" class="form-control" name="texto" value="{{$texto}}" placeholder="Buscar por identidad, nombre, apellido o estado del empleado">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('personal.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('contenido')
    <style>
         @media (max-width: 868px) {
            
            /* ///////////////////////////////// */

            .ContenidoBarra2 {
                display: block;
                width: 100%;
                height: 5%;
                padding: 5px;
                min-height: 5vh;
                transition: all 0.3s;
            }

            .ContenidoBarra {
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

    <h1 class=""> Listado del personal </h1>
    <br><br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{ route('personal.crear') }}"> Agregar personal </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

    <br>


        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Identidad</th>
                    <th scope="col">Nombres</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Teléfono</th>
                    {{-- <th scope="col">Fecha de Ingreso</th> --}}
                    <th scope="col">Estado</th>
                    <th scope="col">Cambiar estado</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($personals as $personal)
                    <tr class="active">
                        <th scope="row">{{ $personal->id }}</th>
                        <td scope="col">{{ $personal->IdentidadDelEmpleado }}</td>
                        <td scope="col">{{ $personal->NombresDelEmpleado }}</td>
                        <td scope="col">{{ $personal->ApellidosDelEmpleado }}</td>
                        <td scope="col">{{ $personal->Teléfono }}</td>
                        {{-- <td scope="col">
                            {{ \Carbon\Carbon::parse($personal->FechaDeIngreso)->locale('es')->isoFormat('DD MMMM, YYYY') }}
                        </td> --}}
                        <td scope="col">{{ $personal->EmpleadoActivo }}</td>
                        <td>
                            @if ($personal->EmpleadoActivo == 'Activo')
                                <a class="btn btn-danger" href="#" onclick="desactivar({{ $personal->id }})">Desactivar</a>
                            @else
                                <a class="btn btn-success" href="#" onclick="activar({{ $personal->id }})">Activar</a>
                            @endif
                        </td>
                        <td> <a class="btn btn-success" href="{{ route('personal.mostrar', ['id' => $personal->id]) }}"> Más
                                <br> detalles </a>
                            <a class="btn btn-success" href="{{ route('personal.edit', ['id' => $personal->id]) }}"> Editar</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4"> No hay más empleados </td>
                    </tr>
                @endforelse
    
            </tbody>
        </table>
        {{ $personals->links() }}
        
    
    

@endsection
@section('contenido2')
    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif
    <br>
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <form action="{{ route('personal.index2') }}" method="GET">
                    <div class="form-row">
                        <div class="col-sm-6 my-1">
                            <input type="search" class="form-control" name="texto" value="{{ $texto }}"
                                placeholder="Buscar por identidad, nombre, apellido o estado del empleado"
                                title="Buscar por identidad, nombre, apellido o estado del empleado">
                        </div>
                        <div class="col-auto my-1">
                            <input type="submit" class="btn btn-secondary" value="Buscar">
                            <a href="{{ route('personal.index') }}" class="btn btn-success my-8">Borrar Búsqueda</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <br>



    <h1 class=""> Listado Del Personal </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{ route('personal.crear') }}"> Agregar Personal </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

    <br>




    <table class="table table-bordered border-dark mt-3">
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Identidad</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Estado</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($personals as $personal)
                <tr class="active">
                    <th scope="row">{{ $personal->id }}</th>
                    <td scope="col">{{ $personal->IdentidadDelEmpleado }}</td>
                    <td scope="col">{{ $personal->NombresDelEmpleado }} {{ $personal->ApellidosDelEmpleado }}</td>
                    <td scope="col">{{ $personal->EmpleadoActivo }}</td>
                    <td scope="col">
                        @if ($personal->EmpleadoActivo == 'Activo')
                            <a class="btn btn-danger" href="#" onclick="desactivar({{ $personal->id }})">Desactivar</a>
                        @else
                            <a class="btn btn-success" href="#" onclick="activar({{ $personal->id }})">Activar</a>
                        @endif
                        <a class="btn btn-success" href="{{ route('personal.mostrar', ['id' => $personal->id]) }}"> Más
                            Detalles </a>
                        <a class="btn btn-success" href="{{ route('personal.edit', ['id' => $personal->id]) }}"> Editar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4"> No hay más empleados </td>
                </tr>
            @endforelse

        </tbody>
    </table>
    {{ $personals->links() }}

@endsection 


@push('alertas')
    <script>
        function activar(id) {
            var ruta = "/estado/" + id;
            Swal.fire({
                title: '¿Esta seguro que desea activar al empleado?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
        }

        function desactivar(id) {

            var ruta = "/estado/" + id;
            Swal.fire({
                title: '¿Está seguro que desea desactivar al empleado?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
        }
    </script>
@endpush
