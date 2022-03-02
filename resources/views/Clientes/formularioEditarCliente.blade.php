@extends('Plantillas.plantilla')
@section('titulo', 'Clientes')
@section('contenido')

<h1> Cliente </h1>
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
        value="{{old('IdentidadDelCliente' , $cliente->IdentidadDelCliente)}}">
    </div>

    <div class="form-group">
        <label for="NombresDelCliente"> Nombres </label>
        <input type="text" class="form-control" name="NombresDelCliente" id="NombresDelCliente" required
        placeholder="Nombres del cliente" maxlength="30" value="{{old('NombresDelCliente', $cliente->NombresDelCliente )}}">
    </div>

    <div class="form-group">
        <label for="ApellidosDelCliente"> Apellidos </label>
        <input type="text" class="form-control" name="ApellidosDelCliente" id="ApellidosDelCliente" required
        placeholder="Apellidos del cliente" maxlength="40" value="{{old('ApellidosDelCliente', $cliente->ApellidosDelCliente)}}">
    </div>

    <div class="form-group">
        <label for="Telefono"> Teléfono </label>
        <input type="tel" class="form-control" name="Telefono" id="Telefono" placeholder="00000000"
        pattern="([3, 8-9][0-9]{7})" value="{{old('Telefono', $cliente->Telefono)}}">
    </div>

    <div class="form-group">
        <label for="LugarDeProcedencia"> Dirección </label>
        <input type="text" class="form-control" name="LugarDeProcedencia" id="LugarDeProcedencia"
        placeholder="Lugar de Procedencia" maxlength="150" value="{{old('LugarDeProcedencia', $cliente->LugarDeProcedencia)}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="reset" class="btn btn-danger" value="Restaurar">
    <a class="btn btn-info" href="{{route('cliente.index')}}">Cerrar</a>

</form>

@endsection
@push('alertas')
    <script>
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