<script>
$(document).ready(function() {

    const form = document.getElementById('newIndikatorSkpForm')
    const newIndikatorSkpForm = $('#newIndikatorSkpForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'Nama IndikatorSkp Harus diisi'
                    }
                }
            },
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton()
        }
    }).data('formValidation')


    $('.saveAction').click(function() {
        const { urlNext, isRecreate } = $(this).data()
        newIndikatorSkpForm.validate().then(function(status) {
            if (status === 'Valid') {
              const name = $('input[name="name"]')

                axios.post('/indikator_skp', {
                    name: name.val(),
                    parent_id: '{{ $indikator_kinerja_id }}',
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
