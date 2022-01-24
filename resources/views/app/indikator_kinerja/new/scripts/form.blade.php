<script>
$(document).ready(function() {

  $('#basic').simpleTreeTable({
    opened: [2]
  });

    // $('select[name=parent_id]').select2({
    //     ajax: {
    //         url: window.apiUrl + '/indikator_kinerja',
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

    $('#saveAction').click(function() {
        editUserForm.validate().then(function(status) {
            if (status === 'Valid') {
                const name = $('input[name="name"]')
                const perspektif_id = $('select[name="perspektif_id"]')

                const data = {
                    name: name.val(),
                    parent_id: '{{ $parent_id }}',
                    unit_kerja_id: g_unit_kerja_id,
                    perspektif_id: perspektif_id.val()
                }

                axios.post('/indikator_kinerja', data).then((response) => {
                    const { data } = response.data
                    window.location = '/indikator_kinerja'
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                })
            }
        })
    })

})

function openModalUnitKerja() {
    $('#modalUnitKerja').modal('show');

    return false;
}


var g_unit_kerja_id = '0';
function selectUnitKerja(unit_kerja_id, name) {
    g_unit_kerja_id = unit_kerja_id

    $('#span_unit_kerja').html(name);
    $('#modalUnitKerja').modal('hide');
}

</script>
