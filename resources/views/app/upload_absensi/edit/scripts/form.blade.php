<script>
$(document).ready(function() {

    $('#saveAction').click(function() {
        saveExcel('{{ $data['id'] }}')
    })

})

function saveExcel(id) {

    console.log('saveExcel')
    console.log(g_data_storage)

    showLoading()
    console.log('saveExcel 2222')
    console.log(g_data_storage.length)
    for (var i = 0; i < g_data_storage.length; i++) {
    console.log('rrrr')
        var data_storage_tmp = g_data_storage[i]

        console.log('vvv')

        const data_storage = {
            object: data_storage_tmp.object,
            object_id: id,
            file: data_storage_tmp.file
        };

        console.log('zzz')

        axios.post('/storage/save_upload_absensi_excel', data_storage).then((response) => {
            hideLoading()
            // location.reload()
            location.href = '/upload_absensi/' + id
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                hideLoading()
            }
        })
    }
}


$('#deleteOpenModal').click(function() {
    const modalElem = $('#modalDelete')
    $('#modalDelete').modal('show')
})
$('#deleteAction').click(function() {
    axios.delete('/upload_absensi/{{$data['id']}}').then((response) => {
        const { data } = response.data
        window.location = '{{ UrlPrevious(url('/upload_absensi')) }}'
        $('#modalDelete').modal('hide')
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
        }
    })
})
</script>
