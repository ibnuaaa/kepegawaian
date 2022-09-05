<script>


function saveLogbook(e, indikator_kinerja_id, tanggal) {

    $(e).addClass('loadingField')

    var data = {
        tanggal: tanggal,
        indikator_kinerja_id: indikator_kinerja_id,
        penilaian_prestasi_kerja_approval_id: {{ $data['id'] }},
        nilai: $(e).val()
    }

    axios.put('/penilaian_logbook', data).then((response) => {
        $(e).removeClass('loadingField')

        var total = response.data.data.total
        // console.log(total)
        $('#total_' + indikator_kinerja_id).html(total)

    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })
}


</script>
