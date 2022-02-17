@extends('Plantillas.plantilla')

@section('titulo', 'Formulario De Personal')

@section('contenido')

<h1> Personal </h1>

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

<form method="POST" action="{{ route('personal.update', ['id'=>$personal->id]) }}" id="formulari_editar_personal">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="cargo">Cargo</label>
        <select class="form-control" name="Cargo" id="Cargo" >
            <option value="">--Seleccione--</option>
            @foreach ($cargos as $cargo)
                <option value="{{$cargo['id']}}">{{$cargo['NombreCargo']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="IdentidadPersonal"> Identidad </label>
        <input type="tel" class="form-control" name="IdentidadPersonal" id="IdentidadPersonal" pattern="[0-9]{13}"
        placeholder="Identidad del personal" value="{{$personal->IdentidadPersonal}}">
    </div>

    <div class="form-group">
        <label for="NombrePersonal"> Nombres </label>
        <input type="text" class="form-control" name="NombrePersonal" id="NombrePersonal"
        placeholder="Nombre del personal" value="{{$personal->NombrePersonal}}">
    </div>

    <div class="form-group">
        <label for="ApellidoPersonal"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidoPersonal" id="ApellidoPersonal"
        placeholder="Apellido del personal" value="{{$personal->ApellidoPersonal}}">
    </div>

    <div class="form-group">
        <label for="CorreoElectronico"> Correo Electrónico </label>
        <input type="email" class="form-control" name="CorreoElectronico" id="CorreoElectronico"
        placeholder="nombre.apellido@example.com" value="{{$personal->CorreoElectronico}}">
    </div>

    <div class="form-group">
        <label for="Telefono"> Teléfono </label>
        <input type="tel" class="form-control" name="Telefono" id="Telefono" pattern="[0-9]{8}"
        placeholder="00000000" value="{{$personal->Telefono}}">
    </div>

    <div class="form-group">
        <label for="FechaNacimiento"> Fecha de Nacimiento </label>
        <input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento"
        placeholder="Fecha de nacimiento del empleado" value="{{$personal->FechaNacimiento}}">
    </div>

    <div class="form-group">
        <label for="FechaIngreso"> Fecha de Ingreso </label>
        <input type="date" class="form-control" name="FechaIngreso" id="FechaIngreso"
        placeholder="Fecha de ingreso del empleado" value="{{$personal->FechaIngreso}}">
    </div>

    <div class="form-group">
        <label for="Ciudad"> Ciudad </label>
        <input type="text" class="form-control" name="Ciudad" id="Ciudad"
        placeholder="Ciudad" value="{{$personal->Ciudad}}">
    </div>

    <div class="form-group">
        <label for="Direccion"> Dirección </label>
        <input type="text" class="form-control" name="Direccion" id="Direccion"
        placeholder="Direccion" value="{{$personal->Direccion}}">
    </div>

    <br>
    <button type="button" class="btn btn-primary" onclick="confirmar()">Actualizar</button>
    <button type="button" class="btn btn-danger" onclick="limpiar()">Restaurar</button>
    <a class="btn btn-info" onclick="cerrar()" href="#">Cerrar</a>
</form>
@endsection



@push('alertas')
<script>

    $('#Cargo').val({{$personal->cargo_id}});

    function confirmar() {
        var formulario = document.getElementById("formulari_editar_personal");
        Swal.fire({
                title: '¿Está seguro que desea actualizar los datos del empleado?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    formulario.submit();
                }


            })
    }

    function limpiar() {
        var formulario = document.getElementById("formulari_editar_personal");
        Swal.fire({
                title: 'Desea restaurar todos los campos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location.href = window.location.href;
                }


            })
    }

    function cerrar() {
        var formulario = document.getElementById("formulari_editar_personal");
        Swal.fire({
                title: 'Deseas dejar de actualizar al personal?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location='/personals';
                }

            })
    }

</script>
@endpush
