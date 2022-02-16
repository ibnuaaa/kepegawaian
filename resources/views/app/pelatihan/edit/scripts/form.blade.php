<script>
$(document).ready(function() {

    $('body #myDatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

    const form = document.getElementById('editPelatihanForm')
    const editPelatihanForm = $('#editPelatihanForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The pelatihanname is required'
            //         }
            //     }
            // }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton()
        }
    }).data('formValidation')

    $('#saveAction').click(function() {
        editPelatihanForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const description = $('textarea[name="description"]')
                const tanggal_mulai_pendaftaran = $('input[name="tanggal_mulai_pendaftaran"]')
                const tanggal_selesai_pendaftaran = $('input[name="tanggal_selesai_pendaftaran"]')
                const tanggal_mulai_pelatihan = $('input[name="tanggal_mulai_pelatihan"]')
                const tanggal_selesai_pelatihan = $('input[name="tanggal_selesai_pelatihan"]')

                const data = {
                    name: name.val(),
                    description: description.val(),
                    tanggal_mulai_pendaftaran: tanggal_mulai_pendaftaran.val(),
                    tanggal_selesai_pendaftaran: tanggal_selesai_pendaftaran.val(),
                    tanggal_mulai_pelatihan: tanggal_mulai_pelatihan.val(),
                    tanggal_selesai_pelatihan: tanggal_selesai_pelatihan.val()
                }

                axios.put('/pelatihan/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/pelatihan') }}';
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})


$('#deleteOpenModal').click(function() {
    const modalElem = $('#modalDelete')
    $('#modalDelete').modal('show')
})
$('#deleteAction').click(function() {
    axios.delete('/pelatihan/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/pelatihan')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
