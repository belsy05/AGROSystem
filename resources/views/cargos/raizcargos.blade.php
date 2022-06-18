@extends('Plantillas.plantilla')
@section('titulo', 'Cargos')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('cargo.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" name="texto" placeholder="Buscar por nombre del cargo">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('cargo.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
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
    <h1> Listado de cargos </h1>
    <br><br>

    <div class="d-grid gap-2 d-md-block">
        <a class="btn btn-success float-end" href="{{route('cargo.crear')}}"> Agregar cargo </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>

    {{ $cargos->links()}}

    <table class="table table-bordered border-dark">
        <thead class="table-dark">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Nombre del cargo</th>
                <th scope="col">Descripción del cargo</th>
                <th scope="col">Sueldo</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($cargos as $cargo)
            <tr class="active">
                <th scope="row">{{ $cargo->id }}</th>
                <td scope="col">{{ $cargo->NombreDelCargo }}</td>
                <td scope="col">{{ $cargo->DescripciónDelCargo }}</td>
                <td scope="col">{{ $cargo->Sueldo }}</td>
                <td> <a class="btn btn-success" href="{{ route('cargo.edit',['id' => $cargo->id]) }}"> Editar </a></td>
            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más cargos </td>
            </tr>
        @endforelse

        </tbody>
    </table>
@endsection