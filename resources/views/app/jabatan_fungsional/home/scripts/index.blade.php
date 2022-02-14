<script>

$('#modalDelete').on('show.bs.modal', function(e) {
    const { recordId, recordName } = $(e.relatedTarget).data()
    $('#deleteAction').click(function() {

    })
})

// filter

const g_href = '{{ url('/jabatan_fungsional') }}'

function remove(id, name) {

  swal({
      title: "Konfirmasi",
      text: "Ingin menghapus data " + name + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Ya, Hapus',
      cancelButtonText: 'Batal'
  }, function(isConfirmed) {
    console.log(isConfirmed)

    if (isConfirmed) {
      showLoading()
      axios.delete('/jabatan_fungsional/'+id).then((response) => {
          const { data } = response.data
          window.location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
          }
      })
    }
  });

  return false;
}


</script>
