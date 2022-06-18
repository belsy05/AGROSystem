@extends('Plantillas.plantilla')

@section('titulo', 'Editar Cargos')

@section('contenido')

<h1> Editar cargo </h1>
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
        value="{{old('NombreDelCargo', $cargo->NombreDelCargo)}}" maxlength="40" required>
    </div>

    <div class="form-group">
        <label for="DescripciónDelCargo"> Descripción </label>
        <textarea required class="form-control" name="DescripciónDelCargo" maxlength="200" id="DescripciónDelCargo" cols="30" rows="10" placeholder="Breve descripción de la función del puesto">{{old('DescripciónDelCargo', $cargo->DescripciónDelCargo)}}</textarea>
    </div>

    <div class="form-group">
        <label for="Sueldo"> Sueldo </label>
        <input type="number" class="form-control" name="Sueldo" id="Sueldo" placeholder="0" min="1000" max="100000" required 
        value="{{old('Sueldo', $cargo->Sueldo)}}" maxlength="8" title="Ingrese el sueldo sin decimales">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()"> 
    <a class="btn btn-info" href="{{route('cargo.index')}}">Cerrar</a>
</form> 
@endsection

@push('alertas')

<script>
    function restaurar() {
        $("#NombreDelCargo").val('{{$cargo->NombreDelCargo}}');
        $("#DescripciónDelCargo").val('{{$cargo->DescripciónDelCargo}}');
        $("#Sueldo").val('{{$cargo->Sueldo}}');
    }
    function confirmar(id) {
       var formul = document.getElementById("form_editarC");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos del cargo?',
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