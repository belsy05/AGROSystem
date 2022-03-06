@extends('Plantillas.plantilla')

@section('titulo', 'Productos')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('producto.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-6 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar por nombre del productos, código y categoría">
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



    <h1 class=""> Listado De Productos </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('producto.crear')}}"> Agregar Producto </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>




    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Producto</th>
                <th scope="col">Código</th>
                <th scope="col">Categoría</th>
                
                <th scope="col">Presentación</th>
                <th scope="col">Más Detalles</th>
                <th scope="col">Editar</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($productos as $producto)
            <tr class="active">
                <th scope="row">{{ $producto->id }}</th>
                <td scope="col">{{ $producto->NombreDelProducto}}</td>
                <td scope="col">{{ $producto->CódigoDelProducto}}</td>
                
                <td scope="col">{{ $producto->PresentaciónDelProducto}}</td>

                <td scope="col">{{ $producto->Impuesto}}</td>
       
                <td>
                    @csrf 
                    <select class="form-control" name="Categoria" id="Categoria" >
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria['id']}}">{{$categoria['NombreDeLaCategoría']}}</option>
                        @endforeach
                    </select> 
                </td>
                <td> <a class="btn btn-success" href="{{ route('producto.mostrar',['id' => $producto->id]) }}" > Más Detalles </a></td>
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




