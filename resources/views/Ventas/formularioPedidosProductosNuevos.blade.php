@extends('Plantillas.plantilla')
@section('titulo', 'Formulario De Pedidos de Clientes')
@section('contenido')

    <h1> Registro de pedidos de productos sin existencia </h1>
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



    <form id="form_guardarP" name="form_guardarP" method="POST" action="{{ route('pedidosClienteP.guardar') }}"
        onsubmit="confirmar()">
        @csrf


        <div class="row" style="width: 87%">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="ClienteP"> Cliente </label>
                    <select name="ClienteP" id="ClienteP" class="select222" data-live-search="true" required
                        style="width: 100%">
                        <option style="display: none;" value="">Seleccione un cliente</option>
                        @foreach ($cliente as $c)
                            <option value="{{ $c->id }}" @if (old('ClienteP') == $c->id) @selected(true) @endif >
                                {{ $c->IdentidadDelCliente }}-{{ $c->NombresDelCliente }}
                                {{ $c->ApellidosDelCliente }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <input type="text" name="TotalCantidad" id="TotalCantidad" value="{{$total_cantidad }}" hidden>
            <div class="col-sm-6">
                <div class="form-group">
                    <label style="width: 100%" for="TotalAnticipo"> Total del anticipo </label>
                    <input style="width: 100%" type="number" class="form-control" name="TotalAnticipo" id="TotalAnticipo"
                        required maxlength="10" value="{{ old('TotalAnticipo') }}" min="0" max="9999"
                        title="Ingrese el total del anticipo en números, sin decimales." pattern="[0-9]+">
                </div>
            </div>

        </div>
        <div class="row" style="width: 87%">
            <div class="col-sm-6">
                <div class="form-group">
                    <label style="width: 100%" for="FechaPedidoClienteP"> Fecha del pedido </label>
                    <input style="width: 100%" readonly type="date" class="form-control" name="FechaPedidoClienteP"
                        id="FechaPedidoClienteP" required maxlength="40" value="{{ now()->format('Y-m-d') }}">
                </div>
            </div>

        </div>

        <div class="row" style="width: 100%">
            <div class="col-sm-12">
                <button data-toggle="modal" data-target="#agreagar_detalleP" type="button" class="btn btn-success">Agregar
                    detalles</button>
                <a class="btn btn-success float-" href="{{ route('cliente.crear4') }}"> Ir a clientes </a>

            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
            </div>


        </div>

        <br>

        <div class="row" style="width: 150%">
            <div class="col-sm-8">

                <table class="table table-bordered border-dark mt-3">
                    <thead class="table table-striped table-hover">
                        <tr class="success">
                            <th scope="col">N°</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Presentación</th>
                            <th scope="col">Cantidad</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($detalles as $i => $de)
                            <tr class="active">
                                <th scope="row">{{ $i + 1 }}</th>
                                <td scope="col">
                                    {{ $de->Producto }}
                                </td>
                                <td scope="col">{{ $de->Presentacion }}</td>
                                <td scope="col">{{ $de->Cantidad }}</td>
                                <td>
                                    <a href={{ '/detalle_pedidosProductoNuevoCliente/eliminar/' . $de->id }}
                                        class="btn btn-danger">Eliminar</a>
                                </td>
                                <td>
                                    <button onclick="editar_detalleP(  '{{ $de->Producto }}',
                                                                                        '{{ $de->Presentacion }}',
                                                                                        '{{ $de->Cantidad }}',
                                                                                        {{ $de->id }})"
                                        data-toggle="modal" data-target="#editar_detalleP" type="button"
                                        class="btn btn-success">Editar</button>
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
        <a class="btn btn-danger" href="#" onclick="limpiarpedidoP()">Limpiar</a>
        <a class="btn btn-info" href="{{ route('pedidosClienteP.index') }}">Cerrar</a>

        {{--  --}}

    </form>


    {{-- /////////////////////////////////////////////////////////////////////////////////////////////// --}}

    {{-- Modal de agregar detalle --}}
    <div class="modal fade" id="agreagar_detalleP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('detalle_pedidosClienteP.crear') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Producto</label>
                                    <input type="text" class="form-control" name="NombreDelProducto"
                                        id="NombreDelProducto" required placeholder="Nombre del producto" maxlength="40"
                                        value="{{ old('NombreDelProducto') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Presentación</label>
                                    <input type='text' class='form-control' name='presentacion' id='presentacion'
                                        placeholder='Presentación' value="{{ old('presentacion') }}" maxlength='30'
                                        required>

                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Cantidad</label>
                                    <input style="width: 100%" type="number" name="Cantidad"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}" 
                                        value="{{ old('Cantidad') }}" id="Cantidad" placeholder="0" min="1" max="9999"
                                        title="Ingrese cantidad de la compra en números." maxlength="4" pattern="[0-9]+" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Agregar al pedido</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal de editar los detalles --}}
    <div class="modal fade" id="editar_detalleP" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('detalle_pedidoP.editar') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar detalles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Producto</label>
                                    <input type="text" class="form-control" name="NombreDelProducto"
                                        id="e_NombreDelProducto" required placeholder="Nombre del producto" maxlength="40"
                                        value="{{ old('NombreDelProducto') }}">
                                </div>
                                <input type="text" name="IdDetalle" id="e_IdDetalle" hidden>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Presentación</label>
                                    <input type='text' class='form-control' name='presentacion' id='e_presentacion'
                                        placeholder='Presentacion' value="{{ old('presentacion[]') }}" maxlength='30'
                                        required>

                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label style="width: 100%" for="">Cantidad</label>
                                    <input style="width: 100%" type="text" name="Cantidad"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}"
                                        value="{{ old('Cantidad', 0) }}" id="e_Cantidad" required
                                        title="Ingrese cantidad de la compra en números." maxlength="4" pattern="[0-9]+">
                                </div>
                            </div>
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
            $(document).ready(function() {
               

                new TomSelect(".select222", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });

            function editar_detalleP(Producto, Presentacion, Cantidad, id) {
                $('#e_NombreDelProducto').val(Producto);
                $('#e_presentacion').val(Presentacion);
                $('#e_Cantidad').val(Cantidad);
                $('#e_IdDetalle').val(id);

            }

            function confirmar() {
                var formul = document.getElementById("form_guardarP");


                Swal.fire({
                    title: '¿Está seguro que desea guardar los datos de este nuevo pedido?',
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

            function limpiarpedidoP() {
                Swal.fire({
                    title: '¿Está seguro que desea limpiar los datos del pedido?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancelar',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '/pedidosProductoNuevoCliente/limpiar';
                    }

                })

            }
        </script>
    @endpush

@endsection
