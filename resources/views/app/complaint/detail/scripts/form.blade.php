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
        dropdownParent: $("#modalForward"),
        minimumInputLength: 1,
    });

})

function saveForward() {


    var data = new Object;
    data['destination_unit_kerja_id'] = $('select[name=destination_unit_kerja_id]').val();
    data['complaint_id'] = '{{ $data->id }}';

    showLoading()
    axios.post('/complaint_to', data).then((response) => {
      location.reload()
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
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}

function finish() {

    var data = new Object;
    data['status'] = '4';

    showLoading()
    axios.put('/complaint/{{ $data->id }}', data).then((response) => {
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}

function saveReply() {

    var data = new Object;
    data['message'] = $('textarea[name=message]').val();
    data['complaint_id'] = {{ $data->id }};

    showLoading()
    axios.post('/complaint_reply', data).then((response) => {
      location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

    return false;
}


function forward() {

    $('#modalForward').modal('show');

    return false;
}

</script>
