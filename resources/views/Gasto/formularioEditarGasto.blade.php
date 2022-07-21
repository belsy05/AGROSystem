@extends('Plantillas.plantilla')
@section('titulo', 'Editar gastos')
@section('contenido')

    <h1> Editar gastos</h1>
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

    <form id="form_editar" name="form_editar" method="POST" action="{{ route('gasto.mostrar', $gasto->id) }}" onsubmit="confirmar()">
        @method('put')
        @csrf 

        <div class="form-group">
            <label for="responsable"> Responsable </label>
             <select name="responsable" id="responsable" class="select222" required>
                @if (old('responsable', $gasto->responsable))
                    @foreach ($personal as $p)
                        @if ($p->id == old('responsable'))
                            <option style="display: none" value="{{old('responsable')}}">{{$p->NombresDelEmpleado}} {{$p->ApellidosDelEmpleado}}</option>
                        @endif
                    @endforeach
                @else
                <option style="display: none" value="">Seleccione al empleado</option>
                @endif
                @foreach ($personal as $emple)
                    @if ($emple->EmpleadoActivo == 'Activo')
                        <option value="{{$emple->id}}">{{$emple->NombresDelEmpleado}} {{$emple->ApellidosDelEmpleado}}</option>
                    @endif
                @endforeach
             </select>   
        </div>
       
        <div class="form-group">
            <label for="nombre"> Nombre </label>
            <input type="text" class="form-control" name="nombre" id="nombre" pattern="[a-zA-ZñÑáéíóú ]+" title="No ingrese números ni signos" placeholder="Nombre del gasto" 
            maxlength="40" value="{{old('nombre', $gasto->nombre)}}" required>
        </div>
    
        <div class="form-group">
            <label for="descripcion"> Descripción </label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción del gasto" class="form-control"  maxlength="200"
            required cols="30" rows="6">{{old('descripcion', $gasto->descripcion)}}</textarea>
        </div>
    
        <div class="form-group">
            <label for="tipo"> Tipo </label>
            <select name="tipo" id="tipo" required class="form-control">
                @if (old('tipo', $gasto->tipo))
                <option style="display: none" value="{{old('tipo', $gasto->tipo)}}">{{old('tipo', $gasto->tipo)}}</option>
                @else
                <option style="display: none" value="">Seleccione el tipo de gasto</option>
                @endif
                <option value="Variable">Variable</option>
                <option value="Fijo">Fijo</option>
            </select>
        </div>

        <?php
        $fecha_actual = date('d-m-Y');
        ?>
        <div class="form-group">
            <label for="fecha"> Fecha </label>
            <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Fecha del gasto" 
             value="{{old('fecha', $gasto->fecha)}}" required min="<?php echo date('Y-m-d', strtotime($fecha_actual . '- 2 month')); ?>"
             max="<?php echo date('Y-m-d', strtotime($fecha_actual)); ?>">
        </div>

    
        <div class="form-group">
            <label for="total"> Total </label>
            <input type="number" class="form-control" name="total" id="total" placeholder="Total del gasto" 
             value="{{old('total', $gasto->total)}}" required step="any" min="1" max="50000">
        </div>


       
        <br>
        <input type="submit" class="btn btn-primary" value="Actualizar" >
        <a class="btn btn-danger" href="{{route('gasto.edit', ['id' => $gasto->id])}}">Restaurar</a>
        <a class="btn btn-info" href="{{route('gasto.index')}}">Cerrar</a>

    </form>
@endsection
@push('alertas')
    <script>
        function confirmar() {
           var formul = document.getElementById("form_editar");


            Swal.fire({
                title: '¿Está seguro que desea actualizar los datos del gasto?',
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
        $(document).ready(function() {
        new TomSelect(".select222", {
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            }
        });
        });
    </script>
@endpush