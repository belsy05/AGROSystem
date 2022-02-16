
@extends('Plantillas.plantilla')

@section('titulo', 'Personal')
@section('barra')
<div class="container">
    <div class="row">
        <div class="col-xl-12">
            <form action="{{route('personal.index2')}}" method="GET">
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

    
    
    <h1 class=""> Listado Del Personal </h1>
    <br>
    <div class="d-grid gap-2 d-md-block ">
        <a class="btn btn-success float-" href="{{route('personal.crear')}}"> Agregar Personal </a>
        <a class="btn btn-success float-end me-md-2" href=""> Regresar </a>
    </div>
      
        <br>
    
@endsection