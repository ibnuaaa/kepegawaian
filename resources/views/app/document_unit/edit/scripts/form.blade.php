<script>
$(document).ready(function() {

    const form = document.getElementById('editDocumentUnitForm')
    const editDocumentUnitForm = $('#editDocumentUnitForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The document_unitname is required'
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
        editDocumentUnitForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')

                const data = {
                    name: name.val(),
                }

                axios.put('/document_unit/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/document_unit') }}';
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
    axios.delete('/document_unit/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/document_unit')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
