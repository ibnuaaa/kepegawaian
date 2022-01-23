<script>
    $('#modalProcess').on('show.bs.modal', function(e) {
        const {
            recordId,
            recordName
        } = $(e.relatedTarget).data()
        $('#processAction').click(function() {
            $('#modalProcess').modal('hide')
            axios.post('/user_coupon_process', {
                id: recordId
            }).then((response) => {
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
        })
    })


    // filter
    $('#filterAction').click(function() {
        const filter_search = $('input[name="filter_search"]').val()
        const filter_field = $('select[name="filter_field"]').val()
        const filter_from = $('input[name="filter_from"]').val()
        const filter_to = $('input[name="filter_to"]').val()
        const query = {}
        if (filter_search) {
            query.filter_search = filter_search
        }
        if (filter_from) {
            query.filter_from = filter_from
        }
        if (filter_to) {
            query.filter_to = filter_to
        }
        if (filter_field) {
            query.filter_field = filter_field
        }
        const href = '{{ url(' / user_coupon ') }}'
        const queryString = Qs.stringify(query)
        if (queryString) {
            window.location = href + '?' + queryString
        } else {
            window.location = href
        }
        console.log(queryString);
    })

    function sortBy(column, current_sort_type) {
        const filter_search = $('input[name="filter_search"]').val()
        const query = {}
        if (filter_search) {
            query.filter_search = filter_search
        }

        query.sort = column


        if (current_sort_type == '') query.sort_type = 'asc'
        else if (current_sort_type == 'asc') query.sort_type = 'desc'
        else if (current_sort_type == 'desc') query.sort_type = ''

        if (column != '{{ !empty($_GET['
            sort ']) ? $_GET['
            sort '] : '
            ' }}') query.sort_type = 'asc'

        const href = '{{ url(' / ') }}'
        const queryString = Qs.stringify(query)
        if (queryString) {
            window.location = href + '?' + queryString
        } else {
            window.location = href
        }
    }

    $(document).ready(function() {

        $('body #myDatepicker').datepicker();

        // filter manual
        $('#filterManualAction').click(function() {
            filterManualAction(false)
        })

        $('#exportAction').click(function() {
            filterManualAction(true)
        })

    })

    function filterManualAction(isExport) {
        const filter_search = $('input[name="filter_search"]').val()
        const is_processed = $('select[name="is_processed"]').val()
        const is_claimed = $('select[name="is_claimed"]').val()
        const filter_field = $('select[name="filter_field"]').val()
        const filter_from = $('input[name="filter_from"]').val()
        const filter_to = $('input[name="filter_to"]').val()

        const query = {}
        query.filter_search = filter_search
        query.is_processed = is_processed
        query.is_claimed = is_claimed

        if (filter_from) {
            query.filter_from = filter_from
        }

        if (isExport) {
            query.is_export = 'y'
        }
        if (filter_to) {
            query.filter_to = filter_to
        }
        if (filter_field) {
            query.filter_field = filter_field
        }

        const href = '{{ url('
        ') }}'
        const queryString = Qs.stringify(query)
        if (queryString) {
            window.location = href + '?' + queryString
        } else {
            window.location = href
        }
    }
</script>
