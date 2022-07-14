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
    <h2>Reporte De Gastos</h2>
    <br>
    @if ($tipo != 0)
        <h4>Tipo de gasto: {{$tipo}}</h4>
    @endif 
    @if ($empleado != 0)
        <h4>Empleado: {{$n_e}}</h4>
    @endif
    @if ($fechadesde != 0 && $fechahasta != 0)
        <h5>Desde {{ $fechadesde }} hasta {{ $fechahasta }} </h5>
    @else
    @if ($fechadesde != 0)
        <h5>Desde {{ $fechadesde }}</h5>
    @endif
    @if ($fechahasta != 0)
        <h5>hasta {{ $fechahasta }} </h5>
    @endif
    @endif
    
    @php
        $total = 0;
    @endphp

    <table class="table table-bordered border-dark">
        <thead class="table-dark">
            <tr class="success">
                <th scope="col">Empleado responsable</th>
                <th scope="col">Nombre del gasto</th>
                <th scope="col">Tipo</th>
                <th scope="col">Fecha</th>
                <th scope="col">Total</th>
                
            </tr>
        </thead>
        <tbody>
        @forelse ($gastos as $gast)
            <tr class="active">
                <td scope="row">{{ $gast->person->NombresDelEmpleado}} {{$gast->person->ApellidosDelEmpleado}} </td>
                <td scope="col">{{ $gast->nombre }}</td>
                <td scope="col">{{ $gast->tipo }}</td>
                <td scope="col">{{ $gast->fecha }}</td>
                <td scope="col">{{ $gast->total }}</td>

                @php
                $total = $total + $gast->total;
                @endphp
            </tr>
            @empty
                <tr>
                    <td colspan="4"> No hay más gastos </td>
                </tr>
        @endforelse

        </tbody>
        <tfoot>
            <th scope='col' colspan='4'>Total reporte</th>
            <th scope='col'>{{ $total }}</th>
        </tfoot>
    </table>

</body>
</html>
