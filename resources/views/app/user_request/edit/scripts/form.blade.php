<script>
$(document).ready(function() {

    const form = document.getElementById('editUserRequestForm')
    const editUserRequestForm = $('#editUserRequestForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The user_requestname is required'
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
        editUserRequestForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')

                const data = {
                    name: name.val(),
                }

                axios.put('/user_request/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/user_request') }}';
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
    axios.delete('/user_request/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/user_request')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
