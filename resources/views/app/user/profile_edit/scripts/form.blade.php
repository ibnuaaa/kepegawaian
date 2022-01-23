<script>
    $(document).ready(function() {
        $('body #myDatepicker').datepicker({
            format: 'yyyy-mm-dd',
        });
    })

    // =======================================================================

    function remove(id, name, table_name) {

        swal({
            title: "Konfirmasi",
            text: "Ingin menghapus data " + name + " ?",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }, function(isConfirmed) {

            if (isConfirmed) {
                showLoading()
                axios.delete('/user_' + table_name + '/' + id).then((response) => {
                    const {
                        data
                    } = response.data
                    location.href = '/profile/{{ $tab }}'
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
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
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }


    // =======================================================================

    function saveNewUserPendidikan() {
        const data = {
            user_id: '{{ MyAccount()->id }}'
        };

        showLoading()
        axios.post('/user_pendidikan', data).then((response) => {
            location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }

    function saveNewUserPelatihan() {
        const data = {
            user_id: '{{ MyAccount()->id }}'
        };

        showLoading()
        axios.post('/user_pelatihan', data).then((response) => {
            location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }

    function saveNewUserKeluarga() {
        const data = {
            user_id: '{{ MyAccount()->id }}'
        };

        showLoading()
        axios.post('/user_keluarga', data).then((response) => {
            location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }

    function saveNewUserJabatan() {
        const data = {
            user_id: '{{ MyAccount()->id }}'
        };

        showLoading()
        axios.post('/user_jabatan', data).then((response) => {
            location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }

    function saveNewUserGolongan() {
        const data = {
            user_id: '{{ MyAccount()->id }}'
        };

        showLoading()
        axios.post('/user_golongan', data).then((response) => {
            location.reload()
        }).catch((error) => {
            if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                swal({
                    title: 'Opps!',
                    text: error.response.data.exception.message,
                    type: 'error',
                    confirmButtonText: 'Ok'
                })
                hideLoading()
            }
        })
    }
</script>
