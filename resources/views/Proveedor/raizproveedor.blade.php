@extends('Plantillas.plantilla')

@section('titulo', 'Proveedores')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('proveedor.index2')}}" method="GET">
                <div class="form-row">
                    <div class="col-sm-4 my-1">
                        <input type="search" class="form-control" name="texto" placeholder="Buscar">
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



    <h1 class=""> Listado De Proveedores </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('proveedor.crear')}}"> Agregar Proveedor </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>

        <br>




    <table class="table table-bordered border-dark mt-3" >
        <thead class="table table-striped table-hover">
            <tr class="success">
                <th scope="col">N°</th>
                <th scope="col">Empresa</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Encargado</th>
                <th scope="col">Teléfono Del Encargado</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($proveedors as $proveedor)
            <tr class="active">
                <th scope="row">{{ $proveedor->id }}</th>
                <td scope="col">{{ $proveedor->EmpresaProveedora}}</td>
                <td scope="col">{{ $proveedor->TeléfonoDeLaEmpresa }}</td>
                <td scope="col">{{ $proveedor->NombresDelEncargado }}</td>
                <td scope="col">{{ $proveedor->TeléfonoDelEncargado}}</td>

                <td> <a class="btn btn-success" href="{{ route('proveedor.mostrar',['id' => $proveedor->id]) }}" > Más Detalles </a></td>
                <td> <a class="btn btn-success" href="{{ route('proveedor.edit',['id' => $proveedor->id]) }}"> Editar </a></td>

            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más proveedores </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $proveedors->links()}}

@endsection