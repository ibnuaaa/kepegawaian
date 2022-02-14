<script>

$('#modalDelete').on('show.bs.modal', function(e) {
    const { recordId, recordName } = $(e.relatedTarget).data()
    $('#deleteAction').click(function() {
        axios.delete('/user/'+recordId).then((response) => {
            const { data } = response.data
            $('#modalDelete').modal('hide')
            window.location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
            }
        })
    })
})


</script>
