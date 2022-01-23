<script>
    $(document).ready(function() {
        const form = document.getElementById('editUserForm')
        const editUserForm = $('#editUserForm').formValidation({
            fields: {
                // name: {
                //     validators: {
                //         notEmpty: {
                //             message: 'Nama IndikatorKinerja harus diisi'
                //         }
                //     }
                // }
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton()
            }
        }).data('formValidation')


        // $('select[name=parent_id]').select2({
        //     ajax: {
        //         url: window.apiUrl + '/indikator_kinerja/status/active',
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
        //                         text: item.name,
        //                         id: item.id
        //                     }
        //                 })
        //             };
        //         }
        //     },
        //     minimumInputLength: 1,
        // });

        $('#saveAction').click(function() {
            editUserForm.validate().then(function(status) {
                if (status === 'Valid') {
                    const name = $('input[name="name"]')
                    const parent_id = $('select[name="parent_id"]')
                    const perspektif_id = $('select[name="perspektif_id"]')
                    const unit_kerja_id = $('select[name="unit_kerja_id"]')

                    const data = {
                        name: name.val(),
                        parent_id: parent_id.val(),
                        unit_kerja_id: unit_kerja_id.val(),
                        perspektif_id: perspektif_id.val(),
                    }

                    showLoading()
                    axios.put('/indikator_kinerja/{{$data->id}}', data).then((response) => {
                        hideLoading()
                        window.location = '/indikator_kinerja'
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
            })
        })

    })

    function changeStatusPosition(status) {

        axios.post('/indikator_kinerja/change_status', {
            indikator_kinerja_id: "{{$data['id']}}",
            status: status
        }).then((response) => {
            // console.log(response)
            // location.reload()
            location.href = "{{ url('/indikator_kinerja') }}"
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
</script>
