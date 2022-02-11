<script>
$(document).ready(function() {

    const form = document.getElementById('newConfigForm')
    const newConfigForm = $('#newConfigForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Nama Config Harus diisi'
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
        newConfigForm.validate().then(function(status) {
            if (status === 'Valid') {
              const key = $('input[name="key"]')
              const value = $('input[name="value"]')

                axios.post('/config', {
                  key: key.val(),
                  value: value.val(),
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
