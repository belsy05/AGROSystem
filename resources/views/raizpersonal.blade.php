<td> <a class="btn btn-success" href="{{ route('personal.mostrar',['id' => $personal->id]) }}" > Más Detalles </a></td>
                <td> <a class="btn btn-success" href="{{ route('personal.edit',['id' => $personal->id]) }}"> Editar </a></td>
                <td>
                    @if ($personal->EmpleadoActivo == 'Activo')
                        <a class="btn btn-danger" href="#" onclick="desactivar({{ $personal->id}})">Desactivar</a>
                    @else
                        <a class="btn btn-success" href="#" onclick="activar({{ $personal->id}})">Activar</a>
                    @endif
                </td>

            </tr>
        @empty
            <tr>
                <td colspan="4"> No hay más empleados </td>
            </tr>
        @endforelse

        </tbody>
    </table>
    {{ $personals->links()}}

@endsection



@push('alertas')
<script>

function activar(id) {
        var ruta ="/estado/"+id;
        Swal.fire({
                title: '¿Esta seguro que desea activar al empleado?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar'
            }).then((result) => {

                if (result.isConfirmed) {
                    window.location = ruta;
                }


            })
    }

    function desactivar(id) {

var ruta = "/estado/"+id;
Swal.fire({
        title: '¿Está seguro que desea desactivar al empleado?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {

        if (result.isConfirmed) {
            window.location = ruta;
        }


    })
}
</script>
@endpush
