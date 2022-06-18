@extends('Plantillas.plantilla')
@section('titulo', 'Inventario')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('Inventarios.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-4 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por nombre del producto o categoria">
                    </div>
                    <div class="col-auto my-1">
                        <input type="submit" class="btn btn-secondary" value="Buscar">
                        <a  href="{{ route('Inventarios.index') }}"  class="btn btn-success my-8">Borrar Búsqueda</a>
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
    <h1 class=""> Lista de productos próximos por agotar </h1>
    <br><br>
    <div class="d-grid gap-2 d-md-block ">
        <a href="{{route('inventario.index')}}" class="btn btn-success">Regresar</a>

    </div>


    <br>

    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Categoría</th>
                <th scope="col">Producto</th>
                <th scope="col">Presentación</th>
                <th scope="col">Existencia</th>
                <th scope="col">Precio promedio</th>
                <th scope="col">Costo total</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($inventarios as $i => $inventario)
            <tr class="active">
                @if (($inventario->categoria->NombreDeLaCategoría == 'Herramienta' || $inventario->categoria->NombreDeLaCategoría == 'Repuestos' ||
                $inventario->categoria->NombreDeLaCategoría == 'Medicina para Animales') && $inventario->Existencia <= 3)
                    <th scope="row">{{ ($i+1) }}</th>
                    <td scope="col">{{ $inventario->categoria->NombreDeLaCategoría }}</td>
                    <td scope="col">{{ $inventario->producto->NombreDelProducto}}</td>
                    <td scope="col">{{ $inventario->presentacion->informacion }}</td>
                    <td scope="col">{{ $inventario->Existencia }}</td>
                    <td scope="col">{{ $inventario->CostoPromedio}}</td>
                    <td scope="col">{{ $inventario->Existencia * $inventario->CostoPromedio}}</td>
                @else 
                    @if(($inventario->categoria->NombreDeLaCategoría != 'Herramienta' && $inventario->categoria->NombreDeLaCategoría != 'Repuestos' &&
                    $inventario->categoria->NombreDeLaCategoría != 'Medicina para Animales') && $inventario->Existencia <= 10)
                        <th scope="row">{{ ($i+1) }}</th>
                        <td scope="col">{{ $inventario->categoria->NombreDeLaCategoría }}</td>
                        <td scope="col">{{ $inventario->producto->NombreDelProducto}}</td>
                        <td scope="col">{{ $inventario->presentacion->informacion }}</td>
                        <td scope="col">{{ $inventario->Existencia }}</td>
                        <td scope="col">{{ $inventario->CostoPromedio}}</td>
                        <td scope="col">{{ $inventario->Existencia * $inventario->CostoPromedio}}</td>
                   @endif
                @endif
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