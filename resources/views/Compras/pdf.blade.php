<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
    <style>
        h2 {
            -webkit-user-select: none !important;
            -moz-user-select: none !important;
            -ms-user-select: none !important;
            user-select: none !important;
            color: rgb(00, 00, 00);
            font-family: cursive;
            text-shadow: 0px 370px 1.5px rgb(0, 0, 0);
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>

<body>
    <h2>Reporte De Compras</h2>
    @if ($provee == 0)
        <h5>Desde {{ $anio1 }} hasta {{ $anio2 }} </h5>
    @else
        @if ($anio1 == 0)
            <h5>Proveedor: {{ $provee }}</h5>
        @else
            <h5>Proveedor: {{ $provee }}</h5>
            <h5>Desde {{ $anio1 }} hasta {{ $anio2 }} </h5>
        @endif
    @endif


    <table class='table table-bordered border-dark mt-3'>
        <thead class='table table-striped table-hover'>
            <tr class='success'>
                <th scope='col'>Número de Factura</th>
                <th scope='col'>Proveedor</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Total Compra (Lps.)</th>
                <th scope='col'>Total Impuesto (Lps.)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
                $impuesto = 0;
            @endphp
            @forelse ($compras as $compra)
                <tr class='active'>
                    <td scope='col'>{{ $compra->NumFactura }}</td>
                    <td scope="col">{{ $compra->proveedors->EmpresaProveedora }}</td>
                    <td scope='col'>{{ $compra->FechaCompra }}</td>
                    <td scope='col'>{{ $compra->TotalCompra }}</td>
                    <td scope='col'>{{ $compra->TotalImpuesto }}</td>
                    @php
                        $total = $total + $compra->TotalCompra;
                        $impuesto = $impuesto + $compra->TotalImpuesto;
                    @endphp
                </tr>
            @empty
                <tr>
                    <td colspan='4'> No hay compras </td>
                </tr>
            @endforelse

        </tbody>
        <tfoot>
            <th scope='col' colspan='3'>Total Reporte</th>
            <th scope='col'>{{ $total }}</th>
            <th scope='col'>{{ $impuesto }}</th>
        </tfoot>
    </table>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>

</html>
