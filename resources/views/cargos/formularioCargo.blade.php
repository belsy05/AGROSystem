@extends('Plantillas.plantilla')

@section('titulo', 'Registro de cargos')

@section('contenido')

<h1> Registro de cargo </h1>
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

<form id="form_guardarC" name="form_guardarC" method="POST" action="{{ route('cargo.guardar') }}" onsubmit="confirmar()">
    @csrf

    <div class="form-group">
        <label for="NombreDelCargo"> Nombre </label>
        <input type="text" class="form-control" name="NombreDelCargo" id="NombreDelCargo" placeholder="Nombre del cargo"
        maxlength="40" value="{{old('NombreDelCargo')}}" required>
    </div>

    <div class="form-group">
        <label for="DescripciónDelCargo"> Descripción </label>
        <textarea class="form-control" name="DescripciónDelCargo" id="DescripciónDelCargo" cols="30" rows="10"
        placeholder="Breve descripción de la función del puesto" maxlength="200" required>{{old('DescripciónDelCargo')}}</textarea>
    </div>

    <div class="form-group">
        <label for="Sueldo"> Sueldo </label>
        <input required type="number" class="form-control" min="1000" max="100000" name="Sueldo" id="Sueldo"
        placeholder="00" value="{{old('Sueldo')}}" maxlength="8" title="Ingrese el sueldo sin decimales">
    </div>

    <br>
    <input type="submit" class="btn btn-primary"  value="Guardar">
    <input type="button" class="btn btn-danger" value="Limpiar" onclick="restaurar()">
    <a class="btn btn-info" href="{{ route('cargo.index') }}" >Cerrar</a>

</form>

@endsection
@push('alertas')
    <script>
        function restaurar() {
        $("#NombreDelCargo").val('');
        $("#DescripciónDelCargo").val('');
        $("#Sueldo").val('');
    }
        function confirmar() {
           var formul = document.getElementById("form_guardarC");


            Swal.fire({
                title: '¿Está seguro que desea guardar los datos del nuevo cargo?',
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
