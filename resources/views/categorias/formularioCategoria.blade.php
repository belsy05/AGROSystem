@extends('Plantillas.plantilla')

@section('titulo', 'Registro de Categorías')

@section('contenido')

<h1> Registro de categoría </h1>
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

<form id="form_guardarC" name="form_guardarC" method="POST" action="{{ route('categoria.guardar') }}" onsubmit="confirmar()">
    @csrf

    <div class="form-group">
        <label for="NombreDeLaCategoría"> Nombre </label>
        <input type="text" class="form-control" name="NombreDeLaCategoría" id="NombreDeLaCategoría"
        placeholder="Nombre de la categoría" value="{{old('NombreDeLaCategoría')}}" maxlength="30" required>
    </div>

    <div class="form-group">
        <label for="DescripciónDeLaCategoría"> Descripción </label>
        <textarea class="form-control" name="DescripciónDeLaCategoría" id="DescripciónDeLaCategoría" cols="30" rows="10" 
        placeholder="Breve descripción de la categoría" maxlength="150" required>{{old('DescripciónDeLaCategoría')}}</textarea>
    </div>

    <div class="form-group">
        <label for="">Los productos de esta categoría tendrán fecha de vencimiento </label><br>
        <input required type="radio" id="Si" name="vencimiento" value="0"> Si
        <input required type="radio" id="No" name="vencimiento" value="1"> No
    </div>

    <div class="form-group">
        <label for="">Los productos de esta categoría tendrán fecha de elaboración </label><br>
        <input required type="radio" id="Si" name="elaboracion" value="0"> Si
        <input required type="radio" id="No" name="elaboracion" value="1"> No
    </div>

    <div class="form-group">
        <label for="NombreDeLaCategoría">Presentación de los productos de esta categoría </label>
        <div id="presentation">
            <div id="campo">
                <input style='width: 95%;float: left;' type='text' class='form-control' name='presentacion[]' id='presentacion[]'
                placeholder='Presentacion' value="{{old('presentacion[]')}}"  maxlength='30'>
            </div>
        </div>
        <button type="button" onclick="clonar()" style="width: 5%;float: left;font-size: 16px" class="btn btn-info">+</button>
    </div>

    <br><br>
    <input type="submit" class="btn btn-primary" value="Guardar">
    <input type="button" class="btn btn-danger" value="Limpiar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('categoria.index')}}">Cerrar</a>

</form>
<script>
    function clonar(){
        var prueba = document.getElementById('presentacion[]').value;
        document.getElementById('campo').innerHTML+="<br><br><input style='width: 95%;float: left;' type='text' class='form-control' name='presentacion[]' id='presentacion[]' placeholder='Presentacion' value='"+prueba+"' maxlength='30'>";
    }
</script>

@endsection
@section('name')
    
@endsection
@push('alertas')
    <script>
        function restaurar() {
        $("#NombreDeLaCategoría").val('');
        $("#DescripciónDeLaCategoría").val('');

    }
        function confirmar() {
           var formul = document.getElementById("form_guardarC");
            Swal.fire({
                title: '¿Está seguro que desea guardar los datos de la nueva categoría?',
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