@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Editar Productos')
@section('contenido')

<h1> Editar producto </h1>

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


<form id="form_editarP" name="form_editarP" method="POST" action="{{ route('producto.update', $producto->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->
    <div class="form-group">
        <label for="categoria">Categoria</label>
        <select class="form-control" name="Categoria" id="Categoria" required>
            <option value="">--Seleccione--</option>
            @foreach ($categorias as $categoria)
                <option @if ($producto->categoria_id == $categoria['id'])
                    selected
                @endif value="{{$categoria['id']}}">{{$categoria['NombreDeLaCategoría']}}</option>
            @endforeach
        </select>
    </div>

    
    <div class="form-group">
        <label for="NombreDelProducto"> Nombre </label>
        <input type="text" class="form-control" name="NombreDelProducto" id="NombreDelProducto" required
        placeholder="Nombre del producto" maxlength="30" value="{{old('NombreDelProducto',$producto->NombreDelProducto)}}">
    </div>

    <div class="form-group">
        <label for="DescripciónDelProducto"> Descripción </label>
        <textarea class="form-control" name="DescripciónDelProducto" id="DescripciónDelProducto"
            cols="30" rows="10"  placeholder="Breve descripción deL producto"
                maxlength="150" required>{{old('DescripciónDelProducto', $producto->DescripciónDelProducto)}}</textarea>
    </div>

    <div class="form-group">
        <label for="">Seleccione una opción para el impuesto</label><br>
        <input required type="radio" name="Impuesto" value="0.15" @if ($producto->Impuesto == 0.15) checked @endif> 15%
        <input required type="radio" name="Impuesto" value="0" @if ($producto->Impuesto == 0) checked @endif> 0%
    </div>

 <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('producto.index')}}">Cerrar</a>


</form>

@endsection

@section('js')
@push('alertas')

    <script>
        function restaurar() {
        $("#NombreDelProducto").val('{{$producto->NombreDelProducto}}');
        $("#DescripciónDelProducto").val('{{$producto->DescripciónDelProducto}}');
        $("#PresentaciónDelProducto").val('{{$producto->PresentaciónDelProducto}}');
        $("#Impuesto").val('{{$producto->Impuesto}}');
        $("#Categoria").val('{{$producto->categoria_id}}');
    }
        function confirmar() {
           var formul = document.getElementById("form_editarP");
            Swal.fire({
                title: '¿Está seguro que desea actualizar los datos del producto?',
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