<script>
    function remove(id, name) {

        swal({
            title: "Konfirmasi",
            text: "Ingin menghapus " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }, function(isConfirmed) {
            console.log(isConfirmed)

            if (isConfirmed) {
                showLoading()
                axios.delete('/unit_kerja/' + id).then((response) => {
                    const {
                        data
                    } = response.data
                    window.location.reload()
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({
                            title: 'Opps!',
                            text: error.response.data.exception.message,
                            type: 'error',
                            confirmButtonText: 'Ok'
                        })
                    }
                })
            }
        });

        return false;
    }


    $(document).ready(function() {
        $('#basic').simpleTreeTable({
            expander: $('#expander'),
            collapser: $('#collapser'),
            store: 'session',
            storeKey: 'simple-tree-table-basic'
        });
    });
</script>
