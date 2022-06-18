@extends('Plantillas.plantilla')

@section('titulo', 'Productos')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('producto.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" name="texto" placeholder="Buscar por nombre y categoría del producto">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a href="{{ route('producto.index') }}" class="btn btn-success my-8">Borrar búsqueda</a>
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
    <h1> Listado de productos </h1>
    <br><br>

    <div class="d-grid gap-2 d-md-block">
        <a class="btn btn-success float-end" href="{{route('producto.crear')}}"> Agregar producto </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>


        <br>

    <table class="table table-bordered border-dark">
        <thead class="table-dark">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Nombre del producto</th>
                <th scope="col">Categoría</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($productos as $producto)
            <tr class="active">
                <th scope="row">{{ $producto->id }}</th>
                <td scope="col">{{ $producto->NombreDelProducto}}</td>
                <td scope="col">{{ $producto->categorias->NombreDeLaCategoría}}</td>
                <td> <a class="btn btn-success" href="{{ route('producto.mostrar',['id' => $producto->id]) }}" > Más detalles </a></td> 
                <td> <a class="btn btn-success" href="{{ route('producto.edit',['id' => $producto->id]) }}"> Editar </a></td>
            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más productos </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $productos->links()}}

@endsection