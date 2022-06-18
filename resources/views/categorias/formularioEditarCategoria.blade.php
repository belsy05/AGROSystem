@extends('Plantillas.plantilla')

@section('titulo', 'Editar Categoría')

@section('contenido')

<h1> Editar categoría </h1>
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

<form id="form_editarC" name="form_editarC" method="POST" action="{{ route('categoria.update', $categoria->id) }}" onsubmit="confirmar()">
    @method('put')
    @csrf <!-- PARA PODER ENVIAR EL FORMULARIO -->

    <div class="form-group">
        <label for="NombreDeLaCategoría"> Nombre </label>
        <input type="text" class="form-control" name="NombreDeLaCategoría" id="NombreDeLaCategoría" placeholder="Nombre de la categoría"
        value="{{old('NombreDeLaCategoría', $categoria->NombreDeLaCategoría)}}" maxlength="40" required>
    </div>

    <div class="form-group">
        <label for="DescripciónDeLaCategoría"> Descripción </label>
        <textarea required class="form-control" name="DescripciónDeLaCategoría" id="DescripciónDeLaCategoría"
            cols="30" rows="10"  placeholder="Breve descripción de la categoría"
                maxlength="150">{{old('DescripciónDeLaCategoría', $categoria->DescripciónDeLaCategoría)}}</textarea>
    </div>

    <div class="form-group">
        <label for="">Los productos de esta categoría tendrán fecha de vencimiento </label><br>
            <input required type="radio" id="Si" @if ($categoria->vencimiento == 0) checked @endif name="vencimiento" value="0"> Si
            <input required type="radio" id="No" @if ($categoria->vencimiento == 1) checked @endif name="vencimiento" value="1"> No
    </div>

    <div class="form-group">
        <label for="">Los productos de esta categoría tendrán fecha de elaboración </label><br>
            <input required type="radio" id="Si" @if ($categoria->elaboracion == 0) checked @endif name="elaboracion" value="0"> Si
            <input required type="radio" id="No" @if ($categoria->elaboracion == 1) checked @endif name="elaboracion" value="1"> No
    </div>

    <div class="form-group">
        <label for="NombreDeLaCategoría">Presentación de los productos de esta categoría </label>
        <div id="presentation">
            <div id="campo">
            </div>
            @foreach ($presentacion as $p)
                <input style='width: 95%;float: left;' type='text' class='form-control' name='presentacion{{$p->id}}' id='presentacion[]'
                placeholder='Presentacion' value="{{$p->informacion}}"  maxlength='30'>
                @endforeach
        </div>
        <button type="button" onclick="clonar()" style="width: 5%;float: left;font-size: 16px" class="btn btn-info">+</button>
    </div>

    <br><br>
    <label style="display: none" for="" id="datos">{{$presentacion[0]->informacion}}</label>
    <br>
    <input type="submit" class="btn btn-primary" value="Actualizar">
    <input type="button" class="btn btn-danger" value="Restaurar" onclick="restaurar()">
    <a class="btn btn-info" href="{{route('categoria.index')}}">Cerrar</a>
    
</form>
<script>
    function clonar(){
        var prueba = document.getElementById('presentacion[]').value;
        var dato = document.getElementById('datos').innerHTML;
        if(prueba == dato){
            prueba = "";
        }
        document.getElementById('campo').innerHTML+="<input style='width: 95%;float: left;' type='text' class='form-control' name='presentacion[]' id='presentacion[]' placeholder='Presentacion' value='"+prueba+"' maxlength='30'>";
    }
</script>
@endsection

@push('alertas')

<script>
    function restaurar() {
        $("#NombreDeLaCategoría").val('{{$categoria->NombreDeLaCategoría}}');
        $("#DescripciónDeLaCategoría").val('{{$categoria->DescripciónDeLaCategoría}}');

    }
    function confirmar(id) {
       var formul = document.getElementById("form_editarC");
        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos de la categoría?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result)=>{
            if (result.isConfirmed) {
                formul.submit();
            }
        })
        event.preventDefault()
    }
</script>
@endpush