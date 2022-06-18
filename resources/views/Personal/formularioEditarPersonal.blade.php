@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Personal')
@section('contenido')

<h1> Editar personal </h1>
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

<form id="form_editar" name="form_editar" method="POST" action="{{ route('personal.update', $personal->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="cargo">Cargo</label>
        <select class="form-control" name="Cargo" id="Cargo" required>
            <option value="">--Seleccione--</option>
            @foreach ($cargos as $cargo)
                <option @if ($personal->cargo_id == $cargo['id'])
                    selected
                @endif
                 value="{{$cargo['id']}}">{{$cargo['NombreDelCargo']}}</option>
            @endforeach
        </select>
    </div>


    <div class="form-group">
        <label for="IdentidadDelEmpleado"> Identidad </label>
        <input type="tel" class="form-control" name="IdentidadDelEmpleado" id="IdentidadDelEmpleado" pattern="[0-1][0-8][0-2][0-9]{10}" required
        placeholder="Identidad del personal sin guiones" value="{{old('IdentidadDelEmpleado', $personal->IdentidadDelEmpleado)}}" maxlength="13" title="La identidad debe comenzar con 0 o con 1. Debe ingresar 13 caracteres">
    </div>

    <div class="form-group">
        <label for="NombresDelEmpleado"> Nombres </label>
        <input type="text" class="form-control" name="NombresDelEmpleado" id="NombresDelEmpleado" title="No ingrese números ni signos" required
        placeholder="Nombre del personal" pattern="[a-zA-ZñÑáéíóú ]+" value="{{old('NombresDelEmpleado', $personal->NombresDelEmpleado)}}" maxlength="20">
    </div>

    <div class="form-group">
        <label for="ApellidosDelEmpleado"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidosDelEmpleado" id="ApellidosDelEmpleado" title="No ingrese números ni signos" required
        placeholder="Apellido del personal" pattern="[a-zA-ZñÑáéíóú ]+" value="{{old('ApellidosDelEmpleado', $personal->ApellidosDelEmpleado)}}" maxlength="40">
    </div>

    <div class="form-group">
        <label for="">Correo electrónico:</label>
        <input type="email" name="CorreoElectrónico" pattern="^[a-zA-Z0-9.!#$%&+/=?^_`{|}~]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$" class="form-control {{ $errors->has('CorreoElectrónico') ? 'is-invalid' : '' }}"
               value="{{ old('CorreoElectrónico', $personal->CorreoElectrónico) }}" id="CorreoElectrónico" placeholder="hola@ejemplo.com" required
               title="por favor ingrese un correo valido" maxlength="100">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="Teléfono"> Teléfono </label>
        <input type="tel" class="form-control" name="Teléfono" id="Teléfono" pattern="([2-3, 8-9][0-9]{7})" required
        placeholder="00000000" value="{{old('Teléfono', $personal->Teléfono)}}" maxlength="8" title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
    </div>

    <?php
        $fecha_actual = date("d-m-Y");
    ?>
    <div class="form-group">
        <label for="FechaDeNacimiento">Fecha nacimiento:</label>
        <input required type="date" class="form-control" name="FechaDeNacimiento" id="FechaDeNacimiento"
        value="{{old('FechaDeNacimiento', $personal->FechaDeNacimiento)}}"min="<?php echo date('Y-m-d',strtotime($fecha_actual."- 70 year"));?>"
         max="<?php echo date('Y-m-d',strtotime($fecha_actual."- 18 year"));?>">
    </div>


    <div class="form-group">
        <label for="FechaDeIngreso">Fecha ingreso:</label>
        <input required type="date" class="form-control " name="FechaDeIngreso" id="FechaDeIngreso"
        value="{{old('FechaDeIngreso', $personal->FechaDeIngreso)}}"
        max="<?php echo date('Y-m-d',strtotime($fecha_actual));?>">
    </div>

    <div class="form-group">
        <label for="Ciudad"> Ciudad </label>
        <input type="text" class="form-control" name="Ciudad" id="Ciudad"
        placeholder="Ciudad" value="{{old('Ciudad', $personal->Ciudad)}}" maxlength="20" required>
    </div>

    <div class="form-group">
        <label for="Dirección"> Dirección </label>
        <input type="text" class="form-control" name="Dirección" id="Dirección"
        placeholder="Dirección" value="{{old('Dirección', $personal->Dirección)}}" maxlength="150" required>
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar" >
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('personal.index')}}">Cerrar</a>
</form>
@endsection



@push('alertas')
<script>

    $('#Cargo').val({{$personal->cargo_id}});

</script>

<script>
    function restaurar() {
        $("#Dirección").val('{{$personal->Dirección}}');
        $("#ApellidosDelEmpleado").val('{{$personal->ApellidosDelEmpleado}}');
        $("#NombresDelEmpleado").val('{{$personal->NombresDelEmpleado}}');
        $("#Ciudad").val('{{$personal->Ciudad}}');
        $("#FechaDeIngreso").val('{{$personal->FechaDeIngreso}}');
        $("#FechaDeNacimiento").val('{{$personal->FechaDeNacimiento}}');
        $("#Teléfono").val('{{$personal->Teléfono}}');
        $("#CorreoElectrónico").val('{{$personal->CorreoElectrónico}}');
        $("#IdentidadDelEmpleado").val('{{$personal->IdentidadDelEmpleado}}');
        $("#Cargo").val('{{$personal->cargo_id}}');
    }
    function confirmar(id) {
       var formul = document.getElementById("form_editar");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos del empleado?',
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