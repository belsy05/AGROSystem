@extends('Plantillas.plantilla')
@section('titulo', 'Clientes')
@section('contenido')

<h1> Editar cliente </h1>
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

<form id="form_editarC" name="form_editarC" method="POST" action="{{ route('cliente.update', $cliente->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="IdentidadDelCliente"> Identidad </label>
        <input type="tel" class="form-control" name="IdentidadDelCliente" id="IdentidadDelCliente"
        placeholder="Identidad del cliente sin guiones" pattern="[0-1][0-8][0-2][0-9]{10}" required 
        value="{{old('IdentidadDelCliente' , $cliente->IdentidadDelCliente)}}" maxlength="13" title="La identidad debe comenzar con 0 o con 1. Debe ingresar 13 caracteres">
    </div>

    <div class="form-group">
        <label for="NombresDelCliente"> Nombres </label>
        <input type="text" class="form-control" name="NombresDelCliente" id="NombresDelCliente" required
        placeholder="Nombres del cliente" maxlength="30" pattern="[a-zA-ZñÑáéíóú ]+" value="{{old('NombresDelCliente', $cliente->NombresDelCliente )}}" title="No ingrese números ni signos">
    </div>

    <div class="form-group">
        <label for="ApellidosDelCliente"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidosDelCliente" id="ApellidosDelCliente" required title="No ingrese números ni signos"
        placeholder="Apellidos del cliente" maxlength="40" pattern="[a-zA-ZñÑáéíóú ]+" value="{{old('ApellidosDelCliente', $cliente->ApellidosDelCliente)}}">
    </div>

    <div class="form-group">
        <label for="Telefono"> Teléfono </label>
        <input type="tel" class="form-control" name="Telefono" id="Telefono" placeholder="00000000"
        pattern="([2-3, 8-9][0-9]{7})" value="{{old('Telefono', $cliente->Telefono)}}" maxlength="8" title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
    </div>

    <div class="form-group">
        <label for="LugarDeProcedencia"> Dirección </label>
        <input type="text" class="form-control" name="LugarDeProcedencia" id="LugarDeProcedencia" required
        placeholder="Lugar de Procedencia" maxlength="150" value="{{old('LugarDeProcedencia', $cliente->LugarDeProcedencia)}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('cliente.index')}}">Cerrar</a>

</form>

@endsection
@push('alertas')
    <script>
        function restaurar() {
            $("#IdentidadDelCliente").val('{{$cliente->IdentidadDelCliente}}');
            $("#NombresDelCliente").val('{{$cliente->NombresDelCliente}}');
            $("#ApellidosDelCliente").val('{{$cliente->ApellidosDelCliente}}');
            $("#Telefono").val('{{$cliente->Telefono}}');
            $("#LugarDeProcedencia").val('{{$cliente->LugarDeProcedencia}}');
        }
        function confirmar() {
           var formul = document.getElementById("form_editarC");
            Swal.fire({
                title: '¿Está seguro que desea actualizar los datos del cliente?',
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