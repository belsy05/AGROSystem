
@extends('Plantillas.plantilla')

@section('titulo', 'Inventario')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('inventario.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-4 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por nombre del producto o categoria">
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

    <h1 class=""> Inventario </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">

        <a class="btn btn-success float-" href="#"> Regresar </a>
        <a class="btn btn-success float-" href="{{route('compras.index')}}"> Ir a compras </a>

    </div>


    <br>

    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Producto</th>
                <th scope="col">Categoría</th>
                <th scope="col">Existencia</th>
                <th scope="col">Precio Promedio</th>
                <th scope="col">Costo total</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        @forelse ($inventarios as $i => $inventario)
            <tr class="active">
                <th scope="row">{{ ($i+1) }}</th>
                <td scope="col">{{ $inventario->producto->NombreDelProducto}}</td>
                <td scope="col">{{ $inventario->categoria->NombreDeLaCategoría }}</td>
                <td scope="col">{{ $inventario->Existencia }}</td>
                <td scope="col">{{ $inventario->CostoPromedio}}</td>
                <td scope="col">{{ $inventario->Existencia * $inventario->CostoPromedio}}</td>
                <td scope="col">
                    <a href="{{route('inventario.precio', ['id'=>$inventario->IdProducto])}}" class="btn btn-success">Historial de Precios</a>
                    <a href="{{route('inventario.detalle', ['id'=>$inventario->IdProducto])}}" class="btn btn-success">Más Detalles</a>
                </td>


            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay compras </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    
    {{ $inventarios->links()}}

@endsection

