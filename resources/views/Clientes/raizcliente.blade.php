@extends('Plantillas.plantilla')

@section('titulo', 'Clientes')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('cliente.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por identidad, nombre, apellido o lugar de procedencia.">
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



    <h1 class=""> Listado De Clientes </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('cliente.crear')}}"> Agregar Cliente </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>




    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N° De Identidad</th>
                <th scope="col">Nombre Completo</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Lugar De Procedencia</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($clientes as $cliente)
            <tr class="active">
                <td scope="col">{{ $cliente->IdentidadDelCliente}}</td>
                <td scope="col">{{ $cliente->NombresDelCliente}} {{ $cliente->ApellidosDelCliente}}</td>
                <td scope="col">{{ $cliente->Telefono }}</td>
                <td scope="col">{{ $cliente->LugarDeProcedencia }}</td>
                <td> <a class="btn btn-success" href="{{ route('cliente.edit',['id' => $cliente->id]) }}"> Editar </a></td>

            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más clientes </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $clientes->links()}}

@endsection
