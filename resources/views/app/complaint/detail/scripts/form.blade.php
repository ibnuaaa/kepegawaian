<script>

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
