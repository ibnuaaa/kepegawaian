<script>
$(document).ready(function() {

    const form = document.getElementById('editConfigForm')
    const editConfigForm = $('#editConfigForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The configname is required'
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
        editConfigForm.validate().then(function(status) {
            if (status === 'Valid') {
                const key = $('input[name="key"]')
                const value = $('input[name="value"]')

                const data = {
                    key: key.val(),
                    value: value.val(),
                }

                axios.put('/config/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/config') }}';
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
    axios.delete('/config/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/config')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
