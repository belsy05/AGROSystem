@extends('Plantillas.plantilla')
@section('titulo', 'Formulario Del Proveedor')
@section('contenido')

<h1> Editar proveedor </h1>
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

<form id="form_editar" name="form_editar" method="POST" action="{{ route('proveedor.update', $proveedor->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="EmpresaProveedora"> Empresa proveedora </label>
        <input type="text" class="form-control" name="EmpresaProveedora" id="EmpresaProveedora" required
        placeholder="Nombres de la empresa proveedora" maxlength="40" value="{{old('EmpresaProveedora', 
        $proveedor->EmpresaProveedora)}}">
    </div>

    <div class="form-group">
        <label for="DirecciónDeLaEmpresa"> Dirección </label>
        <input type="text" class="form-control" name="DirecciónDeLaEmpresa" id="DirecciónDeLaEmpresa"
        placeholder="Dirección de la empresa" required maxlength="150" value="{{old('DirecciónDeLaEmpresa',
        $proveedor->DirecciónDeLaEmpresa)}}">
    </div>

    <div class="form-group">
        <label for=""> Correo electrónico </label>
        <input type="email" name="CorreoElectrónicoDeLaEmpresa" pattern="^[a-zA-Z0-9.!#$%&+/=?^_`{|}~]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$" class="form-control 
        {{ $errors->has('CorreoElectrónicoDeLaEmpresa') ? 'is-invalid' : '' }}" value="{{ old('CorreoElectrónicoDeLaEmpresa',
        $proveedor->CorreoElectrónicoDeLaEmpresa)}}" 
        id="CorreoElectrónicoDeLaEmpresa" placeholder="hola@ejemplo.com" maxlength="100" 
               title="Por favor ingrese un correo válido">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="TeléfonoDeLaEmpresa"> Teléfono de la empresa </label>
        <input type="tel" class="form-control" name="TeléfonoDeLaEmpresa" id="TeléfonoDeLaEmpresa" 
        placeholder="00000000" pattern="([2-3, 8-9][0-9]{7})" required value="{{old('TeléfonoDeLaEmpresa',
        $proveedor->TeléfonoDeLaEmpresa)}}" maxlength="8" title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
    </div>

    <div class="form-group">
        <label for="NombresDelEncargado"> Nombres del encargado </label>
        <input type="text" class="form-control" name="NombresDelEncargado" id="NombresDelEncargado" required title="No ingrese números ni signos"
        placeholder="Nombres del encargado en la empresa" pattern="[a-zA-ZñÑáéíóú ]+" maxlength="30" value="{{old('NombresDelEncargado',
        $proveedor->NombresDelEncargado)}}">
    </div>

    <div class="form-group">
        <label for="ApellidosDelEncargado"> Apellidos del Encargado </label>
        <input type="text" class="form-control" name="ApellidosDelEncargado" id="ApellidosDelEncargado" required title="No ingrese números ni signos"
        placeholder="Apellidos del encargado en la empresa" pattern="[a-zA-ZñÑáéíóú ]+" maxlength="40" value="{{old('ApellidosDelEncargado',
        $proveedor->ApellidosDelEncargado)}}">
    </div>

    <div class="form-group">
        <label for="TeléfonoDelEncargado"> Teléfono del encargado </label>
        <input type="tel" class="form-control" name="TeléfonoDelEncargado" id="TeléfonoDelEncargado" 
        placeholder="00000000" pattern="([2-3, 8-9][0-9]{7})" required value="{{old('TeléfonoDelEncargado',
        $proveedor->TeléfonoDelEncargado)}}" maxlength="8" title="El teléfono debe comenzar con 2, 3, 8 o 9. Debe ingresar 8 caracteres">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('proveedor.index')}}">Cerrar</a>

</form>

@endsection

@section('js')
    @push('alertas')
        <script>
            function restaurar() {
        $("#EmpresaProveedora").val('{{$proveedor->EmpresaProveedora}}');
        $("#DirecciónDeLaEmpresa").val('{{$proveedor->DirecciónDeLaEmpresa}}');
        $("#CorreoElectrónicoDeLaEmpresa").val('{{$proveedor->CorreoElectrónicoDeLaEmpresa}}');
        $("#TeléfonoDeLaEmpresa").val('{{$proveedor->TeléfonoDeLaEmpresa}}');
        $("#NombresDelEncargado").val('{{$proveedor->NombresDelEncargado}}');
        $("#ApellidosDelEncargado").val('{{$proveedor->ApellidosDelEncargado}}');
        $("#TeléfonoDelEncargado").val('{{$proveedor->TeléfonoDelEncargado}}');
    }

            function confirmar() {
            var formul = document.getElementById("form_editar");
                Swal.fire({
                    title: '¿Está seguro que desea actualizar los datos del proveedor?',
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
@endsection