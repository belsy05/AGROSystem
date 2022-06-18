@extends('plantillas.plantilla')
@section('titulo', 'Venta')
@section('contenido')

    <script>
        function imprimir() {
            var contenido = document.getElementById('imprimir').innerHTML;
            var contenidoOriginal = document.body.innerHTML;
            document.body.innerHTML = contenido;
            window.print();

            document.body.innerHTML = contenidoOriginal;
        }
    </script>

    
    <div id="detalles">
        <h1> Detalles de la cotización</h1>
        <br><br>
        <table class="table">
            <thead class="table-secondary">
                <tr>
                    <th scope="col">Información de la cotización</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">Fecha de cotización</th>
                    <td scope="col">{{\Carbon\Carbon::parse($venta->FechaVenta)->locale("es")->isoFormat("DD MMMM, YYYY")}} </td>
                </tr>

            </tbody>
        </table>

        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio Unitario</th>
                    <th scope="col">Total Compra</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalC = 0;
                    $totalP = 0;
                @endphp
                @forelse ($detalles as $i => $de)
                    <tr class="active">
                        <th scope="row">{{ $i + 1 }}</th>
                        <td scope="col">{{ $de->producto->NombreDelProducto}}
                        </td>
                        <td scope="col">{{ $de->Cantidad }}</td>
                        <td scope="col">{{ $de->Precio_venta }}</td>
                        <td scope="col">{{ $de->Cantidad * $de->Precio_venta }}</td>
                    </tr>
                    @php
                        $totalC += $de->Cantidad;
                        $totalP += $de->Cantidad * $de->Precio_venta;
                    @endphp
                @empty
                    <tr>
                        <td colspan="4"> No hay detalles agregados </td>
                    </tr>
                @endforelse

                <tr>
                    <th scope="row"></th>
                    <th scope="col">Subtotal</th>
                    <th scope="col">{{ $totalC }}</th>
                    <td scope="col"></td>
                    <th scope="col">{{ $totalP }}</th>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <th scope="row" >Impuesto</th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row">{{ $venta->TotalImpuesto }} </th>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <th scope="row" >Total</th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row" >{{ $venta->TotalImpuesto +  $totalP}} </th>
                </tr>
            </tbody>
        </table>

        <a class="btn btn-primary" href="{{ route('ventas.index') }}"> Regresar </a>
        <button type="button" class="btn btn-success" onclick="imprimir()">Imprimir Cotización</button>
    </div>

    <div id="imprimir" style="display: none">
        <center>
            <h1>El Arriero</h1>
            <h3><strong>Venta De Productos Agropecuarios</strong></h3>
            <p>Aldea San Diego, contiguo a Pollolandia, Jamastran</p>
            <p>Danlí, El Paraíso Tel. 9876-6516 R.T.N. 07011948001684</p>
            <i>email: nolascopereiranestor@gmail.com</i>
            <p><Strong>CAI: A32572-CF6E9B-3C4592-046888-375AAA-93</Strong></p>
        </center>
        <H2>COTIZACIÓN</H2>
        <?php
        $mes = '';
        switch (date_format($venta->created_at, 'm')) {
            case 1:
                $mes = 'enero';
                break;
            case 2:
                $mes = 'febrero';
                break;
            case 3:
                $mes = 'marzo';
                break;
            case 4:
                $mes = 'abril';
                break;
            case 5:
                $mes = 'mayo';
                break;
            case 6:
                $mes = 'junio';
                break;
            case 7:
                $mes = 'julio';
                break;
            case 8:
                $mes = 'agosto';
                break;
            case 9:
                $mes = 'septiembre';
                break;
            case 10:
                $mes = 'octubre';
                break;
            case 11:
                $mes = 'noviembre';
                break;
            case 12:
                $mes = 'diciembre';
                break;
        }
        ?>
        <p style="float: left">Fecha {{ date_format($venta->created_at, 'd') }} de {{ $mes }} del
            {{ date_format($venta->created_at, 'Y') }}</p>

        <table class="table table-bordered border-dark mt-3">
            <thead class="table table-striped table-hover">
                <tr class="success">
                    <th scope="col">N°</th>
                    <th scope="col">Producto</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Precio unitario</th>
                    <th scope="col">Total compra (Lps.)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalC = 0;
                    $totalP = 0;
                @endphp
                @forelse ($detalles as $i => $de)
                    <tr class="active">
                        <th scope="row">{{ $i + 1 }}</th>
                        <td scope="col">{{ $de->producto->NombreDelProducto}}</td>
                        <td scope="col">{{ $de->Cantidad }}</td>
                        <td scope="col">{{ $de->Precio_venta }}</td>
                        <td scope="col">{{ $de->Cantidad * $de->Precio_venta }}</td>
                    </tr>
                    @php
                        $totalC += $de->Cantidad;
                        $totalP += $de->Cantidad * $de->Precio_venta;
                    @endphp
                @empty
                    <tr>
                        <td colspan="4"> No hay detalles agregados </td>
                    </tr>
                @endforelse

                <tr>
                    <th colspan="4">Subtotal </th>
                    <th>Lps.{{$venta->TotalVenta}}</th>
                </tr>
                <tr>
                    <th colspan="4">Impuesto </th>
                    <th>Lps.{{ $venta->TotalImpuesto }}</th>
                </tr>
                <tr>
                    <th colspan="4">Total </th>
                    <th>Lps.{{ $venta->TotalVenta + $venta->TotalImpuesto}}</th>
                </tr>
            </tbody>
        </table>

    </div>
@endsection
