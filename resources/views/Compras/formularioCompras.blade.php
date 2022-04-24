@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Compras')
@section('contenido')

    <h1> Registro de Compra </h1>
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

    <form id="form_guardar" name="form_guardar" method="POST" action="{{ route('compras.guardar') }}"
        onsubmit="confirmar()">
        @csrf
        <div class="form-group">
            <label for="NumFactura"> Número de Factura </label>
            <input type="text" style="width: 50%" class="form-control" name="NumFactura" id="NumFactura"
                placeholder="Número de factura sin guiones" pattern="[0-9]{16}" required value="{{ old('NumFactura') }}">
        </div>

        <div class="row" style="width: 79%">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="Proveedor"> Proveedor </label>
            <select name="Proveedor" id="Proveedor" class="form-control" required style="width: 100%">
                <option style="display: none;" value="">Seleccione un proveedor</option>
                @foreach ($proveedor as $p)
                    <option value="{{ $p->id }}">{{ $p->EmpresaProveedora }}</option>
                @endforeach
            </select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="FechaCompra"> Fecha de la compra </label>
                    <input style="width: 100%" type="date" class="form-control" name="FechaCompra" id="FechaCompra"
                        required maxlength="40">
                </div>
            </div>
            
        </div>

        <div class="row" style="width: 53%">
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Subtotal</label>
                    <input style="width: 100%" readonly type="email" name="TotalCompra"
                        class="form-control {{ $errors->has('TotalCompra') ? 'is-invalid' : '' }}"
                        value="{{ $total_precio }}" id="TotalCompra" required title="Subtotal">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Impuesto</label>
                    <input style="width: 100%" readonly type="email" name="TotalImpuesto"
                        class="form-control {{ $errors->has('TotalImpuesto') ? 'is-invalid' : '' }}"
                        value="{{ round($total_impuesto, 2) }}" id="TotalImpuesto" required title="Total del impuesto" >
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Total Compra</label>
                    <input style="width: 100%" readonly type="email" name="TotalCompraT"
                        class="form-control {{ $errors->has('TotalCompraT') ? 'is-invalid' : '' }}"
                        value="{{ round($total_precio + $total_impuesto, 2) }}" id="TotalCompraT" required title="Total de la Compra">       
                </div>
            </div>
        </div>

        <div class="row" style="width: 85%">
            <div class="col-sm-4">
                <button data-toggle="modal" data-target="#agreagar_detalle" type="button" class="btn btn-success">Agregar
                    Detalles</button>
                <a class="btn btn-success float-" href="{{ route('proveedor.crear2') }}"> Ir a Proveedores </a>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
            </div>
        </div>
        <br>

        <div class="row" style="width: 87%">
            <div class="col-sm-16">

                <table class="table table-bordered border-dark mt-3">
                    <thead class="table table-striped table-hover">
                        <tr class="success">
                            <th scope="col">N°</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Presentación</th>
                            <th scope="col">Precio de compra</th>
                            <th scope="col">Precio de venta</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col">Total Producto</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detalles as $i => $de)
                            <tr class="active">
                                <th scope="row">{{ $i + 1 }}</th>
                                <td scope="col">
                                    {{ $de->producto->NombreDelProducto . ', ' . $de->producto->DescripciónDelProducto }}
                                </td>
                                <td scope="col">{{ $de->presentacion->informacion }}</td>                                
                                <td scope="col">{{ $de->Precio_compra }}</td>
                                <td scope="col">{{ $de->Precio_venta }}</td>
                                <td scope="col">{{ $de->Cantidad }}</td>
                                <td scope="col">{{ $de->Cantidad * $de->Precio_compra }}</td>
                                <td>
                                    <a href={{ '/detalle_compra/eliminar/' . $de->id }}
                                        class="btn btn-danger">Eliminar</a>
                                </td>
                                <td>
                                    <button onclick="editar_detalle(  {{ $de->producto->id }},
                                                                {{ $de->producto->categoria_id }},
                                                                {{ $de->IdPresentacion }},
                                                                '{{ $de->fecha_vencimiento }}',
                                                               '{{ $de->fecha_elaboración }}',
                                                               '{{ $de->Cantidad }}',
                                                               '{{ $de->Precio_venta }}',
                                                               '{{ $de->Precio_compra }}',
                                                               {{ $de->id }})" data-toggle="modal"
                                        data-target="#editar_detalle" type="button" class="btn btn-success">Editar</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"> No hay detalles agregados </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>
        </div>


        <br>
        <input type="submit" class="btn btn-primary" value="Guardar">
        <a class="btn btn-danger" href="#" onclick="limpiarCompra()">Limpiar</a>
        <a class="btn btn-info" href="{{ route('compras.index') }}">Cerrar</a>

        {{--  --}}

    </form>

    {{-- Modal de agregar detalle --}}
    <div class="modal fade" id="agreagar_detalle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('detalle_compra.crear') }}" method="POST">
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
                                        class="form-control">
                                        <option style="display: none" value="">Seleccione una presentación</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de compra</label>
                                    <input style="width: 100%" type="text" name="Precio_compra"
                                        class="form-control {{ $errors->has('Precio_compra') ? 'is-invalid' : '' }}"
                                        value="{{ old('Precio_compra', 0) }}" id="Precio_compra" required
                                        title="Ingrese el Precio de Compra">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de venta</label>
                                    <input style="width: 100%" type="text" name="Precio_venta"
                                        class="form-control {{ $errors->has('Precio_venta') ? 'is-invalid' : '' }}"
                                        value="{{ old('Precio_venta', 0) }}" id="Precio_venta" required
                                        title="Ingrese el Precio de venta">
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

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Fecha de elaboración</label>
                                    <input style="width: 100%" type="date" name="fecha_elaboración"
                                        class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                        id="fecha_elaboración" title="Ingrese la fecha de elaboración">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Fecha de vencimiento</label>
                                    <input style="width: 100%" type="date" name="fecha"
                                        class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                        value="{{ old('fecha', 0) }}" id="fecha" title="Ingrese la fecha de vencimiento">
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
                        <a class="btn btn-info" href="{{ route('categoria.crear2') }}">Ir a categorías</a>
                        <a class="btn btn-info" href="{{ route('producto.crear2') }}">Ir a productos </a>
                        <button type="submit" class="btn btn-primary">Agregar a la Compra</button>
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
                <form action="{{ route('detalle_compra.editar') }}" method="POST">
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
                                        class="form-control">
                                        <option style="display: none" value="">Seleccione una presentación</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de compra</label>
                                    <input style="width: 100%" type="number" name="Precio_compra"
                                        class="form-control {{ $errors->has('Precio_compra') ? 'is-invalid' : '' }}"
                                        value="{{ old('Precio_compra', 0) }}" id="e_Precio_compra" required
                                        title="Ingrese el Precio de Compra">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Precio de venta</label>
                                    <input style="width: 100%" type="number" name="Precio_venta"
                                        class="form-control {{ $errors->has('Precio_venta') ? 'is-invalid' : '' }}"
                                        value="{{ old('Precio_venta', 0) }}" id="e_Precio_venta" required
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

                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Fecha de elaboración</label>
                                    <input style="width: 100%" type="date" name="fecha_elaboración"
                                        class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                        id="e_fecha_elaboración" title="Ingrese la fecha de elaboración">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Fecha de vencimiento</label>
                                    <input style="width: 100%" type="date" name="fecha"
                                        class="form-control {{ $errors->has('fecha') ? 'is-invalid' : '' }}"
                                        value="{{ old('fecha', 0) }}" id="e_fecha"
                                        title="Ingrese la fecha de vencimiento">
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
                        <a class="btn btn-info" href="{{ route('categoria.crear2') }}">Ir a categorías</a>
                        <a class="btn btn-info" href="{{ route('producto.crear2') }}">Ir a productos </a>
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
            function editar_detalle(IdProducto, categoria_id, IdPresentacion, fecha, fecha_elaboración, Cantidad, Precio_venta,
                Precio_compra, id) {
                $('#e_IdCategoria').val(categoria_id);
                e_cambio();
                $('#e_IdProducto').val(IdProducto);
                $('#e_IdPresentacion').val(IdPresentacion);
                e_impuesto();
                $('#e_fecha').val(fecha);
                $('#e_fecha_elaboración').val(fecha_elaboración);
                $('#e_Cantidad').val(Cantidad);
                $('#e_Precio_venta').val(Precio_venta);
                $('#e_Precio_compra').val(Precio_compra);
                $('#e_IdDetalle').val(id);

            }

            function confirmar() {
                var formul = document.getElementById("form_guardar");


                Swal.fire({
                    title: '¿Está seguro que desea guardar los datos de esta nueva compra?',
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

            function limpiarCompra() {
                Swal.fire({
                    title: '¿Está seguro que desea limpiar los datos de la compra?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/compras/limpiar';
                    }

                })

            }
        </script>
    @endpush
@endsection
