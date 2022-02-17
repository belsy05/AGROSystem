@extends('Plantillas.plantilla')

@section('titulo', 'Formulario Del Personal')

@section('contenido')

<h1> Registro de Personal </h1>

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

<form method="POST" action="{{ route('personal.crear') }}" id="formulari_nuevo_personal">
    @csrf
    <div class="form-group">
        <label for="cargo">Cargo</label>
        <select class="form-control" name="Cargo" id="Cargo">
            <option value="">--Seleccione--</option>
            @foreach ($cargos as $cargo)
            <option value="{{$cargo['id']}}">{{$cargo['NombreCargo']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="IdentidadPersonal"> Identidad </label>
        <input type="tel" class="form-control" name="IdentidadPersonal" id="IdentidadPersonal"
            placeholder="Identidad del empleado" pattern="[0-9]{13}">
    </div>

    <div class="form-group">
        <label for="NombrePersonal"> Nombres </label>
        <input type="text" class="form-control" name="NombrePersonal" id="NombrePersonal"
            placeholder="Nombres del empleado">
    </div>

    <div class="form-group">
        <label for="ApellidoPersonal"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidoPersonal" id="ApellidoPersonal"
            placeholder="Apellidos del empleado">
    </div>

    <div class="form-group">
        <label for="CorreoElectronico"> Correo Electrónico </label>
        <input type="email" class="form-control" name="CorreoElectronico" id="CorreoElectronico"
            placeholder="nombre.apellido@example.com">
    </div>

    <div class="form-group">
        <label for="Telefono"> Teléfono </label>
        <input type="tel" class="form-control" name="Telefono" id="Telefono" placeholder="00000000"
            pattern="([0-9]{8})">
    </div>

    <div class="form-group">
        <label for="FechaNacimiento"> Fecha de Nacimiento </label>
        <input type="date" class="form-control" name="FechaNacimiento" id="FechaNacimiento"
            placeholder="Fecha de Nacimiento del Empleado">
    </div>

    <div class="form-group">
        <label for="FechaIngreso"> Fecha de Ingreso </label>
        <input type="date" class="form-control" name="FechaIngreso" id="FechaIngreso"
            placeholder="Fecha de Ingreso del Empleado">
    </div>

    <div class="form-group">
        <label for="Ciudad"> Ciudad </label>
        <input type="text" class="form-control" name="Ciudad" id="Ciudad" placeholder="Ciudad del empleado">
    </div>

    <div class="form-group">
        <label for="Direccion"> Dirección </label>
        <input type="text" class="form-control" name="Direccion" id="Direccion" placeholder="Direccion del empleado">
    </div>

    <br>
    <button type="button" class="btn btn-primary" value=""
        onclick="confirmar()">Guardar</button>
    <button type="button"  onclick="limpiar()" class="btn btn-danger" value="">Limpiar</button>
    <a class="btn btn-info" onclick="cerrar()" href="#">Cerrar</a>

</form>


@endsection

@push('alertas')
<script>

    function confirmar() {
        var formulario = document.getElementById("formulari_nuevo_personal");
        Swal.fire({
                title: 'Deseas guardar estos datos?',
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
        var formulario = document.getElementById("formulari_nuevo_personal");
        Swal.fire({
                title: 'Desea limpiar todos los campos?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    formulario.reset();
                }


            })
    }

    function cerrar() {
        var formulario = document.getElementById("formulari_nuevo_personal");
        Swal.fire({
                title: 'Deseas dejar de guardar al personal?',
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
