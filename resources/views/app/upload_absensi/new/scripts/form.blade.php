<script>
$(document).ready(function() {

    const form = document.getElementById('newUploadAbsensiForm')
    const newUploadAbsensiForm = $('#newUploadAbsensiForm').formValidation({
        fields: {
            month: {
                validators: {
                    notEmpty: {
                        message: 'Bulan Harus diisi'
                    }
                }
            },
            year: {
                validators: {
                    notEmpty: {
                        message: 'Tahun Harus diisi'
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
        newUploadAbsensiForm.validate().then(function(status) {
            if (status === 'Valid') {
                const month_id = $('select[name="month"]')
                const year = $('input[name="year"]')

                axios.post('/upload_absensi', {
                    month: month_id.val(),
                    year: year.val()
                }).then((response) => {
                    const { data } = response.data
                    if (!isRecreate) {
                        window.location = urlNext +'/edit/'+ data.id
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
