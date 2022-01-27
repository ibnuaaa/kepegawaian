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

    var data = {
        penilaian_prestasi_kerja_id: '{{ $data->id }}',
        indikator_kinerja_id: id,
        type: 'skp'
    }

    $(e).removeClass('btn-success');
    $(e).addClass('btn-warning');
    axios.post('/penilaian_prestasi_kerja_item', data).then((response) => {
        $(e).removeClass('btn-warning');
        $(e).addClass('btn-default');
        $.growl.notice({
            message: "Indikator telah berhasil ditambahkan"
        });
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })

    // $('#modalIndikatorKinerja').modal('hide');
    return false;
}


function saveNewIndikatorTambahan(e, id) {

    var data = {
        penilaian_prestasi_kerja_id: '{{ $data->id }}',
        indikator_kinerja_id: id,
        type: 'tambahan'
    }

    showLoading()
    axios.post('/penilaian_prestasi_kerja_item', data).then((response) => {
          location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })

    // $('#modalIndikatorKinerja').modal('hide');
    return false;
}

function remove(id, name) {

  swal({
      title: "Konfirmasi",
      text: "Ingin menghapus data " + name + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal'
  }, function(isConfirmed) {
    console.log(isConfirmed)

    if (isConfirmed) {
      showLoading()
      axios.delete('/penilaian_prestasi_kerja_item/'+id).then((response) => {
          const { data } = response.data
          window.location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          }
      })
    }
  });

  return false;
}


function saveSKP(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/penilaian_prestasi_kerja_item/' + id, data).then((response) => {
        // location.reload()

        console.log(response.data.data.capaian)
        console.log(response.data.data.nilai_kinerja)

        $('#capaian_' + id).val(response.data.data.capaian)
        $('#nilai_kinerja_' + id).val(response.data.data.nilai_kinerja)

        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}


</script>
