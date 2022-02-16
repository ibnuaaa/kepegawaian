<script>
$(document).ready(function() {

    $('body #myDatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

    const form = document.getElementById('newPelatihanForm')
    const newPelatihanForm = $('#newPelatihanForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Nama Pelatihan Harus diisi'
            //         }
            //     }
            // },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton()
        }
    }).data('formValidation')


    $('.saveAction').click(function() {
        const { urlNext, isRecreate } = $(this).data()
        newPelatihanForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const description = $('textarea[name="description"]')
                const tanggal_mulai_pendaftaran = $('input[name="tanggal_mulai_pendaftaran"]')
                const tanggal_selesai_pendaftaran = $('input[name="tanggal_selesai_pendaftaran"]')
                const tanggal_mulai_pelatihan = $('input[name="tanggal_mulai_pelatihan"]')
                const tanggal_selesai_pelatihan = $('input[name="tanggal_selesai_pelatihan"]')

                axios.post('/pelatihan', {
                    name: name.val(),
                    description: description.val(),
                    tanggal_mulai_pendaftaran: tanggal_mulai_pendaftaran.val(),
                    tanggal_selesai_pendaftaran: tanggal_selesai_pendaftaran.val(),
                    tanggal_mulai_pelatihan: tanggal_mulai_pelatihan.val(),
                    tanggal_selesai_pelatihan: tanggal_selesai_pelatihan.val()
                }).then((response) => {
                    const { data } = response.data
                    if (!isRecreate) {
                        window.location = urlNext
                    } else {
                        window.location.reload()
                    }
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})
</script>
