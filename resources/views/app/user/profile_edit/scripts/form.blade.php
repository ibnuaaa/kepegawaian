<script>
$(document).ready(function() {
    $('body #myDatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });

    @if($page == 'sdm' || $page == 'diklat' )
    $(".panel-body :input").prop("disabled", true);
    $(".panel-body :select").prop("disabled", true);
    @else if($page == 'profile' )
    $(".bg-deleted :input").prop("disabled", true);
    $(".bg-deleted :select").prop("disabled", true);
    @endif
})

// =======================================================================

function remove(id, name, table_name) {

  swal({
      title: "Konfirmasi",
      text: "Ingin menghapus data " + name + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal'
  }, function(isConfirmed) {

    if (isConfirmed) {
      showLoading()
      axios.delete('/user_' + table_name + '{{ !$id ? '_request' : '' }}/'+id).then((response) => {
          const { data } = response.data
          @if ($page == 'profile')
          location.href = '/profile/{{ $tab }}'
          @else
          location.href = '/profile/{{ $tab }}/{{ $id }}'
          @endif
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          }
      })
    }
  });

  return false;
}

// =======================================================================

function savePersonal(e) {

    var field = $(e).attr('name')

    var data = new Object;
    data[field] = $(e).val();
    data['id'] = '{{ $data->id }}';

    $(e).addClass('loadingField')
    axios.put('/user{{ !$id ? '_request/my' : '/'. $id }}', data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function savePendidikan(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_pendidikan{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveJabatanFungsional(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_jabatan_fungsional{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function savePelatihan(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_pelatihan{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveKeluarga(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_keluarga{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveJabatan(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_jabatan{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveGolongan(e) {

    var field = $(e).attr('name')
    var id = $(e).attr('data-id')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user_golongan{{ !$id ? '_request' : '' }}/' + id, data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}


// =======================================================================

function saveNewUserPendidikan() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_pendidikan{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserJabatanFungsional() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_jabatan_fungsional{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserPelatihan() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_pelatihan{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserKeluarga() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_keluarga{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserJabatan() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_jabatan{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserGolongan() {
      const data = {
        user_id : '{{ !$id ? MyAccount()->id : $data->id }}',
        user_request_id : '{{ $data->id }}'
      };

      showLoading()
      axios.post('/user_golongan{{ !$id ? '_request' : '' }}', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}





// ================================================================


function approve(menu) {
      showLoading()



      if (menu == 'sdm') {
          var data = {
            id: '{{ $data->id }}',
            status_sdm_approved: 'y'
          }
      }

      if (menu == 'diklat') {
          var data = {
            id: '{{ $data->id }}',
            status_diklat_approved: 'y'
          }
      }



      axios.post('/user_request/approve', data).then((response) => {

          if (menu == 'sdm') {

            approve('diklat');

          } else {
            @if($page == 'profile')
            location.href= '/profile'
            @else
            location.href= '/user_request/status/request_approval/' + menu
            @endif
          }


          // console.log(response.data)
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })

      return false;
}

function request_approval() {
      // showLoading()

      var data = {
        id: '{{ $data->id }}'
      }

      console.log('request_approval')


      axios.post('/user_request/request_approval', data).then((response) => {
          location.href= '/profile'
          // console.log(response.data)
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })

      return false;
}

function warning() {
    swal({ title: 'Opps!', text: "Mohon maaf, Anda belum dapat menyetujui karena user belum melakukan permintaan persetujuan. Terimakasih", type: 'error', confirmButtonText: 'Ok' })

    return false;
}

var g_menu = ''
function openModalReject(menu) {
  g_menu = menu

  $('#modalReject').modal('show');

  return false;
}

function saveReject() {
  var reject_description = $('textarea[name=reject_description]').val();

  showLoading()



  if (g_menu == 'sdm') {
      var data = {
        id: '{{ $data->id }}',
        status_sdm_rejected: 'y',
        description: reject_description
      }
  }

  if (g_menu == 'diklat') {
      var data = {
        id: '{{ $data->id }}',
        status_diklat_rejected: 'y',
        description: reject_description
      }
  }



  axios.post('/user_request/reject', data).then((response) => {
      @if($page == 'profile')
      location.href= '/profile'
      @else
      location.href= '/user_request/status/request_approval/' + g_menu
      @endif
      // console.log(response.data)
  }).catch((error) => {
      if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
          swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          hideLoading()
      }
  })

  return false;

}


</script>
