



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



        function prepareUpload(el, object_type, id) {
            var files = $(el)[0].files;
            var preview = $(el).siblings("#img-preview");
            for (i = 0; i < files.length; i++) {
              uploadFile(files[i], preview, object_type, id);
            }
        }

        var files = [];
        function uploadFile(file, preview, object, id) {
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

                    console.log(response)

                    // START SAVE LAMPIRAN
                    const data_storage = {
                        object: object,
                        object_id: id,
                        file: JSON.stringify(response.data)
                    };

                    axios.post('/storage/save', data_storage).then((response) => {
                        hideLoading()
                    }).catch((error) => {
                        if (Boolean(error) && Boolean(error.response) && Boolean(error.response.data) && Boolean(error.response.data.exception) && Boolean(error.response.data.exception.message)) {
                            Swal.fire({ title: 'Opps!', text: error.response.data.exception.message, type: 'error', confirmButtonText: 'Ok' })
                            hideLoading()
                        }
                    })

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

        .bg-deleted {
            background: #ffaaaa;
        }

        .bg-added {
            background: #aaffaa;
        }

        .bg-changed input{
            background: #ffffaa !important;
        }

    </style>
</body>

</html>
