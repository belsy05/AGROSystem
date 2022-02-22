@push('alertas')

<script>
    function confirmar(id) {
       var formul = document.getElementById("form_editarC");


        Swal.fire({
            title: '¿Está seguro que desea actualizar los datos del cargo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar'
        }).then((result)=>{
            if (result.isConfirmed) {
                formul.submit();
            }

        })

        event.preventDefault()


    }
</script>
@endpush