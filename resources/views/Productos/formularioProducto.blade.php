@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Productos')
@section('contenido')

<h1> Registro de Productos </h1>

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
        <label for="cargo">Categoria</label>
        <select class="form-control" name="Categoria" id="Categoria" required>
            <option value="">--Seleccione--</option>
            @foreach ($categorias as $categoria)
                <option value="{{$categoria['id']}}">{{$categoria['NombreDeLaCategoria']}}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="CódigoDelProducto"> Código </label>
        <input type="tel" class="form-control" name="CódigoDelProducto" id="CódigoDelProducto"
        placeholder="Código del producto" pattern="[0-1][0-8][0-2][0-9]{10}" required value="{{old('CódigoDelProducto')}}">
    </div>

    <div class="form-group">
        <label for="NombreDelProducto"> Nombre </label>
        <input type="text" class="form-control" name="NombreDelProducto" id="NombreDelProducto" required
        placeholder="Nombre del producto" maxlength="30" value="{{old('NombreDelProducto')}}">
    </div>

    <div class="form-group">
        <label for="DescripciónDelProducto"> Descripción </label>
        <input type="text" class="form-control" name="DescripciónDelProducto" id="DescripciónDelProducto" required
        placeholder="Descripción del producto" maxlength="40" value="{{old('DescripciónDelProducto')}}">
    </div>

    <div class="form-group">
        <label for="PresentaciónDelProducto"> Presentación  </label>
        <input type="text" class="form-control" name="PresentaciónDelProducto" id="PresentaciónDelProducto" required
        placeholder="Presentación del producto" required value="{{old('PresentaciónDelProducto')}}">
    </div>

    <div class="form-group">
        <label for="Impuesto"> Impuesto </label>
        <input type="text" class="form-control" name="Impuesto" id="Impuesto" required
        placeholder="Impuesto del producto" maxlength="40" value="{{old('Impuesto')}}">
    </div>

    <div class="form-group">
        <label for="FechaDeElaboración">Fecha De Elaboración</label>
        <input require type="date" class="form-control" name="FechaDeElaboración" id="FechaDeElaboración"
        value="{{old('FechaDeElaboración')}}">
    </div>


    <div class="form-group">
        <label for="FechaDeVencimiento">Fecha De Vencimiento</label>
        <input require type="date" class="form-control " name="FechaDeVencimiento" id="FechaDeVencimiento"
        value="{{old('FechaDeVencimiento')}}">
    </div>

    <br>
    <input type="submit" class="btn btn-primary" value="Guardar">
    <input type="reset" class="btn btn-danger" value="Limpiar">
    <a class="btn btn-info" href="{{route('producto.index')}}">Cerrar</a>


</form>

@endsection

@section('js')
@push('alertas')
    <script>
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
