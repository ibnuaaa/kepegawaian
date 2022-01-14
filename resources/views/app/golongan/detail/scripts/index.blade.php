<script>

$(document).ready(function() {
    // $('select[name=coupon_data]').select2({
    //     ajax: {
    //     url: window.apiUrl + '/roulette_wheel_data',
    //         headers: {
    //             'Authorization': window.axios.defaults.headers['Authorization']
    //         },
    //         dataType: 'json',
    //         delay: 50,
    //         cache: true,
    //         data: function (params) {
    //             return {
    //                 q: params.term,
    //                 page: params.page
    //             };
    //         },
    //         processResults: function (data) {
    //             return {
    //                 results: $.map(data.data.records, function (item) {
    //                     return {
    //                         text: item.value,
    //                         id: item.id
    //                     }
    //                 })
    //             };
    //         }
    //     },
    //     minimumInputLength: 1,
    // });
})

function resetPassword() {
    $('#new_pass').html("");

    axios.post('/golongan/reset_password', {
        golongan_id: "{{$data['id']}}"
    }).then((response) => {
        const { data } = response.data;
        $('#new_pass').html(data.new_pass);

        $('#text_new_pass').show();
        $('#new_pass').show();

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
}

function inactiveGolongan(status) {

    axios.post('/golongan/change_status', {
        golongan_id: "{{$data['id']}}",
        status: status
    }).then((response) => {
        // console.log(response)
        location.reload()
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
}


var g_id = 0;
function savePLT() {
    showLoading()


    if (g_id > 0) {
    axios.put('/golongan_coupon/' + g_id, {
            coupon_data: $('select[name=coupon_data]').val()
        }).then((response) => {

            // console.log(response)

            window.location.reload()
        }).catch((error) => {
            hideLoading()
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })
    } else {
    axios.post('/golongan_coupon', {
            coupon_code: $('input[name=coupon_code]').val(),
            coupon_data: $('select[name=coupon_data]').val(),
            golongan_id: "{{$data['id']}}"
        }).then((response) => {
            window.location.reload()
        }).catch((error) => {
            hideLoading()
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })
    }
}

function deletePLT(id) {
    if (confirm('Are you sure ?')) {
        showLoading()
    axios.delete('/golongan_coupon/' + id).then((response) => {
            window.location.reload()
        }).catch((error) => {
            hideLoading()
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })
    }

    return false;
}


function openInputForm() {
    g_id = 0;
    $('#buttonAddContainer').addClass('hide');
    $('#inputFormContainer').removeClass('hide');

    return false;
}

function cancelSavePLT() {
    $('#buttonAddContainer').removeClass('hide');
    $('#inputFormContainer').addClass('hide');

    return false;
}

function editPLT(id) {
    openInputForm();

    g_id = id

    showLoading()
axios.get('/golongan_coupon/id/' + id + '/set/first').then((response) => {
        var data = response.data.data.records
        $('input[name=url]').val(data.name)
        hideLoading()
    }).catch((error) => {
        hideLoading()
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })

    return false;
}

</script>
