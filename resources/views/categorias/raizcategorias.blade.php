@extends('Plantillas.plantilla')

@section('titulo', 'Categorías')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('categoria.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por categorías">
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



    <h1 class=""> Listado De Categorías </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('categoria.crear')}}"> Agregar Categoría </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>




    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">Categoría</th>
                <th scope="col">Descripción</th>
                <th scope="col">Editar</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($categorias as $categoria)
            <tr class="active">
                
                <td scope="col">{{ $categoria->NombreDeLaCategoría}}</td>
                <td scope="col">{{ $categoria->DescripciónDeLaCategoría}}</td>

                <td> <a class="btn btn-success" href="{{ route('categoria.edit',['id' => $categoria->id]) }}"> Editar </a></td>

            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más categorías </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $categorias->links()}}

@endsection




