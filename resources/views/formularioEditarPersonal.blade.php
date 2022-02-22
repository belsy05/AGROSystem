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

<form id="form_editar" name="form_editar" method="POST" action="{{ route('personal.update', $personal->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="cargo">Cargo</label>
        <select class="form-control" name="Cargo" id="Cargo" >
            <option value="">--Seleccione--</option>
            @foreach ($cargos as $cargo)
                <option value="{{$cargo['id']}}">{{$cargo['NombreDelCargo']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="IdentidadDelEmpleado"> Identidad </label>
        <input type="tel" class="form-control" name="IdentidadDelEmpleado" id="IdentidadDelEmpleado" pattern="[0-1][0-8][0-2][0-9]{10}"
        placeholder="Identidad del personal sin guiones" value="{{old('IdentidadDelEmpleado', $personal->IdentidadDelEmpleado)}}">
    </div>

    <div class="form-group">
        <label for="NombresDelEmpleado"> Nombres </label>
        <input type="text" class="form-control" name="NombresDelEmpleado" id="NombresDelEmpleado" 
        placeholder="Nombre del personal" value="{{old('NombresDelEmpleado', $personal->NombresDelEmpleado)}}" maxlength="20">
    </div>

    <div class="form-group">
        <label for="ApellidosDelEmpleado"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidosDelEmpleado" id="ApellidosDelEmpleado" 
        placeholder="Apellido del personal" value="{{old('ApellidosDelEmpleado', $personal->ApellidosDelEmpleado)}}" maxlength="40">
    </div>

    <div class="form-group">
        <label for="">Correo electrónico:</label>
        <input type="email" name="CorreoElectrónico" pattern="^[a-zA-Z0-9.!#$%&+/=?^_`{|}~]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$" class="form-control {{ $errors->has('CorreoElectrónico') ? 'is-invalid' : '' }}"
               value="{{ old('CorreoElectrónico', $personal->CorreoElectrónico) }}" id="CorreoElectrónico" placeholder="hola@ejemplo.com" required
               title="por favor ingrese un correo valido">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="Teléfono"> Teléfono </label>
        <input type="tel" class="form-control" name="Teléfono" id="Teléfono" pattern="([3, 8-9][0-9]{7})"
        placeholder="00000000" value="{{old('Teléfono', $personal->Teléfono)}}">
    </div>

    <?php
        $fecha_actual = date("d-m-Y");
    ?>
    <div class="form-group">
        <label for="FechaDeNacimiento">Fecha Nacimiento:</label>
        <input require type="date" class="form-control" name="FechaDeNacimiento" id="FechaDeNacimiento"
        value="{{old('FechaDeNacimiento', $personal->FechaDeNacimiento)}}"min="<?php echo date('Y-m-d',strtotime($fecha_actual."- 70 year"));?>"
         max="<?php echo date('Y-m-d',strtotime($fecha_actual."- 18 year"));?>">
    </div>


    <div class="form-group">
        <label for="FechaDeIngreso">Fecha Ingreso:</label>
        <input require type="date" class="form-control " name="FechaDeIngreso" id="FechaDeIngreso"
        value="{{old('FechaDeIngreso', $personal->FechaDeIngreso)}}"
        max="<?php echo date('Y-m-d',strtotime($fecha_actual));?>">
    </div>

    <div class="form-group">
        <label for="Ciudad"> Ciudad </label>
        <input type="text" class="form-control" name="Ciudad" id="Ciudad" 
        placeholder="Ciudad" value="{{old('Ciudad', $personal->Ciudad)}}" maxlength="20">
    </div>

    <div class="form-group">
        <label for="Dirección"> Dirección </label>
        <input type="text" class="form-control" name="Dirección" id="Dirección" 
        placeholder="Dirección" value="{{old('Dirección', $personal->Dirección)}}" maxlength="150">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar" >
    <input type="reset" class="btn btn-danger" value="Restaurar"> 
    <a class="btn btn-info" href="{{route('personal.index')}}">Cerrar</a>
</form> 
@endsection



@push('alertas')
<script>

    $('#Cargo').val({{$personal->cargo_id}});

</script>

<script>
    function confirmar(id) {
       var formul = document.getElementById("form_editar");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos del empleado?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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
