<script>
    $('#departamento').on('change', function () {
        let dep_id = $(this).val();

        $.get('/provincias/' + dep_id, function (data) {
            $('#provincia').empty().append('<option value="">Seleccione</option>');
            $('#distrito').empty().append('<option value="">Seleccione</option>');

            data.forEach(item => {
                $('#provincia').append(
                    `<option value="${item.id}">${item.nombre}</option>`
                );
            });
        });
    });

    $('#provincia').on('change', function () {
        let prov_id = $(this).val();

        $.get('/distritos/' + prov_id, function (data) {
            $('#distrito').empty().append('<option value="">Seleccione</option>');

            data.forEach(item => {
                $('#distrito').append(
                    `<option value="${item.id}">${item.nombre}</option>`
                );
            });
        });
    });
</script>