@extends('Plantillas.plantilla')
@section('titulo', 'Formulario Del Proveedor')
@section('contenido')

<h1> Proveedor </h1>
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
        <label for="EmpresaProveedora"> Empresa Proveedora </label>
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
        <label for=""> Correo Electrónico </label>
        <input type="email" name="CorreoElectrónicoDeLaEmpresa" pattern="^[a-zA-Z0-9.!#$%&+/=?^_`{|}~]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)$" class="form-control 
        {{ $errors->has('CorreoElectrónicoDeLaEmpresa') ? 'is-invalid' : '' }}" value="{{ old('CorreoElectrónicoDeLaEmpresa',
        $proveedor->CorreoElectrónicoDeLaEmpresa)}}" 
        id="CorreoElectrónicoDeLaEmpresa" placeholder="hola@ejemplo.com" maxlength="40" 
               title="Por favor ingrese un correo válido">
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-envelope"></span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label for="TeléfonoDeLaEmpresa"> Teléfono de la Empresa </label>
        <input type="tel" class="form-control" name="TeléfonoDeLaEmpresa" id="TeléfonoDeLaEmpresa" 
        placeholder="00000000" pattern="([3, 8-9][0-9]{7})" required value="{{old('TeléfonoDeLaEmpresa',
        $proveedor->TeléfonoDeLaEmpresa)}}">
    </div>

    <div class="form-group">
        <label for="NombresDelEncargado"> Nombres del Encargado </label>
        <input type="text" class="form-control" name="NombresDelEncargado" id="NombresDelEncargado" required
        placeholder="Nombres del encargado en la empresa" maxlength="30" value="{{old('NombresDelEncargado',
        $proveedor->NombresDelEncargado)}}">
    </div>

    <div class="form-group">
        <label for="ApellidosDelEncargado"> Apellidos del Encargado </label>
        <input type="text" class="form-control" name="ApellidosDelEncargado" id="ApellidosDelEncargado" required
        placeholder="Apellidos del encargado en la empresa" maxlength="40" value="{{old('ApellidosDelEncargado',
        $proveedor->ApellidosDelEncargado)}}">
    </div>

    <div class="form-group">
        <label for="TeléfonoDelEncargado"> Teléfono del Encargado </label>
        <input type="tel" class="form-control" name="TeléfonoDelEncargado" id="TeléfonoDelEncargado" 
        placeholder="00000000" pattern="([3, 8-9][0-9]{7})" required value="{{old('TeléfonoDelEncargado',
        $proveedor->TeléfonoDelEncargado)}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="reset" class="btn btn-danger" value="Restaurar">
    <a class="btn btn-info" href="{{route('proveedor.index')}}">Cerrar</a>

</form>

@endsection

@section('js')
    @push('alertas')
        <script>
            function confirmar() {
            var formul = document.getElementById("form_editar");
                Swal.fire({
                    title: '¿Está seguro que desea actualizar los datos del proveedor?',
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
@endsection
