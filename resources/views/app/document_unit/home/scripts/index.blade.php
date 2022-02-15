<script>

$('#modalDelete').on('show.bs.modal', function(e) {
    const { recordId, recordName } = $(e.relatedTarget).data()
    $('#deleteAction').click(function() {

    })
})

const g_href = '{{ url('/document_unit') }}'

function selectJenisDokumen(e) {
    var query = getQuery()
    query.jenis_dokumen_id = $(e).val()
    gotoPage(query)

    return false
}

function selectUnitKerja(e) {
    var query = getQuery()
    query.unit_kerja_id = $(e).val()
    gotoPage(query)

    return false
}


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
      axios.delete('/document_unit/'+id).then((response) => {
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

function approve(id, name) {

  swal({
      title: "Konfirmasi",
      text: "Ingin menyetujui data " + name + " ?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: 'Ya, Setujui',
      cancelButtonText: 'Batal'
  }, function(isConfirmed) {
    console.log(isConfirmed)
    if (isConfirmed) {

      showLoading()

      var data = {
        document_unit_id: id
      }

      axios.post('/document_unit/approve', data).then((response) => {
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
