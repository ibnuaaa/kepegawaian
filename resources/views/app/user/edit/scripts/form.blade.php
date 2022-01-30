<script>
$(document).ready(function() {

    const form = document.getElementById('editUserForm')
    const editUserForm = $('#editUserForm').formValidation({
        fields: {
            // username: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The username is required'
            //         },
            //         stringLength: {
            //             min: 3,
            //             max: 191,
            //             message: 'The username must be more than 3 and less than 131 characters long',
            //         },
            //         regexp: {
            //             regexp: /^[a-zA-Z0-9_]+$/,
            //             message: 'The username can only consist of alphabetical, number and underscore',
            //         }
            //     }
            // },
            // password: {
            //     validators: {
            //         stringLength: {
            //             min: 6,
            //             message: 'The password must have at least 6 characters',
            //         }
            //     }
            // },
            // confirmPassword: {
            //     validators: {
            //         identical: {
            //             compare: function() {
            //                 return form.querySelector('input[name="password"]').value
            //             },
            //             message: 'The password and its confirm are not the same'
            //         }
            //     }
            // },
            // position: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The position name is required'
            //         }
            //     }
            // },
            // gender: {
            //     validators: {
            //         notEmpty: {
            //             message: 'The gender name is required'
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

    form.querySelector('input[name="password"]').addEventListener('input', function() {
        editUserForm.revalidateField('confirmPassword')
    })

    $('#saveAction').click(function() {
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const username = $('input[name="username"]')
                const nip = $('input[name="nip"]')
                const password = $('input[name="password"]')
                const email = $('input[name="email"]')
                const position_id = $('select[name="position_id"]')

                const nik = $('input[name="nik"]')
                const golongan_id = $('select[name="golongan_id"]')
                const unit_kerja_id = $('select[name="unit_kerja_id"]')
                const jabatan_id = $('select[name="jabatan_id"]')
                const jabatan_fungsional_id = $('select[name="jabatan_fungsional_id"]')
                const gender = $('select[name="gender"]')
                const jenis_user = $('.jenis_user_radio input[name="jenis_user"]:checked')

                const data = {
                    name: name.val(),
                    username: username.val(),
                    nik: nik.val(),
                    position_id: position_id.val(),
                    jabatan_id: jabatan_id.val(),
                    jabatan_fungsional_id: jabatan_fungsional_id.val(),
                    gender: gender.val(),
                    golongan_id: golongan_id.val(),
                    unit_kerja_id: unit_kerja_id.val(),
                    nip: nip.val(),
                }
                if (password.val()) {
                    data.password = password.val()
                }
                axios.put('/user/{{$data['id']}}', data).then((response) => {
                    // const { data } = response.data;
                    // cosole.log(response);
                    window.location = '{{ url('/user') }}';
                    // location.reload();
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})
</script>
