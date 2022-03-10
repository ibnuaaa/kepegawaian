


<!-- JQUERY JS -->
<script src="/assets/js/jquery.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>

<!-- Sticky js -->
<script src="/assets/js/sticky.js"></script>

<!-- SIDEBAR JS -->
<script src="/assets/plugins/sidebar/sidebar.js"></script>


<!-- INTERNAL SELECT2 JS -->
<script src="/assets/plugins/select2/select2.full.min.js"></script>

<!-- INTERNAL Data tables js-->
<script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
<script src="/assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
<script src="/assets/plugins/datatable/dataTables.responsive.min.js"></script>

<!-- INTERNAL APEXCHART JS -->
<script src="/assets/js/apexcharts.js"></script>
<script src="/assets/plugins/apexchart/irregular-data-series.js"></script>

<!-- C3 CHART JS -->
<script src="/assets/plugins/charts-c3/d3.v5.min.js"></script>
<script src="/assets/plugins/charts-c3/c3-chart.js"></script>

<!-- CHART-DONUT JS -->
<script src="/assets/js/charts.js"></script>


<!-- INTERNAL Vector js -->
<script src="/assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
<script src="/assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>


<!-- SIDE-MENU JS-->
<script src="/assets/plugins/sidemenu/sidemenu.js"></script>

<!-- SWEET-ALERT JS -->
<script src="/assets/plugins/sweet-alert/sweetalert.min.js"></script>

<script src="/assets/plugins/notify/js/jquery.growl.js"></script>
<script src="/assets/plugins/notify/js/notifIt.js"></script>

<!-- Color Theme js -->
<script src="/assets/js/themeColors.js"></script>

<!-- CUSTOM JS -->
<script src="/assets/js/custom.js"></script>

<!-- Perfect SCROLLBAR JS-->
<script src="/assets/plugins/p-scroll/perfect-scrollbar.js"></script>
<script src="/assets/plugins/p-scroll/pscroll.js"></script>
<script src="/assets/plugins/p-scroll/pscroll-1.js"></script>


<!-- QS JS -->
<script src="/assets/js/qs.min.js"></script>

<!-- Internal Treeview js -->
<script src="/assets/plugins/jquery-simple-tree-table/jquery-simple-tree-table.js"></script>

<script src="/assets/plugins/axios/dist/axios.min.js"></script>
<script src="/assets/plugins/formvalidation/dist/js/FormValidation.min.js"></script>
<script src="/assets/plugins/formvalidation/dist/js/plugins/J.min.js"></script>
<script src="/assets/plugins/formvalidation/dist/js/plugins/Bootstrap.min.js"></script>
<script src="/assets/plugins/formvalidation/dist/js/plugins/Tachyons.min.js"></script>
<script src="/assets/plugins/loadingoverlay.min.js" type="text/javascript"></script>

<script src="/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

