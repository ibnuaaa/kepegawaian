<script>
$(document).ready(function() {

    axios.get('/penilaian_prestasi_kerja/tahun/{{ date('Y') }}/bulan/{{ date('m') }}/set/first').then((response) => {
      $('#dashboard_iframe').attr('src', '{{ getConfig('protocol') }}://{{ getConfig('basepath') }}/penilaian_prestasi_kerja/pdf/' + response.data.data.records.id);
    }).catch((error) => {
        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
            swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            hideLoading()
        }
    })

})
</script>
