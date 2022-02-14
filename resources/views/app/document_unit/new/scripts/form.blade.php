<script>
$(document).ready(function() {

    $('body #myDatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

    const form = document.getElementById('newDocumentUnitForm')
    const newDocumentUnitForm = $('#newDocumentUnitForm').formValidation({
        fields: {
            // name: {
            //     validators: {
            //         notEmpty: {
            //             message: 'Nama DocumentUnit Harus diisi'
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
        newDocumentUnitForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const description = $('textarea[name="description"]')
                const unit_kerja_id = $('select[name="unit_kerja_id"]')
                const tanggal_terbit_dokumen = $('input[name="tanggal_terbit_dokumen"]')
                const no_dokumen = $('input[name="no_dokumen"]')
                const perspektif_id = $('select[name="perspektif_id"]')

                axios.post('/document_unit', {
                  name: name.val(),
                  description: description.val(),
                  unit_kerja_id: unit_kerja_id.val(),
                  tanggal_terbit_dokumen: tanggal_terbit_dokumen.val(),
                  no_dokumen: no_dokumen.val(),
                  perspektif_id: perspektif_id.val(),
                }).then((response) => {

                    console.log('bbbb')

                    const { data } = response.data

                    console.log('aaaa')

                    saveDocument(data.id)

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
