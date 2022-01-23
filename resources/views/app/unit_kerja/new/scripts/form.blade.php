<script>
    $(document).ready(function() {

        // $('select[name=parent_id]').select2({
        //     ajax: {
        //         url: window.apiUrl + '/unit_kerja',
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



        const form = document.getElementById('editUserForm')
        const editUserForm = $('#editUserForm').formValidation({
            fields: {
                // name: {
                //     validators: {
                //         notEmpty: {
                //             message: 'Nama UnitKerja harus diisi'
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

        $('#saveAction').click(function() {
            editUserForm.validate().then(function(status) {
                if (status === 'Valid') {
                    const name = $('input[name="name"]')
                    const parent_id = $('select[name="parent_id"]')

                    const data = {
                        name: name.val(),
                        parent_id: parent_id.val()
                    }

                    axios.post('/unit_kerja', data).then((response) => {
                        const {
                            data
                        } = response.data
                        window.location = '/unit_kerja'
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
            })
        })

    })
</script>
