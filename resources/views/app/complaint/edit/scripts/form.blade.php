<script>

$(document).ready(function() {

    $('select[name=destination_unit_kerja_id]').select2({
        ajax: {
            url: window.apiUrl + '/unit_kerja',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

})


function trash() {

    var data = new Object;
    data['status'] = '99';

    showLoading()
    axios.put('/complaint/{{ $data->id }}', data).then((response) => {
        location.href = '/complaint/drafts'
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}

function saveEdit(e) {

    var field = $(e).attr('name')

    var data = new Object;
    data[field] = $(e).val();
    data['id'] = '{{ $data->id }}';

    $(e).addClass('loadingField')
    axios.put('/complaint/{{ $data->id }}', data).then((response) => {
        // location.reload()
        $(e).removeClass('loadingField')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}

function saveEditDestination(e) {

    var field = $(e).attr('name')

    var data = new Object;
    data[field] = $(e).val();
    data['id'] = '{{ $data->id }}';

    $(e).addClass('loadingField')


    axios.get('/complaint_to/complaint_id/{{ $data->id }}/set/first').then((response) => {
      var id = response.data.data.records.id

      // console.log(response.data)

      axios.put('/complaint_to/' + id, data).then((response) => {
          // location.reload()
          $(e).removeClass('loadingField')
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })


}


function removeNode(key) {
  showLoading()
  axios.delete('/storage/delete_by_key/' + key).then((response) => {
    location.reload()
  }).catch((error) => {
      if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
          swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          hideLoading()
      }
  })

  return false;
}

function send() {

    var data = new Object;
    data['status'] = '2';

    showLoading()
    axios.put('/complaint/{{ $data->id }}', data).then((response) => {
        location.href = '/complaint/sent'
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}

function process() {

    var data = new Object;
    data['status'] = '3';

    showLoading()
    axios.put('/complaint/{{ $data->id }}', data).then((response) => {
        location.href = '/complaint/inbox'
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}


</script>
