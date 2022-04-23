@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Ventas')
@section('contenido')

    <h1> Registro de Venta </h1>
    <br>

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

    {{-- /////////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

    <form id="form_guardar" name="form_guardar" method="POST" action="{{ route('ventas.guardar') }}"
        onsubmit="confirmar()">
        @csrf
        <div class="row" style="width: 80%">
            <div class="col-sm-6" >
                <div class="form-group">
                    <label for="NumFactura"> Número de Factura </label>
                    <input type="text" readonly style="width: 100%" name="NumFactura"
                        class="form-control {{ $errors->has('NumFactura') ? 'is-invalid' : '' }}"  id="NumFactura"
                        placeholder="Número de factura sin guiones" required
                        value="{{ $numfactura}}">  
                     
                </div>
                
            </div>
            
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="Empleado"> Empleado </label>
                    <select name="Empleado" id="Empleado" class="form-control" required style="width: 100%">
                        <option style="display: none;" value="">Seleccione un empleado</option>
                        @foreach ($empleado as $e)
                            <option value="{{ $e->id }}">{{ $e->NombresDelEmpleado }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
        </div>

        <div class="row" style="width: 80%">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="Cliente"> Cliente </label>
                    <select name="Cliente" id="Cliente" class="form-control" required style="width: 100%">
                        <option style="display: none;" value="">Seleccione un cliente</option>
                        <option value="">Consumidor Final</option>
                        @foreach ($cliente as $c)
                            <option value="{{ $c->id }}">{{$c->IdentidadDelCliente}}-{{ $c->NombresDelCliente }} {{ $c->ApellidosDelCliente }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label style="width: 100%" for="FechaVenta"> Fecha de la Venta </label>
                    <input style="width: 100%" readonly type="date" class="form-control" name="FechaVenta" id="FechaVenta" required
                                maxlength="40" value="{{now()->format('Y-m-d')}}">     
                </div>
            </div>
            
        </div>


        <div class="row" style="width: 80%">
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Subtotal</label>
                    <input style="width: 100%" readonly type="email" name="TotalVenta"
                        class="form-control {{ $errors->has('TotalVenta') ? 'is-invalid' : '' }}"
                        value="{{ $total_precio }}" id="TotalVenta" required title="Subtotal de la Venta">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Impuesto</label>
                    <input style="width: 100%" readonly type="email" name="TotalImpuesto"
                        class="form-control {{ $errors->has('TotalImpuesto') ? 'is-invalid' : '' }}"
                        value="{{ round($total_impuesto, 2) }}" id="TotalImpuesto" required
                        title="Total del impuesto">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Total Venta</label>
                    <input style="width: 100%" readonly type="email" name="TotalVentaT"
                        class="form-control {{ $errors->has('TotalVentaT') ? 'is-invalid' : '' }}"
                        value="{{ round($total_precio + $total_impuesto, 2) }}" id="TotalVentaT" required title="Total de la Venta">       
                </div>
            </div>
        </div>
        
        <div class="row" style="width: 100%">
            <div class="col-sm-12">
                <button data-toggle="modal" data-target="#agreagar_detalle" type="button" class="btn btn-success">Agregar
                    Detalles</button>
                <a class="btn btn-success float-" href="{{ route('cliente.crear2') }}"> Ir a Clientes </a>
                <button data-toggle="modal" data-target="#rango_factura" type="button" class="btn btn-success">Agregar
                    nuevo rango</button>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
            </div>

        </div>

        <br>

        

        <br>
        <input type="submit" class="btn btn-primary" value="Guardar">
        <a class="btn btn-danger" href="#" onclick="limpiarVenta()">Limpiar</a>
        <a class="btn btn-info" href="{{ route('ventas.index') }}">Cerrar</a>

        {{--  --}}

    </form>

    {{-- /////////////////////////////////////////////////////////////////////////////////////////////// --}}
    <div class="modal fade" id="rango_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('rango.crear') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Rango De Facturas</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Inicio del rango</label>
                                    <input style="width: 100%" type="text" name="Inicio" class="form-control"
                                        placeholder="Número de factura sin guiones" pattern="[0-9]{16}" required
                                        value="{{ old('Inicio') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fin del rango</label>
                                    <input style="width: 100%" type="text" name="Fin" class="form-control"
                                        placeholder="Número de factura sin guiones" pattern="[0-9]{16}" required
                                        value="{{ old('Fin') }}">
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Fecha limite de emisión</label>
                                    <input style="width: 100%" type="date" name="fecha_limite"
                                        class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                        id="fecha_limite" title="Ingrese la fecha de limite de emisión">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{-- Modal de agregar detalle --}}
    <div class="modal fade" id="agreagar_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('detalle_venta.crear') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Categoría</label>
                                    <select name="IdCategoria" id="IdCategoria" style="width: 95%" class="form-control"
                                        onchange="cambio()">
                                        <option style="display: none" value="">Seleccione una categoría</option>
                                        @foreach ($categoria as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->NombreDeLaCategoría }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Producto</label>
                                    <select name="IdProducto" id="IdProducto" style="width: 100%" class="form-control"
                                        onchange="impuesto()">
                                        <option style="display: none" value="">Seleccione un producto</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>
                            function cambio() {
                                $("#IdProducto").find('option').not(':first').remove();
                                $("#IdPresentacion").find('option').not(':first').remove();
                                var select = document.getElementById("IdCategoria");
                                var valor = select.value;
                                var selectnw = document.getElementById("IdProducto");
                                var selectpw = document.getElementById("IdPresentacion");

                                @foreach ($productos as $p)
                                    if({{ $p->categoria_id }} == valor){
                                
                                    // creando la nueva option
                                    var opt = document.createElement('option');
                                
                                    // Añadiendo texto al elemento (opt)
                                    opt.innerHTML = "{{ $p->NombreDelProducto }}";
                                
                                    //Añadiendo un valor al elemento (opt)
                                    opt.value = "{{ $p->id }}";
                                
                                    // Añadiendo opt al final del selector (sel)
                                    selectnw.appendChild(opt);
                                
                                    }
                                @endforeach

                                @foreach ($presentacion as $p)
                                    if({{ $p->categoria_id }} == valor){
                                
                                    // creando la nueva option
                                    var opt = document.createElement('option');
                                
                                    // Añadiendo texto al elemento (opt)
                                    opt.innerHTML = "{{ $p->informacion }}";
                                
                                    //Añadiendo un valor al elemento (opt)
                                    opt.value = "{{ $p->id }}";
                                
                                    // Añadiendo opt al final del selector (sel)
                                    selectpw.appendChild(opt);
                                
                                    }
                                @endforeach

                            }

                            function impuesto() {
                                var select = document.getElementById("IdProducto");
                                var valor = select.value;

                                @foreach ($productos as $p)
                                    if({{ $p->id }} == valor){
                                    document.getElementById("calimp").value= 'El producto tiene '+{{ $p->Impuesto * 100 }}+'% de impuestos.';
                                    }
                                @endforeach
                            }
                        </script>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Presentación</label>
                                    <select name="IdPresentacion" id="IdPresentacion" style="width: 100%"
                                        class="form-control" onchange="precio()">
                                        <option style="display: none" value="">Seleccione una presentación</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Existencia</label>
                                    <input style="width: 100%" type="text" name="Existencia" class="form-control"
                                        value="0" id="Existencia" disabled>
                                </div>
                            </div>


                        </div>

                        <script>
                            function precio() {
                                var select = document.getElementById("IdPresentacion");
                                var valor = select.value;
                                var select1 = document.getElementById("IdProducto");
                                var valor1 = select1.value;

                                @foreach ($precios as $p)
                                    if({{ $p->IdProducto }} == valor1 && {{ $p->IdPresentación }} == valor){
                                    document.getElementById("Precio_venta").value= '{{ $p->Precio }}';
                                
                                    }
                                @endforeach

                                @foreach ($inventarios as $i)
                                    if({{ $i->IdProducto }} == valor1 && {{ $i->IdPresentacion }} == valor){
                                    document.getElementById("Existencia").value= '{{ $i->Existencia }}';
                                
                                    }
                                @endforeach

                            }
                        </script>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de venta</label>
                                    <input style="width: 100%" type="text" readonly name="Precio_venta"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}" value="0"
                                        id="Precio_venta" title="Ingrese el Precio de venta">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Cantidad</label>
                                    <input style="width: 100%" type="number" name="Cantidad"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}"
                                        value="{{ old('Cantidad', 0) }}" id="Cantidad" required
                                        title="Ingrese cantidad de la compra">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="form-control" id="calimp" style="width: 95%;text-align: center;color: black"
                                type="text" value="" disabled>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar a la Venta</button>
                    </div>

                </form>
            </div>
        </div>
    </div>




    {{-- Modal de editar los detalles --}}
    <div class="modal fade" id="editar_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('detalle_venta.editar') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar Detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Categoría</label>
                                    <select name="IdCategoria" id="e_IdCategoria" style="width: 95%" class="form-control"
                                        onchange="e_cambio()">
                                        <option style="display: none" value="">Seleccione una categoría</option>
                                        @foreach ($categoria as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->NombreDeLaCategoría }}</option>
                                        @endforeach
                                    </select>

                                    <input type="text" name="IdDetalle" id="e_IdDetalle" hidden>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Producto</label>
                                    <select name="IdProducto" id="e_IdProducto" style="width: 100%" class="form-control"
                                        onchange="e_impuesto()">
                                        <option style="display: none" value="">Seleccione un producto</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <script>
                            function e_cambio() {
                                $("#e_IdProducto").find('option').not(':first').remove();
                                $("#e_IdPresentacion").find('option').not(':first').remove();
                                var select = document.getElementById("e_IdCategoria");
                                var valor = select.value;
                                var selectnw = document.getElementById("e_IdProducto");
                                var selectpw = document.getElementById("e_IdPresentacion");

                                @foreach ($productos as $p)
                                    if({{ $p->categoria_id }} == valor){
                                
                                    // creando la nueva option
                                    var opt = document.createElement('option');
                                
                                    // Añadiendo texto al elemento (opt)
                                    opt.innerHTML = "{{ $p->NombreDelProducto }}";
                                
                                    //Añadiendo un valor al elemento (opt)
                                    opt.value = "{{ $p->id }}";
                                
                                    // Añadiendo opt al final del selector (sel)
                                    selectnw.appendChild(opt);
                                
                                    }
                                @endforeach

                                @foreach ($presentacion as $p)
                                    if({{ $p->categoria_id }} == valor){
                                
                                    // creando la nueva option
                                    var opt = document.createElement('option');
                                
                                    // Añadiendo texto al elemento (opt)
                                    opt.innerHTML = "{{ $p->informacion }}";
                                
                                    //Añadiendo un valor al elemento (opt)
                                    opt.value = "{{ $p->id }}";
                                
                                    // Añadiendo opt al final del selector (sel)
                                    selectpw.appendChild(opt);
                                
                                    }
                                @endforeach

                            }

                            function e_impuesto() {
                                var select = document.getElementById("e_IdProducto");
                                var valor = select.value;

                                @foreach ($productos as $p)
                                    if({{ $p->id }} == valor){
                                    document.getElementById("e_calimp").value= 'El producto tiene '+{{ $p->Impuesto * 100 }}+'% de impuestos.';
                                    }
                                @endforeach

                            }
                        </script>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Presentación</label>
                                    <select name="IdPresentacion" id="e_IdPresentacion" style="width: 100%"
                                        class="form-control" onchange="e_precio()">
                                        <option style="display: none" value="">Seleccione una presentación</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Existencia</label>
                                    <input style="width: 100%" type="text" name="Existencia" class="form-control"
                                        value="0" id="e_Existencia" disabled>
                                </div>
                            </div>
                        </div>

                        <script>
                            function e_precio() {
                                var select = document.getElementById("e_IdPresentacion");
                                var valor = select.value;
                                var select1 = document.getElementById("e_IdProducto");
                                var valor1 = select1.value;

                                @foreach ($precios as $p)
                                    if({{ $p->IdProducto }} == valor1 && {{ $p->IdPresentación }} == valor){
                                    document.getElementById("e_Precio_venta").value= '{{ $p->Precio }}';
                                    }
                                @endforeach

                                @foreach ($inventarios as $i)
                                    if({{ $i->IdProducto }} == valor1 && {{ $i->IdPresentacion }} == valor){
                                    document.getElementById("e_Existencia").value= '{{ $i->Existencia }}';
                                
                                    }
                                @endforeach

                            }
                        </script>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de venta</label>
                                    <input style="width: 100%" type="number" readonly name="Precio_venta"
                                        class="form-control" value="0" id="e_Precio_venta"
                                        title="Ingrese el Precio de venta">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Cantidad</label>
                                    <input style="width: 100%" type="number" name="Cantidad"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}"
                                        value="{{ old('Cantidad', 0) }}" id="e_Cantidad" required
                                        title="Ingrese cantidad de la compra">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <input class="form-control" id="e_calimp" style="width: 95%;text-align: center;color: black"
                                type="text" value="" disabled>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>


@endsection

@section('js')
    @push('alertas')
        <script>
            function editar_detalle(IdProducto, categoria_id, IdPresentacion, Cantidad, Precio_venta, id) {
                $('#e_IdCategoria').val(categoria_id);
                e_cambio();
                $('#e_IdProducto').val(IdProducto);
                $('#e_IdPresentacion').val(IdPresentacion);
                e_impuesto();
                e_precio();
                // $('#e_Precio_venta').val(Precio_venta);
                $('#e_Cantidad').val(Cantidad);
                $('#e_IdDetalle').val(id);

            }
            
             function confirmar() {
                var formul = document.getElementById("form_guardar");


                Swal.fire({
                    title: '¿Está seguro que desea guardar los datos de esta nueva venta?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formul.submit();
                    }

                })

                event.preventDefault()


            }

            function limpiarVenta() {
                Swal.fire({
                    title: '¿Está seguro que desea limpiar los datos de la venta?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/ventas/limpiar';
                    }

                })

            }
        </script>
    @endpush
@endsection
