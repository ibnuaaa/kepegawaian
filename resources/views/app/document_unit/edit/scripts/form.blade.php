<script>
$(document).ready(function() {

    const form = document.getElementById('editDocumentUnitForm')
    const editDocumentUnitForm = $('#editDocumentUnitForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The document_unitname is required'
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
        editDocumentUnitForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const description = $('textarea[name="description"]')
                const unit_kerja_id = $('select[name="unit_kerja_id"]')
                const tanggal_terbit_dokumen = $('input[name="tanggal_terbit_dokumen"]')
                const no_dokumen = $('input[name="no_dokumen"]')
                const perspektif_id = $('select[name="perspektif_id"]')
                const jenis_dokumen_id = $('select[name="jenis_dokumen_id"]')

                const data = {
                  name: name.val(),
                  description: description.val(),
                  unit_kerja_id: unit_kerja_id.val(),
                  tanggal_terbit_dokumen: tanggal_terbit_dokumen.val(),
                  no_dokumen: no_dokumen.val(),
                  perspektif_id: perspektif_id.val(),
                  jenis_dokumen_id: jenis_dokumen_id.val()
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
