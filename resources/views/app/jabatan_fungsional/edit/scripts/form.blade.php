<script>
$(document).ready(function() {

    const form = document.getElementById('editJabatanFungsionalForm')
    const editJabatanFungsionalForm = $('#editJabatanFungsionalForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The jabatan_fungsionalname is required'
                    }
                }
            }
        },
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton()
        }
    }).data('formValidation')

    $('#saveAction').click(function() {
        editJabatanFungsionalForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')

                const data = {
                    name: name.val(),
                }

                axios.put('/jabatan_fungsional/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/jabatan_fungsional') }}';
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
    axios.delete('/jabatan_fungsional/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/jabatan_fungsional')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
