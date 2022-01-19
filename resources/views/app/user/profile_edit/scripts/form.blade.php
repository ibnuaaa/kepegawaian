<script>
$(document).ready(function() {
    $('body #myDatepicker').datepicker({
      format: 'yyyy-mm-dd',
    });
})

// =======================================================================

function savePersonal(e) {

    var field = $(e).attr('name')

    var data = new Object;
    data[field] = $(e).val();

    $(e).addClass('loadingField')
    axios.put('/user/my', data).then((response) => {
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
    axios.put('/user_pendidikan/' + id, data).then((response) => {
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
    axios.put('/user_pelatihan/' + id, data).then((response) => {
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
    axios.put('/user_keluarga/' + id, data).then((response) => {
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
    axios.put('/user_jabatan/' + id, data).then((response) => {
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
    axios.put('/user_golongan/' + id, data).then((response) => {
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
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_pendidikan', data).then((response) => {
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
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_pelatihan', data).then((response) => {
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
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_keluarga', data).then((response) => {
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
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_jabatan', data).then((response) => {
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
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_golongan', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}


function prepareUpload(el, object_type) {
  var files = $(el)[0].files;
  var preview = $(el).siblings("#img-preview");
  for (i = 0; i < files.length; i++) {
    uploadFile(files[i], preview, object_type);
  }
}

var files = [];
function uploadFile(file, preview, object) {
  showLoading()
  var formData = new FormData();
  formData.append('file', file);

    $.ajax({
        url: window.apiUrl + '/upload',
            type: 'post',
            data: formData,
            beforeSend: function(xhr) {
            xhr.setRequestHeader('Authorization', window.axios.defaults.headers['Authorization'])
        },
        contentType: false,
        processData: false,
        success: function(response) {

            // START SAVE LAMPIRAN
            const data_storage = {
                object: object,
                object_id: '{{$data['id']}}',
                file: JSON.stringify(response.data)
            };

            axios.post('/storage/save', data_storage).then((response) => {
                hideLoading()
            }).catch((error) => {
                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                    Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    hideLoading()
                }
            })



            appendImage(preview, response.data)
        }
    });

}


function appendImage(preview, data) {

    img = "";
    if(data.extension.toLowerCase() == 'jpg' || data.extension.toLowerCase() == 'png' || data.extension.toLowerCase() == 'bmp')
    img = "<img src='"+window.apiUrl+"/tmp/"+data.key+"."+data.extension+"' style='max-height:200px;'/>";
    else
    img = "<i class='fas fa-file' style='height:80px;font-size:80px;'></i>";

    preview.html("<div style='float:left;position:relative;'>"
        + "<button class='btn btn-danger btn-xs' onClick='removeNode(this)' style='position:absolute;left:3px;border:solid 1px;' data-key='"+data.key+"'>"
        + "<i class='fa fa-trash'></i></button>"
        + img
        + "</div>");
    }

</script>
