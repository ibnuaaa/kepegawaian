<script>
$(document).ready(function() {

    $('#basic').simpleTreeTable({
      opened: [{{ implode(',',$indikator_kerja_ids) }}]
    });

    const form = document.getElementById('editPenilaianPrestasiKerjaForm')
    const editPenilaianPrestasiKerjaForm = $('#editPenilaianPrestasiKerjaForm').formValidation({
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: 'The penilaian_prestasi_kerjaname is required'
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
        editPenilaianPrestasiKerjaForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')

                const data = {
                    name: name.val(),
                }

                axios.put('/penilaian_prestasi_kerja/{{$data['id']}}', data).then((response) => {
                    window.location = '{{ url('/penilaian_prestasi_kerja') }}';
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

    $("#modalIndikatorKinerja").on('hide.bs.modal', function(){
        showLoading()
        location.reload()
    });
})

function openModalIndikatorKinerja() {
    $('#modalIndikatorKinerja').modal('show');
    return false;
}

function selectIndikatorKinerja(e, id) {

    $(e).removeClass('btn-success');
    $(e).addClass('btn-warning');
    $(e).addClass('btn-default');

    $.growl.notice({
        message: "Indikator telah berhasil ditambahkan"
    });

    $.growl.error({
        message: "Indikator gagal ditambahkan"
    });

    // $('#modalIndikatorKinerja').modal('hide');
    return false;
}


</script>
