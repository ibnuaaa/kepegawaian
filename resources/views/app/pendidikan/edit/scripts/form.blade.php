<script>
    $(document).ready(function() {

        const form = document.getElementById('editPendidikanForm')
        const editPendidikanForm = $('#editPendidikanForm').formValidation({
            fields: {
                name: {
                    validators: {
                        notEmpty: {
                            message: 'The pendidikanname is required'
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
            editPendidikanForm.validate().then(function(status) {
                if (status === 'Valid') {
                    const name = $('input[name="name"]')

                    const data = {
                        name: name.val(),
                    }

                    axios.put('/pendidikan/{{$data['
                        id ']}}', data).then((response) => {
                        window.location = '{{ url(' / pendidikan ') }}';
                    }).catch((error) => {
                        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                            swal({
                                title: 'Opps!',
                                text: error.response.data.exception.message,
                                type: 'error',
                                confirmButtonText: 'Ok'
                            })
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
        axios.delete('/pendidikan/{{$data['
            id ']}}').then((response) => {
            const {
                data
            } = response.data
            window.location = '{{ UrlPrevious(url(' / pendidikan ')) }}'
            $('#modalDelete').modal('hide')
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
            }
        })
    })
</script>
