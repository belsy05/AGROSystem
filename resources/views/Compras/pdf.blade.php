<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    
</head>

<body>
    <h2>Reporte De Compras</h2>
    <h5>Proveedor: {{$provee}}</h5>

    <table class='table table-bordered border-dark mt-3'>
        <thead class='table table-striped table-hover'>
            <tr class='success'>
                <th scope='col'>Número de Factura</th>
                <th scope='col'>Proveedor</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Total Compra (Lps.)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total = 0;
            @endphp
            @forelse ($compras as $compra)
                <tr class='active'>
                    <td scope='col'>{{ $compra->NumFactura }}</td>
                    <td scope="col">{{ $compra->proveedors->EmpresaProveedora }}</td>
                    <td scope='col'>{{ $compra->FechaCompra }}</td>
                    <td scope='col'>{{ $compra->TotalCompra }}</td>
                    @php
                        $total = $total + $compra->TotalCompra;
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
        </tfoot>
    </table>
</body>

</html>