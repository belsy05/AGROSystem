@extends('Plantillas.plantilla')

@section('titulo', 'Registro de Categorías')

@section('contenido')

<h1> Registro de Categoría </h1>
<br><br>

<!-- PARA LOS ERRORES -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form id="form_guardarC" name="form_guardarC" method="POST" action="{{ route('categoria.guardar') }}" onsubmit="confirmar()">
    @csrf

    <div class="form-group">
        <label for="NombreDeLaCategoría"> Nombre: </label>
        <input type="text" class="form-control" name="NombreDeLaCategoría" id="NombreDeLaCategoría"
        placeholder="Nombre de la categoría" value="{{old('NombreDeLaCategoría')}}" maxlength="30">
    </div>

    <div class="form-group">
        <label for="DescripciónDeLaCategoría"> Descripción: </label>
        <textarea class="form-control" name="DescripciónDeLaCategoría" id="DescripciónDeLaCategoría" cols="30" rows="10" 
        placeholder="Breve descripción de la categoría" maxlength="150">{{old('DescripciónDeLaCategoría')}}</textarea>
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Guardar">
    <input type="reset" class="btn btn-danger" value="Limpiar">
    <a class="btn btn-info" href="{{route('categoria.index')}}">Cerrar</a>

</form>

@endsection
@section('name')
    
@endsection
@push('alertas')
    <script>
        function confirmar() {
           var formul = document.getElementById("form_guardarC");
            Swal.fire({
                title: '¿Está seguro que desea guardar los datos de la nueva categoría?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Aceptar'
            }).then((result)=>{
                if (result.isConfirmed) {
                    formul.submit();
                }
            })
            event.preventDefault()
        }
    </script>
@endpush