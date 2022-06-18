@extends('Plantillas.plantilla')
@section('titulo', 'Editar servicio técnico')
@section('contenido')

    <h1> Editar servicio técnico</h1>
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
            <label for="tecnico">Técnico</label>
            <select class="form-control" name="tecnico" id="tecnico" required>
                <option value="">--Seleccione--</option>
                @foreach ($personals as $personal)
                    <option @if ($servicio->empleado_id == $personal['id'])
                                selected
                            @endif
                            value="{{$personal['id']}}">{{$personal['NombresDelEmpleado']}} {{$personal['ApellidosDelEmpleado']}}</option>
                @endforeach
            </select>
        </div>
    <div class="form-group">
        <label for="Cliente"> Cliente </label>
            <select name="Cliente" id="Cliente" class="form-control" required>
                <option style="display: none;" value="">Seleccione un cliente</option>
                @foreach ($clientes as $cliente)
                    <option @if ($servicio->cliente_id == $cliente['id'])
                                selected
                            @endif
                            value="{{$cliente['id']}}">{{$cliente['NombresDelCliente']}} {{$cliente['ApellidosDelCliente']}}</option>
                @endforeach
        </select>
    </div>

        <div class="form-group">
            <label for="Teléfono"> Teléfono </label>
            <input type="tel" class="form-control" name="TeléfonoCliente" id="TeléfonoCliente" pattern="([2-3, 8-9][0-9]{7})" required
                   placeholder="00000000" value="{{old('TeléfonoCliente', $servicio->TeléfonoCliente)}}" maxlength="8" title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
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
            <textarea required class="form-control" name="DescripciónDelServicio" maxlength="200" id="DescripciónDelServicio" cols="30" rows="10" placeholder="Breve descripción de la función del servicio">{{old('DescripciónDelServicio', $servicio->DescripciónDelServicio)}}</textarea>
        </div>

        <div class="form-group">
            <label for="Dirección"> Dirección </label>
            <input type="text" class="form-control" name="Dirección" id="Dirección" maxlength="150" required
                   placeholder="Dirección donde se hará el servicio" value="{{old('Dirección', $servicio->Dirección)}}" >
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
            $("#tecnico").val('{{$servicio->empleado_id}}');
            $("#Cliente").val('{{$servicio->cliente_id}}');
            $("#DescripciónDelServicio").val('{{$servicio->DescripciónDelServicio}}');
            $("#FechaDeRealizacion").val('{{$servicio->FechaDeRealizacion}}');
            $("#TeléfonoCliente").val('{{$servicio->TeléfonoCliente}}');
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
