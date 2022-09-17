<script>
function cari() {


  var dari_bulan = $('select[name=dari_bulan]').val()
  var sampai_bulan = $('select[name=sampai_bulan]').val()
  var tahun = $('select[name=tahun]').val()
  var user_id = $('select[name=user_id]').val()
  //
  const query = getQuery()

  query.dari_bulan = dari_bulan
  query.sampai_bulan = sampai_bulan
  query.tahun = tahun
  query.user_id = user_id
  //
  const href = '{{ url('/laporan_iki') }}'
  const queryString = Qs.stringify(query)
  if (queryString) {
      window.location = href + '?' + queryString
  } else {
      window.location = href
  }
  //
  return false;
}


$(document).ready(function() {
    var user_id = $('select[name=user_id]').select2({
        ajax: {
            url: window.apiUrl + '/user',
            headers: {
                'Authorization': window.axios.defaults.headers['Authorization']
            },
            dataType: 'json',
            delay: 50,
            cache: true,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.data.records, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            }
        },
        minimumInputLength: 1,
    });

    material.on('select2:select', function (e) {
        // saveMaterial(e.params.data.id)
    });
});

</script>
