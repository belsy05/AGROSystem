@extends('Plantillas.plantilla')

@section('titulo', 'Formulario De Servicios Técnicos')

@section('contenido')

    <h1> Registro de servicio técnico </h1>
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

    <form id="form_guardar" name="form_guardar" method="POST" action="{{ route('servicio.guardar') }}" onsubmit="confirmar()">
        @csrf
        <div class="form-group">
            <label for="tecnico">Técnico</label>
            <select class="select222" name="tecnico" id="tecnico" required>
                <option value="">--Seleccione--</option>
                @foreach ($personals as $personal)
                    <option value="{{ $personal['id'] }}" @if (old('tecnico') == $personal->id) @selected(true) @endif>
                        {{ $personal->NombresDelEmpleado}}
                        {{ $personal->ApellidosDelEmpleado}}-{{$personal->NombreDelCargo}}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="Cliente"> Cliente </label>
            <select name="Cliente" id="Cliente" class="select2222" required>
                <option style="display: none;" value="">Seleccione un cliente</option>
                @foreach ($clientes as $c)
                    <option value="{{ $c->id }}" @if (old('Cliente') == $c->id) @selected(true) @endif>
                        {{ $c->IdentidadDelCliente }}-{{ $c->NombresDelCliente }}
                        {{ $c->ApellidosDelCliente }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="Teléfono"> Teléfono del cliente</label>
            <input type="tel" class="form-control" name="Teléfono" id="Teléfono" placeholder="00000000"
                pattern="([2-3, 8-9][0-9]{7})" required value="{{ old('Teléfono') }}" maxlength="8"
                title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
        </div>

        <?php
        $fecha_actual = date('d-m-Y');
        ?>

        <div class="form-group">
            <label style="width: 100%" for=""> Fecha en que se realizará el servicio </label>
            <input style="width: 100%" type="date" name="FechaDeRealizacion"
                class="form-control {{ $errors->has('FechaDeRealizacion') ? 'is-invalid' : '' }}"
                value="{{ old('FechaDeRealizacion') }}" id="FechaDeRealizacion"
                title="Ingrese la fecha en la que hara el servicio" min="<?php echo date('Y-m-d', strtotime($fecha_actual . '+ 1 day')); ?>" max="<?php echo date('Y-m-d', strtotime($fecha_actual . '+ 2 month')); ?>">
        </div>

        <div class="form-group">
            <label for="DescripciónDelServicio"> Descripción </label>
            <textarea class="form-control" name="DescripciónDelServicio" id="DescripciónDelServicio" cols="30" rows="10"
                placeholder="Breve descripción del servicio que se realizará" maxlength="200" required>{{ old('DescripciónDelServicio') }}</textarea>
        </div>

        <div class="form-group">
            <label for="Dirección"> Dirección </label>
            <input type="text" class="form-control" name="Dirección" id="Dirección"
                placeholder="Dirección donde se hará el servicio" maxlength="150" value="{{ old('Dirección') }}"
                required>
        </div>

        <br>
        <input type="submit" class="btn btn-primary" value="Guardar"> 
        <a class="btn btn-danger" href="{{ route('servicio.crear') }}">Limpiar</a>
        <a class="btn btn-info" href="{{ route('servicio.index') }}">Cerrar</a>

    </form>

@endsection

@section('js')
    @push('alertas')
        <script>
            $(document).ready(function() {

                new TomSelect(".select222", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });

            $(document).ready(function() {

                new TomSelect(".select2222", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });

            function restaurar() {
                $("#Dirección").val('');
                $("#DescripciónDelServicio").val('');
                $("#ApellidosDelCliente").val('');
                $("#NombresDelCliente").val('');
                $("#ApellidosDelTecnico").val('');
                $("#NombresDelTecnico").val('');
                $("#FechaDeRealizacion").val('');
                $("#Teléfono").val('');
                $("#Cargo").val('');
            }

            function confirmar() {
                var formul = document.getElementById("form_guardar");


                Swal.fire({
                    title: '¿Está seguro que desea guardar los datos del servicio técnico?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formul.submit();
                    }

                })

                event.preventDefault()


            }
        </script>
    @endpush


@endsection