<script>

        $(document).ready(function() {

            @if (MyAccount()->is_change_password != 1)
                @if (empty($change_password))
                    swal({
                        title: "Ubah Password",
                        text: "Anda belum mengubah password. Untuk keamanan, silahkan ubah password anda sebelum menggunakan aplikasi Simpeg. Terimakasih 🙏",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonText: 'Oke, Ke Halaman Ubah Password Sekarang',
                    }, function(isConfirmed) {
                        location.href = '/change_password'
                    })
                @endif
            @endif

            if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
              timerSession()
            }

            $('body input').on('keyup', function() {
                g_timeout = parseInt({{getConfig('session_timeout')}});
            })

            document.onmousemove = function(event) {
              g_timeout = parseInt({{getConfig('session_timeout')}});
            }

            $("#modalPreview").on('shown.bs.modal', function () {
                 setTimeout(() => {
                    $('#iframe-preview').attr('src', g_url)
                    setTimeout(function() {
                        $('#iframe-preview').contents().find('#download').remove();
                     }, 100);
                 }, 1000)
            });
        })

        function addSessionTimeout() {
          $('#modalSession').modal('hide');
          g_timeout = parseInt({{getConfig('session_timeout')}})
          return false;
        }

        var g_timeout = {{getConfig('session_timeout')}}
        function timerSession() {
            g_timeout = g_timeout - 1;
            $('#time_session').html(g_timeout)
            // $('#timer_review').html(g_timeout)


            if (g_timeout == 0) {
              location.href = '/logout'
            } else {

              if (g_timeout < parseInt({{getConfig('session_timeout_popup')}})) {
                $('#modalSession').modal('show');
              }

              setTimeout(timerSession, 1000);
            }
        }

        // Dropzone.autoDiscover = false;
        window.getCookie = function(cname) {
            var name = cname + '='
            var decodedCookie = decodeURIComponent(document.cookie)
            var ca = decodedCookie.split(';')
            for(var i = 0; i <ca.length; i++) {
                var c = ca[i]
                while (c.charAt(0) == ' ') {
                    c = c.substring(1)
                }
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length)
                }
            }
            return ''
        }
        window.appUrl = `${window.location.protocol}//${window.location.host}`
        window.apiUrl = `${window.location.protocol}//${window.location.host.replace('qwerty.', '')}/api`

        // window.axiosCaptcha = axios.create({
        //     baseURL: window.appUrl,
        //     timeout: 36000,
        //     headers: {}
        // })

        window.axios = axios.create({
            baseURL: window.apiUrl,
            timeout: 600000,
            headers: {}
        })

        window.showLoading = function() {
            $.LoadingOverlay("show");
        }
        window.hideLoading = function() {
            $.LoadingOverlay("hide");
        }

        axios.interceptors.response.use(
            response => response,
            error => {
                if (error.response && error.response.data) {
                    console.log(
                        'REQUEST API ERROR :',
                        error.response.data,
                        'ON -> ',
                        error.response.request._url,
                        error.config && error.config.data ? JSON.parse(error.config.data) : null
                    )
                    console.log(error.response)
                }

                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                    console.log('aa ss dd ')
                    swal({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                }

                if (Boolean(error) && Boolean(error.response) && Boolean(error.response.status) && error.response.status) {
                    swal({ title: 'Opps! [Error ' + error.response.status + ']', text: 'Error Server', type: 'error', confirmButtonText: 'Ok' })
                }

                if (error.response && error.response.data && error.response.data.errors) {
                    let errors = ''
                    for (let i = 0; i < Object.keys(error.response.data.errors).length; i++) {
                        const key = Object.keys(error.response.data.errors)[i]
                        for (let j = 0; j < error.response.data.errors[key].length; j++) {
                            const message = error.response.data.errors[key][j]
                            let prefix = ', '
                            if (i === 0 && j === 0) {
                                prefix = ''
                            }
                            errors += `${prefix}${message}`
                        }
                    }
                    if (error.response && error.response.status === 401) {
                    } else {
                        swal({ title: 'Opps...', text: errors, type: 'error', confirmButtonText: 'Ok' })
                    }
                }
                return Promise.reject(error)
            }
        )

        if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
            window.axios.defaults.headers['Authorization'] = `${getCookie('TokenType')} ${getCookie('AccessToken')}`
        }
        $(document).ready(function() {
            // $.fn.datepicker.defaults.format = 'yyyy-mm-dd'

            if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
            }

            // reloadNotification();

            if (getCookie('TokenType') != "" && getCookie('AccessToken')) {
                $('#token').html(getCookie('AccessToken'));
            }

        })



        function prepareUpload(el, object_type, id, is_for_new, allowed_ext) {
            var files = $(el)[0].files;
            var preview = $(el).siblings("#img-preview");

            var is_allowed = true
            // check file type
            for (i = 0; i < files.length; i++) {
                var file = files[i]

                var filename_split = file.name.split('.')
                var ext = filename_split[filename_split.length-1]
                ext = ext.toLowerCase()

                if (allowed_ext) {
                  if (allowed_ext.indexOf(ext) == -1) {
                    is_allowed = false
                  }
                }

            }

            if (is_allowed) {
              for (i = 0; i < files.length; i++) {
                uploadFile(files[i], preview, object_type, id, is_for_new);
              }
            } else {
              swal({ title: 'Opps!', text: 'Mohon maaf, hanya mengizinkan file berikut : ' + allowed_ext.join(','), type: 'error', confirmButtonText: 'Ok' })
            }
        }

        var g_data_storage = [];
        function uploadFile(file, preview, object, id, is_for_new) {
          showLoading()
          var formData = new FormData();
          formData.append('file', file);

            $.ajax({
                url: window.apiUrl + '/upload',
                    type: 'post',
                    data: formData,
                    beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', window.axios.defaults.headers['Authorization'])
                },
                contentType: false,
                processData: false,
                success: function(response) {

                    const data_storage = {
                        object: object,
                        object_id: id,
                        file: JSON.stringify(response.data)
                    };

                    hideLoading()

                    g_data_storage.push(data_storage)
                    // START SAVE LAMPIRAN
                    if (is_for_new) {} else {
                        saveDocument(id)
                    }

                    appendImage(preview, response.data)

                },
                error: function (xhr, ajaxOptions, thrownError) {
                  hideLoading()
                  if (xhr.status == 400) {
                    if (xhr.responseJSON && xhr.responseJSON.exception && xhr.responseJSON.exception.message) {
                        swal({ title: 'Opps!', text: xhr.responseJSON.exception.message, type: 'error', confirmButtonText: 'Ok' })
                    }
                  }
                }
            });
        }

        function saveDocument(id) {

          console.log('saveDocument')
          console.log(g_data_storage)

            showLoading()
            console.log('saveDocument 2222')
            console.log(g_data_storage.length)
            for (var i = 0; i < g_data_storage.length; i++) {
              console.log('rrrr')
                var data_storage_tmp = g_data_storage[i]

                console.log('vvv')

                const data_storage = {
                    object: data_storage_tmp.object,
                    object_id: id,
                    file: data_storage_tmp.file
                };

                console.log('zzz')

                axios.post('/storage/save', data_storage).then((response) => {
                    hideLoading()
                }).catch((error) => {
                    if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                        Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                        hideLoading()
                    }
                })



            }
        }

        function appendImage(preview, data) {

            img = "";
            if(data.extension.toLowerCase() == 'jpg' || data.extension.toLowerCase() == 'png' || data.extension.toLowerCase() == 'bmp')
            img = "<img src='"+window.apiUrl+"/tmp/"+data.key+"."+data.extension+"' style='max-height:200px;'/>";
            else
            img = "<i class='fa fa-file-pdf-o' style='font-size: 50px'></i>";

            preview.html("<div style='float:left;position:relative;'>"
                // + "<button class='btn btn-danger btn-xs' onClick='removeNode(this)' style='position:absolute;left:3px;border:solid 1px;' data-key='"+data.key+"'>"
                // + "<i class='fa fa-trash'></i></button>"
                + img
                + "</div>");
        }

        var g_url = ''
        function openModalPreview(url) {
          $('#modalPreview').modal('show');

          g_url = '{{pdfViewerUrl()}}' + url

          $('#iframe-preview').attr('src', '');


          // document.getElementById('iframe-preview').contentWindow.location.href = g_url
          // document.getElementById('iframe-preview').contentWindow.location.reload()

          return false;
        }




        // filter
        function filterName() {

          const filter_search = $('input[name="filter_search"]').val()
          const query = getQuery()

          query.filter_search = filter_search

          gotoPage(query)

          return false;
        }

        function sortBy(column, current_sort_type) {
            const query = getQuery()

            query.sort = column
            if(current_sort_type == '') query.sort_type = 'asc'
            else if(current_sort_type == 'asc') query.sort_type = 'desc'
            else if(current_sort_type == 'desc') query.sort_type = ''

            if (column != '{{ !empty($_GET['sort']) ? $_GET['sort'] : '' }}') query.sort_type = 'asc'

            gotoPage(query)
        }

        function gotoPage(query) {

          const queryString = Qs.stringify(query)
          if (queryString) {
              window.location = g_href + '?' + queryString
          } else {
              window.location = g_href
          }
        }

        function getQuery() {
          var url = window.location.href
          query = {}
          if (url.indexOf('?') > 0) {
            var split_url = url.split('?')
            var query_split = split_url[split_url.length-1].split('&')
            var query = []
            for (var i = 0; i < query_split.length; i++) {
              var query_split_val = query_split[i].split('=')
              query[query_split_val[0]] = query_split_val[1]
            }
          }

          return query
        }

    </script>
    @yield('script')
    @yield('formValidationScript')
    <!-- END PAGE LEVEL JS -->

    <style type="text/css">
        .loadingField {
            background: #fff3cd !important;
        }

        #basic a span {
            display: none;
        }

        .table-condensed-custom td {
            padding-top: 3px !important;
            padding-bottom: 3px !important;
            font-size: 13px !important;
            vertical-align: top;
        }

        .td-inactive td {
            color: #999 !important;
            background: #eee;
        }

        .td-active td {
            color: #000 !important;
            background: #fff;
        }



    </style>
</body>

</html>
