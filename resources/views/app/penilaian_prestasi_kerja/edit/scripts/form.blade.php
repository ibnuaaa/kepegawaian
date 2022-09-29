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

    //td_button_container_'.$item->id.'
    // if ($isSelected) {
    //   $button_pilih = ;
    // } else {
    //   $button_pilih = '';
    // }



    $(e).removeClass('btn-success');
    $(e).addClass('btn-warning');
    axios.post('/penilaian_prestasi_kerja_item', data).then((response) => {

        var button_pilih = ''
        if (response.data.data.id) {
            var prestasi_kinerja_item_id = response.data.data.id
            var button_pilih = '<a href="#" onclick=\'return removeFromPopup(this, "' + prestasi_kinerja_item_id  + '", "' +id + '")\'  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</a>';
        }

        $('#td_button_container_' + id).html(button_pilih);

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

function tolak() {
  $('#modalTolak').modal('show');
}

function openModalDetailRealisasiAtasan() {
  $('#modalDetailRealisasiAtasan').modal('show');

  return false;
}

function saveTolak() {
    var data = {
      penilaian_prestasi_kerja_id: '{{ $data->id }}',
      notes: $('textarea[name=catatan_penolakan]').val()
    }

    showLoading()
    axios.post('/penilaian_prestasi_kerja_approval/reject', data).then((response) => {
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}

function removeFromPopup(e, id, indikator_kinerja_id, name) {

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

      $(e).removeClass('btn-success');
      $(e).addClass('btn-warning');

      axios.delete('/penilaian_prestasi_kerja_item/'+id).then((response) => {
          // const { data } = response.data
          //
          // $(e).removeClass('btn-warning');
          // $(e).addClass('btn-default');

          var button_pilih = '<a href="#" onclick=\'return selectIndikatorKinerja(this, "' + indikator_kinerja_id  + '")\'  class="btn btn-success btn-sm"><i class="fa fa-check"></i> Pilih</a>';

          $('#td_button_container_' + indikator_kinerja_id).html(button_pilih);

          $.growl.notice({
              message: "Indikator telah berhasil ditambahkan"
          });

      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          }
      })
    }
  });

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

function savePeilaianIku(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/penilaian_iku/' + id, data).then((response) => {
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveSKPIndikatorTetap(id, nilai) {

  var data = new Object;
  data['realisasi'] = nilai;

  $('#realisasi_' + id).html(nilai)


  axios.put('/penilaian_prestasi_kerja_item/' + id, data).then((response) => {

      $('#capaian_' + id).val(response.data.data.capaian)
      $('#nilai_kinerja_' + id).val(response.data.data.nilai_kinerja)

  }).catch((error) => {
      if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
          swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          hideLoading()
      }
  })

  return false;
}

function saveSKPIndikatorTetapApproved(id, nilai) {

  var data = new Object;
  data['realisasi_approved'] = nilai;

  $('#realisasi_approved_' + id).html(nilai)


  axios.put('/penilaian_prestasi_kerja_item/' + id, data).then((response) => {

      $('#capaian_' + id).val(response.data.data.capaian)
      $('#nilai_kinerja_' + id).val(response.data.data.nilai_kinerja)

  }).catch((error) => {
      if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
          swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          hideLoading()
      }
  })

  return false;
}



function saveUpdate(e){

    var field = $(e).attr('name')

    var data = new Object;
    data[field] = $(e).val();

    axios.put('/penilaian_prestasi_kerja/' + {{ $data->id }}, data).then((response) => {

        swal({ title: 'Sukses', text: 'Data Penilaian Prestasi Kerja Sudah ter update.', type: 'success', confirmButtonText: 'Ok' })

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

}

function approve(){

    var data = {
      penilaian_prestasi_kerja_id: '{{ $data->id }}'
    }

    showLoading()
    axios.post('/penilaian_prestasi_kerja_approval/approve', data).then((response) => {
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;

}

function selectUnitKerja() {
    var unit_kerja_id = $('select[name=unit_kerja_id]').val();


    if (unit_kerja_id == '0') {
      $( '#tabel-indikator tr' ).each(function( index ) {
        $(this).css("display", "");
      });
    } else {
      $( '#tabel-indikator tr' ).each(function( index ) {
        // console.log( index + ": " + $( this ).text() );
        // $( this ).hide();
        $(this).css("display", "none");
      });
      // $('body #indikator-'+unit_kerja_id).hide();
      $( '#tabel-indikator #indikator'+unit_kerja_id ).each(function( index ) {
        // console.log( index + ": " + $( this ).text() );
        // $( this ).hide();
        $(this).css("display", "");
      });
    }
    // console.log($('body #indikator-'+unit_kerja_id))
}


</script>
