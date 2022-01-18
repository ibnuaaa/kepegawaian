<script>
$(document).ready(function() {
    $('body #myDatepicker').datepicker();
})


function savePersonal(e, field) {



  // const data = {
  //   `${field}` : 'adasd'
  // };
  //
  // showLoading()
  // axios.put('/user', data).then((response) => {
  //     location.reload()
  // }).catch((error) => {
  //     if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
  //         swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
  //         hideLoading()
  //     }
  // })
}

function saveNewUserPendidikan() {
      const data = {
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_pendidikan', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserPelatihan() {
      const data = {
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_pelatihan', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserKeluarga() {
      const data = {
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_keluarga', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserJabatan() {
      const data = {
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_jabatan', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

function saveNewUserGolongan() {
      const data = {
        user_id : '{{ MyAccount()->id }}'
      };

      showLoading()
      axios.post('/user_golongan', data).then((response) => {
          location.reload()
      }).catch((error) => {
          if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
              swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
              hideLoading()
          }
      })
}

</script>
