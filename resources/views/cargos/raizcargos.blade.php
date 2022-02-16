@extends('Plantillas.plantilla')

@section('titulo', 'Cargos')
@section('contenido')
@if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <h1> Listado De Cargos </h1>
    <br><br>
    

    <div class="d-grid gap-2 d-md-block">
        <a class="btn btn-success float-end" href="{{route('cargo.crear')}}"> Agregar Cargo </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>
      
        
        <br>
            
    {{ $cargos->links()}}
    
    <table class="table table-bordered border-dark">
        <thead class="table-dark">
            <tr class="success">
                <th scope="col">Id</th>
                <th scope="col">Nombre del Cargo</th>
                <th scope="col">Descripción del Cargo</th>
                <th scope="col">Sueldo</th>
                <th scope="col">Editar</th>
            </tr>  
        </thead>
        <tbody>
        @forelse ($cargos as $cargo)
            <tr class="active">
                <th scope="row">{{ $cargo->id }}</th>
                <td scope="col">{{ $cargo->NombreCargo }}</td>
                <td scope="col">{{ $cargo->DescripcionCargo }}</td>
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