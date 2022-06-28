@extends('Plantillas.plantilla')

@section('titulo', 'Registro de Gasto')

@section('contenido')

<h1> Registro de Gasto </h1>
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

<form id="form_guardarC" name="form_guardarC" method="POST" action="{{ route('gasto.guardar') }}" onsubmit="confirmar()">
    @csrf

    <div class="form-group">
        <label for="nombre"> Nombre </label>
        <input type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre del gasto" 
        maxlength="40" value="{{old('nombre')}}" required>
    </div>

    <div class="form-group">
        <label for="descripcion"> Descripcion </label>
        <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Descripcion del gasto" 
        maxlength="40" value="{{old('descripcion')}}" required>
    </div>

    <div class="form-group">
        <label for="tipo"> Tipo </label>
        <input type="text" class="form-control" name="tipo" id="tipo" placeholder="Tipo del gasto" 
        maxlength="40" value="{{old('tipo')}}" required>
    </div>

    <div class="form-group">
        <label for="fecha"> Fecha </label>
        <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha del gasto" 
         value="{{old('fecha')}}" required>
    </div>

    <div class="form-group">
        <label for="total"> Total </label>
        <input type="number" class="form-control" name="total" id="total" placeholder="Total del gasto" 
         value="{{old('total')}}" required step="any">
    </div>

    <div class="form-group">
        <label for="responsable"> Responsable </label>
        <input type="text" class="form-control" name="responsable" id="responsable" placeholder="Responsable del gasto" 
         value="{{old('responsable')}}" required>
    </div>

    <br>
    <input type="submit" class="btn btn-primary"  value="Guardar">
    <input type="button" class="btn btn-danger" value="Limpiar" onclick="restaurar()">
    <a class="btn btn-info" href="" >Cerrar</a>

</form>

@endsection
@push('alertas')
    <script>
        function restaurar() {
        $("#nombre").val('');
        $("#descripcion").val('');
        $("#tipo").val('');
        $("#fecha").val('');
        $("#total").val('');
        $("#responsable").val('');
    }
        function confirmar() {
           var formul = document.getElementById("form_guardarC");


            Swal.fire({
                title: '¿Está seguro que desea guardar los datos del nuevo gasto?',
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