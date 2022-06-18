@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Productos')
@section('contenido')

<h1> Registro de producto </h1>

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


<form id="form_guardar" name="form_guardar" method="POST" action="{{ route('producto.guardar') }}" onsubmit="confirmar()">
@csrf
    <div class="form-group">
        <label for="categoria">Categoría</label>
        <select class="form-control" name="Categoria" id="Categoria" required>
            <option value="">--Seleccione--</option>
            @foreach ($categorias as $categoria)
                <option value="{{$categoria['id']}}">{{$categoria['NombreDeLaCategoría']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="NombreDelProducto"> Nombre </label>
        <input type="text" class="form-control" name="NombreDelProducto" id="NombreDelProducto" required
        placeholder="Nombre del producto" maxlength="40" value="{{old('NombreDelProducto')}}">
    </div>

    <div class="form-group">
        <label for="DescripciónDelProducto"> Descripción </label>
        <textarea class="form-control" name="DescripciónDelProducto" id="DescripciónDelProducto" cols="30" rows="10" 
        placeholder="Breve descripción del producto" maxlength="150" required>{{old('DescripciónDelProducto')}}</textarea>
    </div>

    <div class="form-group">
        <label for="">Seleccione una opción para el impuesto</label><br>
        <input required type="radio" id="Impuesto" name="Impuesto" value="0.15"> 15%
        <input required type="radio" id="Exento" name="Impuesto" value="0"> 0%
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Guardar">
    <input type="button" class="btn btn-danger" value="Limpiar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('producto.index')}}">Cerrar</a>

</form>

@endsection

@section('js')
@push('alertas')
    <script>
        function restaurar() {
        $("#NombreDelProducto").val('');
        $("#DescripciónDelProducto").val('');
        $("#Impuesto").val('');
        $("#Categoria").val('');
    }
        function confirmar() {
           var formul = document.getElementById("form_guardar");
            Swal.fire({
                title: '¿Está seguro que desea guardar los datos del nuevo producto?',
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