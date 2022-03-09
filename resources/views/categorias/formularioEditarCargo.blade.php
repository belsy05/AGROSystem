@extends('Plantillas.plantilla')

@section('titulo', 'Editar Categoría')

@section('contenido')

<h1> Editar Categoría </h1>
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

<form id="form_editarC" name="form_editarC" method="POST" action="{{ route('categorias.update', $categoria->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->

    <div class="form-group">
        <label for="NombreDeLaCategoría"> Nombre: </label>
        <input type="text" class="form-control" name="NombreDeLaCategoría" id="NombreDeLaCategoría" placeholder="Nombre de la categoría"
        value="{{old('NombreDeLaCategoría', $categoria->NombreDeLaCategoría)}}" maxlength="40">
    </div>

    <div class="form-group">
        <label for="DescripciónDeLaCategoría"> Descripción </label>
        <textarea class="form-control" name="DescripciónDeLaCategoría" id="DescripciónDeLaCategoría"
            cols="30" rows="10"  placeholder="Breve descripción de la categoría"
                maxlength="150">{{old('DescripciónDeLaCategoría', $categoria->DescripciónDeLaCategoría)}}</textarea>
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="reset" class="btn btn-danger" value="Restaurar">
    <a class="btn btn-info" href="{{route('categoria.index')}}">Cerrar</a>
</form>
@endsection

@push('alertas')

<script>
    function confirmar(id) {
       var formul = document.getElementById("form_editarC");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos de la categoría?',
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
