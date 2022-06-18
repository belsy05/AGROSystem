@extends('Plantillas.plantilla')
@section('titulo', 'Formulario Editar Servicios')
@section('contenido')

<h1> Editar servicio </h1>
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

<form id="form_editar" name="form_editar" method="POST" action="{{ route('servicio.update', $servicio->id) }}" onsubmit="confirmar()">
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

    <?php $fecha_actual = date('d-m-Y'); ?>

    <div class="form-group">
            <label style="width: 100%" for=""> Fecha en que se realizará el servicio </label>
            <input style="width: 100%" type="date" name="FechaDeRealizacion"
                class="form-control {{ $errors->has('FechaDeRealizacion') ? 'is-invalid' : '' }}"
                value="{{ old('FechaDeRealizacion', $servicio->FechaDeRealizacion) }}" id="FechaDeRealizacion" title="Ingrese la fecha en la que hara el servicio" min="<?php echo date('Y-m-d', strtotime($fecha_actual . '+ 1 day')); ?>">
    </div>


    <div class="form-group">
        <label for="DescripciónDelServicio"> Descripción </label>
        <textarea required class="form-control" name="DescripciónDelServicio" maxlength="200" id="DescripciónDelServicio" cols="30" rows="10" placeholder="Breve descripción de la función del puesto">{{old('DescripciónDelCargo', $cargo->DescripciónDelCargo)}}</textarea>
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar" >
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('servicio.index')}}">Cerrar</a>
</form>
@endsection



@push('alertas')
<script>

    $('#Cargo').val({{$servicio->cargo_id}});

</script>

<script>
    function restaurar() {
        $("#Dirección").val('{{$servicio->Dirección}}');
        $("#DescripciónDelServicio").val('{{$servicio->DescripciónDelServicio}}');
        $("#ApellidosDelCliente").val('{{$servicio->ApellidosDelCliente}}');
        $("#NombresDelCliente").val('{{$servicio->NombresDelCliente}}');
        $("#ApellidosDelTecnico").val('{{$servicio->ApellidosDelTecnico}}');
        $("#NombresDelTecnico").val('{{$servicio->NombresDelTecnico}}');
        $("#FechaDeRealizacion").val('{{$servicio->FechaDeRealizacion}}');
        $("#Teléfono").val('{{$servicio->Teléfono}}');
        $("#Cargo").val('{{$servicio->cargo_id}}');

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
