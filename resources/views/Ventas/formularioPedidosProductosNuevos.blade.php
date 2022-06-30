

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
                                    <input style="width: 100%" type="number" name="Cantidad"
                                        class="form-control {{ $errors->has('Cantidad') ? 'is-invalid' : '' }}"
                                        value="{{ old('Cantidad') }}" id="e_Cantidad" required placeholder="0" min="1" max="9999"
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
