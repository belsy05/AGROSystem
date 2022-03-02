@extends('Plantillas.plantilla')

@section('titulo', 'Editar Cargos')

@section('contenido')

<h1> Editar Cargos </h1>
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

<form id="form_editarC" name="form_editarC" method="POST" action="{{ route('cargo.update', $cargo->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->

    <div class="form-group">
        <label for="NombreDelCargo"> Nombre </label>
        <input type="text" class="form-control" name="NombreDelCargo" id="NombreDelCargo" placeholder="Nombre del cargo"
        value="{{old('NombreDelCargo', $cargo->NombreDelCargo)}}" maxlength="40">
    </div>

    <div class="form-group">
        <label for="DescripciónDelCargo"> Descripción </label>
        <textarea class="form-control" name="DescripciónDelCargo" id="DescripciónDelCargo" cols="30" rows="10" placeholder="Breve descripción de la función del puesto">{{old('DescripciónDelCargo', $cargo->DescripciónDelCargo)}}</textarea>
    </div>

    <div class="form-group">
        <label for="Sueldo"> Sueldo </label>
        <input type="number" class="form-control" name="Sueldo" id="Sueldo" placeholder="00.00" 
        value="{{old('Sueldo', $cargo->Sueldo)}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="reset" class="btn btn-danger" value="Restaurar"> 
    <a class="btn btn-info" href="{{route('cargo.index')}}">Cerrar</a>
</form> 
@endsection

@push('alertas')

<script>
    function confirmar(id) {
       var formul = document.getElementById("form_editarC");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos del cargo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result)=>{
            if (result.isConfirmed) {
                formul.submit();
            }

        })

        event.preventDefault()


    }
</script>
@endpush