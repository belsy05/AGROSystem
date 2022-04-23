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
                            <option value="{{ $c->id }}">{{ $c->NombresDelCliente }} {{ $c->ApellidosDelCliente }}
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
                    <input style="width: 100%" readonly type="email" name="Subtotal"
                        class="form-control {{ $errors->has('Subtotal') ? 'is-invalid' : '' }}"
                        value="{{ $total_precio }}" id="Subtotal" required title="Subtotal de la Venta">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Total Impuesto</label>
                    <input style="width: 100%" readonly type="email" name="TotalImpuesto"
                        class="form-control {{ $errors->has('TotalImpuesto') ? 'is-invalid' : '' }}"
                        value="{{ round($total_impuesto, 2) }}" id="TotalImpuesto" required
                        title="Total del impuesto">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label style="width: 100%" for="">Total Venta</label>
                    <input style="width: 100%" readonly type="email" name="TotalVenta"
                        class="form-control {{ $errors->has('TotalVenta') ? 'is-invalid' : '' }}"
                        value="{{ round($total_precio + $total_impuesto, 2) }}" id="TotalVenta" required title="Total de la Venta">       
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

        <div class="row" style="width: 150%">
            <div class="col-sm-8">

                <table class="table table-bordered border-dark mt-3">
                    <thead class="table table-striped table-hover">
                        <tr class="success">
                            <th scope="col">N°</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Presentación</th>
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
                                    {{ $de->producto->NombreDelProducto }}
                                </td>
                                <td scope="col">{{ $de->presentacion->informacion }}</td>
                                <td scope="col">{{ $de->Precio_venta }}</td>
                                <td scope="col">{{ $de->Cantidad }}</td>
                                <td scope="col">{{ $de->Cantidad * $de->Precio_venta }}</td>
                                <td>
                                    <a href={{ '/detalle_venta/eliminar/' . $de->id }}
                                        class="btn btn-danger">Eliminar</a>
                                </td>
                                <td>
                                    <button onclick="editar_detalle(  {{ $de->producto->id }},
                                                                                        {{ $de->producto->categoria_id }},
                                                                                        {{ $de->IdPresentacion }},
                                                                                       '{{ $de->Cantidad }}',
                                                                                       '{{ $de->Precio_venta }}',
                                                                                       {{ $de->id }})"
                                        data-toggle="modal" data-target="#editar_detalle" type="button"
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
        <a class="btn btn-danger" href="#" onclick="limpiarVenta()">Limpiar</a>
        <a class="btn btn-info" href="{{ route('ventas.index') }}">Cerrar</a>

        {{--  --}}

    </form>

    {{-- /////////////////////////////////////////////////////////////////////////////////////////////// --}}
    <div class="modal fade" id="rango_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{route('rango.crear')}}" method="POST">
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
                                    <input style="width: 100%" type="text" name="Inicio"
                                        class="form-control" placeholder="Número de factura sin guiones" pattern="[0-9]{16}" required
                                        value="{{ old('Inicio') }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Fin del rango</label>
                                    <input style="width: 100%" type="text" name="Fin"
                                        class="form-control" placeholder="Número de factura sin guiones" pattern="[0-9]{16}" required
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


    
