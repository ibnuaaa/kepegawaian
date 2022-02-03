<?php

if (! function_exists('message')) {
    function message($id = null, $replace = [], $locale = null, $autoCapitalize = true) {
        if (is_null($id)) {
            return app('translator');
        }
        foreach ($replace as $key => $value) {
            if ($key === 'attribute') {
                $replace[$key] = app('translator')->trans('validation.attributes.'.$value, [], $locale);
            }
        }
        $message = app('translator')->trans($id, $replace, $locale);
        if ($autoCapitalize) {
            return ucfirst($message);
        }
        return $message;
    }
}

if (! function_exists('message_choice')) {
    function message_choice($id, $number, array $replace = [], $locale = null)
    {
        return app('translator')->transChoice($id, $number, $replace, $locale);
    }
}
if (! function_exists('random_string')) {
    function random_string($length = 10)
    {
        $characters = '123456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (! function_exists('get_expiration_date')) {
    function get_expiration_date($date) {
        $date_num = 0;
        $date_5_days_after = '';

        for ($i=1; $i <= 100; $i++) {
            $date_c = date_create($date);
            $date_plus = date_add($date_c,date_interval_create_from_date_string($i." days"));
            $dow = date_format($date_plus,"w");
            if ($date_num <= 5) {
                if (!in_array($dow, [0,6])) {
                    $date_num++;
                    if ($date_num==5) $date_5_days_after = $date_plus;
                }
            }
        }

        return date_format($date_5_days_after, 'Y-m-d H:i:s');
    }
}

if ( ! function_exists('config_path'))
{
    /**
     * Get the configuration path.
     *
     * @param  string $path
     * @return string
     */
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if ( ! function_exists('getTable'))
{
    function getTable($Model)
    {
        return with(new $Model())->getTable();
    }
}

if ( ! function_exists('getPrefix'))
{
    function getPrefix($TableName = '')
    {
        return config('database.connections.mysql.prefix') . $TableName;
    }
}

if ( ! function_exists('QueryRoute'))
{
    function QueryRoute($request)
    {
        $QueryRoute = new \App\Support\QueryRoute($request);
        return $QueryRoute->get();
    }
}

if ( ! function_exists('now'))
{
    function now()
    {
        return \Carbon\Carbon::now();
    }
}

if ( ! function_exists('carbon_parse'))
{
    function carbon_parse($date)
    {
        return \Carbon\Carbon::parse($date);
    }
}

if ( ! function_exists('set_if_false'))
{
    function set_if_false($new, $old)
    {
        if ($new) {
            return $new == $old;
        }
        return true;
    }
}

if ( ! function_exists('is_updated'))
{
    function is_updated($changes, $thing)
    {
        return isset($changes[$thing]);
    }
}

if ( ! function_exists('getPayloadChanges'))
{
    function getPayloadChanges($payload)
    {
        if (isset($payload->all()['Changes'])) {
            return $payload->all()['Changes'];
        }
        return [];
    }
}

if ( ! function_exists('getDirty'))
{
    function getDirty($Model)
    {
        return $Model->getDirty();
    }
}

if ( ! function_exists('getConfig'))
{
    function getConfig($key = null)
    {
      return \App\Support\Config::getConfig($key);
    }
}

if ( ! function_exists('pdfViewerUrl'))
{
    function pdfViewerUrl($url = null)
    {
      return getConfig('protocol') . "://" . getConfig('basepath') . "/assets/plugins/viewer-js/#" . $url;
    }
}

if ( ! function_exists('signing_cleaner'))
{
    function signing_cleaner($source = null, $target = null)
    {
        $cleanBr = false;
        if (strpos($source, 'Bina Administrasi Kewilayahan') !== false) {
            if (strpos($target, 'Bina Administrasi Kewilayahan') !== false) {
                $target = str_replace('Bina Administrasi Kewilayahan','',$target);
                $cleanBr = true;
            }
            $target = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $target)));
        }
        if (strpos($source, 'Bina Keuangan Daerah') !== false) {
            if (strpos($target, 'Bina Keuangan Daerah') !== false) {
                $target = str_replace('Bina Keuangan Daerah','',$target);
                $cleanBr = true;
            }
            $target = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", " ", $target)));
        }
        if ($cleanBr) {
            $target = str_replace(' <br/>','',$target);
            $target = str_replace('<br/>','',$target);
        }
        return $target;
    }
}

if ( ! function_exists('isModelChanged'))
{
    function isModelChanged($Model, $thing)
    {
        if (isset($Model->getDirty()[$thing])) {
            return true;
        }
        return false;
    }
}

if ( ! function_exists('___TableGetCurrentPage'))
{
    function ___TableGetCurrentPage($request, $TableKey)
    {
        $CurrentPage = (int)$request->input($TableKey.'-page');
        if (!$CurrentPage) {
            $CurrentPage = (int)1;
        } else {
            $CurrentPage = (int)$CurrentPage;
        }
        return $CurrentPage;
    }
}

if ( ! function_exists('___TablePaginate'))
{
    function ___TablePaginate($total, $limit, $now)
    {
        $paginationNumber = [];
        $adjacents = 2;
        $pages = $limit ? ceil($total / $limit) : 0;
        if ($pages) {
            if ($pages < 7 + ($adjacents * 2)) {
                for ($i = 1; $i <= $pages; $i++) {
                    $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                }
            } else if ($pages > 5 + ($adjacents * 2)) {
                if ($now < 1 + ($adjacents * 2)) {
                    for ($i = 1; $i < 4 + ($adjacents * 2); $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    $paginationNumber[] = [ 'page' => $pages, 'name' => $pages ];
                } else if($pages - ($adjacents * 2) > $now && $now > ($adjacents * 2)) {
                    $paginationNumber[] = [ 'page' => 1, 'name' => 1 ];
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    for ($i = $now - $adjacents; $i <= $now + $adjacents ; $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    $paginationNumber[] = [ 'page' => $pages, 'name' => $pages ];
                } else {
                    $paginationNumber[] = [ 'page' => 1, 'name' => 1 ];
                    $paginationNumber[] = [ 'page' => 0, 'name' => '...' ];
                    for ($i = $pages - (2 + ($adjacents * 2)); $i <= $pages; $i++) {
                        $paginationNumber[] = [ 'page' => $i, 'name' => $i ];
                    }
                }
            }
        }
        $table = [
            'pages' => $pages,
            'paginationNumber' => $paginationNumber
        ];
        $table['startentries'] = $total > 0 ? ((($now - 1 ) * $limit) + 1) : 0;
        $table['endentries'] = $table['startentries'] + ($limit - 1);
        if ($table['endentries'] > $total){
            $table['endentries'] = $total;
        }
        return (object)$table;
    }
}

if ( ! function_exists('___TableGetSkip'))
{
    function ___TableGetSkip($request, $TableKey, $take = 10)
    {
        $Skip = (int)$request->input($TableKey.'-page');
        if (!$Skip) {
            $Skip = (int)0;
        } else {
            $Skip = (int)$Skip * (int)$take - (int)$take;
        }
        return $Skip;
    }
}

if ( ! function_exists('___TableGetFilterSearch'))
{
    function ___TableGetFilterSearch($request, $TableKey)
    {
        return $request->input("$TableKey-filter_search");
    }
}

if ( ! function_exists('___TableGetTake'))
{
    function ___TableGetTake($request, $TableKey)
    {
        return $request->input("$TableKey-take") ? $request->input("$TableKey-take") : 10;
    }
}

if ( ! function_exists('___TableGetRefreshAction'))
{
    function ___TableGetRefreshAction($request, $TableKey)
    {
        $IsRefesh = false;
        $refresh = $request->input("$TableKey-refresh");
        if ($refresh && $refresh === 'true') {
            $IsRefesh = true;
        }
        return $IsRefesh;
    }
}

if ( ! function_exists('___TableGetQuery'))
{
    function ___TableGetQuery($request, $TableKey)
    {
        $Take = ___TableGetTake($request, $TableKey);
        $Skip = ___TableGetSkip($request, $TableKey, $Take);
        $CurrentPage = ___TableGetCurrentPage($request, $TableKey);
        $FilterSearch = ___TableGetFilterSearch($request, $TableKey);
        $IsRefesh = ___TableGetRefreshAction($request, $TableKey);
        return (object)[
            'take' => $Take,
            'skip' => $Skip,
            'currentPage' => $CurrentPage,
            'filterSearch' => $FilterSearch,
            'isRefesh' => $IsRefesh,
        ];
    }
}



if ( ! function_exists('UrlPrevious'))
{
    function UrlPrevious($urlBackup = null)
    {
        $referer = null;
        $host = null;
        if (isset($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
        }
        if (isset($_SERVER['HTTP_HOST'])) {
            $host = $_SERVER['HTTP_HOST'];
        }
        if (!$referer && $urlBackup) {
            $referer = $urlBackup;
        }
        if ($referer === \URL::full()) {
            $referer = $urlBackup ? $urlBackup : url();
        }
        return $referer;
    }
}

if ( ! function_exists('MyAccount'))
{
    function MyAccount($urlBackup = null)
    {
        return Auth::user();
    }
}

function getMenuCounter($Id)
{
    return \App\Support\Counter::getCount($Id);
}

function MyPlt()
{
    return \App\Support\Plt::getPlt();
}

if ( ! function_exists('FormSelect'))
{
    function FormSelect($Data, $toArray = false, $value = 'id', $label = 'name')
    {

        // die();

        $options = $Data->map(function($item) use($value, $label) {
            return [ 'value' => $item->{$value}, 'label' => $item->{$label} ];
        });

        if ($toArray) {
            $result = array_merge([[
              'label' => '-= Pilih =-',
              'value' => '',
            ]], $options->toArray());

            return $result;
        }

        return $options;
    }
}

// Browse Helper
if ( ! function_exists('BrowseData'))
{
    function BrowseData($Browse)
    {
        return $Browse->original['data'];
    }
}

// Satellite Helper
if ( ! function_exists('SatelliteClient'))
{
    function SatelliteClient()
    {
        return new App\Support\Satellite\Client();
    }
}

// URL Helper
if ( ! function_exists('baseUrl'))
{
    function baseUrl($extra)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        $extra = ltrim($extra, '/');
        return env('BASE_URL', $actual_link).'/'.$extra;
    }
}

// URL Helper
if ( ! function_exists('fullUrl'))
{
    function fullUrl()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }
}

if ( ! function_exists('fullUri'))
{
    function fullUri($QueryString = [], $DeleteQuery = [], $withFullUrl = false)
    {
        $Qs = $_SERVER['QUERY_STRING'];
        parse_str($Qs, $QsArr);
        $MergedQuery = array_merge($QsArr, $QueryString);
        foreach ($DeleteQuery as $DeleteQueryKey) {
            if (isset($MergedQuery[$DeleteQueryKey])) {
                unset($MergedQuery[$DeleteQueryKey]);
            }
        }
        $url = strtok($_SERVER["REQUEST_URI"], '?');
        if (count($MergedQuery) > 0) {
            $url .= '?'.http_build_query($MergedQuery);
        }
        if ($withFullUrl) {
            return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$url";
        }
        return $url;
    }
}

if ( ! function_exists('likeMatch'))
{
    function likeMatch($pattern, $subject)
    {
        $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
        return (bool) preg_match("/^{$pattern}$/i", $subject);
    }
}

if ( ! function_exists('searchData'))
{
    function searchData($Data, $Search = '', $SearchField = '*')
    {
        $filtered = $Data->filter(function ($value, $key) use($Search, $SearchField) {
            $filtered = array_filter($value, function($v, $k) use($Search, $SearchField) {
                if (is_array($SearchField)) {
                    if (in_array($k, $SearchField)) {
                        return likeMatch("%$Search%", $v);
                    } else {
                        return false;
                    }
                } else {
                    return likeMatch("%$Search%", $v);
                }
            }, ARRAY_FILTER_USE_BOTH);
            return count($filtered) > 0;
        });
        return $filtered;
    }
}

if ( ! function_exists('__GETACCSERVICE'))
{
    function __GETACCSERVICE($TableKey, $FLAG_ACTION, $REFRESH = false)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($FLAG_ACTION) {
            $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'doSendDataVerifyCMS' => [
                        'FLAG_ACTION' => $FLAG_ACTION
                    ]
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}

if ( ! function_exists('__GETACCSERVICETABLEPARAMS'))
{
    function __GETACCSERVICETABLEPARAMS($TableKey, $PARAMS, $REFRESH = false, $REDIRECT = true)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($PARAMS) {
            $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'doSendDataVerifyCMS' => $PARAMS
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH && $REDIRECT) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}

if ( ! function_exists('__GETACCSERVICEWITHPARAMS'))
{
    function __GETACCSERVICEWITHPARAMS($PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/cms/datacenter', [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataVerifyCMS' => $PARAMS
            ]
        ]);
        $data = $Data->getOutData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return [];
        }
    }
}


if ( ! function_exists('__POSTACCSERVICE'))
{
    function __POSTACCSERVICE($URL = '', $PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataAccount' => $PARAMS
            ]
        ]);
        return $Data->getOutMess();
    }
}


if ( ! function_exists('__POSTACCSERVICECUSTOMER'))
{
    function __POSTACCSERVICECUSTOMER($URL = '', $PARAMS = [], $isMessage = true)
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataCustomer' => $PARAMS
            ]
        ]);
        if ($isMessage) {
            return $Data->getOutMess();
        } else {
            return $Data->getOutData();
        }
    }
}

if ( ! function_exists('__POSTACCSERVICEVERIFY'))
{
    function __POSTACCSERVICEVERIFY($URL = '', $PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        if (empty($URL)) {
            throw new Exception("URL NOT NULL");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/' . $URL, [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataVerifyCMS' => $PARAMS
            ]
        ]);
        return $Data->getOutMess();
    }
}

if ( ! function_exists('__POSTACCSERVICECONTENT'))
{
    function __POSTACCSERVICECONTENT($PARAMS = [], $isMessage = true)
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataContent' => $PARAMS
            ]
        ]);
        if ($isMessage) {
            return $Data->getOutMess();
        } else {
            return $Data->getOutData();
        }
    }
}

if ( ! function_exists('__GETACCSERVICECONTENTWITHPARAMS'))
{
    function __GETACCSERVICECONTENTWITHPARAMS($PARAMS = [])
    {
        if (!is_array($PARAMS)) {
            throw new Exception("PARAMS NOT ARRAY");
        }
        $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
            \GuzzleHttp\RequestOptions::JSON => [
                'dataContent' => $PARAMS
            ]
        ]);
        $data = $Data->getOutData();
        if (isset($data[0])) {
            return $data[0];
        } else {
            return [];
        }
    }
}

if ( ! function_exists('__GETACCSERVICECONTENT'))
{
    function __GETACCSERVICECONTENT($TableKey, $FLAG_ACTION, $REFRESH = false, $REDIRECT = true)
    {
        if ($REFRESH) {
            Cache::forget('cache-'.$TableKey);
        }
        $data = Cache::rememberForever('cache-'.$TableKey, function () use($FLAG_ACTION) {
            $Data = SatelliteClient()->post('/restV2/accpartner/content/datanews', [
                \GuzzleHttp\RequestOptions::JSON => [
                    'dataContent' => [
                        'FLAG_ACTION' => $FLAG_ACTION
                    ]
                ]
            ]);
            return $Data->getOutData();
        });
        if ($REFRESH && $REDIRECT) {
            header("Location: ".fullUri([], ["$TableKey-refresh"], true));
        }
        return $data;
    }
}


if ( ! function_exists('__GETLISTJABATAN'))
{
    function __GETLISTJABATAN($withAdmin = false)
    {
        $Data = SatelliteClient()->post('/restV2/accpartner/user/account', [
            \GuzzleHttp\RequestOptions::JSON => [
                'doSendDataAccount' => [
                    'FLAG_ACTION' => 'GET_LIST_DATA_JABATAN'
                ]
            ]
        ]);
        $data = $Data->getOutData();
        if (!$withAdmin) {
            foreach ($data as $index => $value) {
                if ($value['NO_SR'] == 'A' || $value['DESC_GCM'] == 'ADMIN') {
                    unset($data[$index]);
                }
            }
        }
        $options = $data->map(function($item) {
            return [ 'value' => $item['NO_SR'], 'label' => $item['DESC_GCM'] ];
        });
        return $options;
    }
}


// Cetak
if ( ! function_exists('cetak'))
{
    function cetak($string)
    {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }
}

if ( ! function_exists('string_underscore'))
{
    function string_underscore($string)
    {
        $string = strtolower($string);
        $string = str_replace(' ','_',$string);
        return $string;
    }
}

if ( ! function_exists('recalculate_body_margin'))
{
    function recalculate_body_margin($string)
    {
        $data = explode(' ',$string);
        $ret = '0cm '.$data[1].' '.$data[2].' '.$data[3];
        return $ret;
    }
}

if ( ! function_exists('recalculate_header_margin'))
{
    function recalculate_header_margin($string)
    {
        $data = explode(' ',$string);
        $ret = $data[0].' '.$data[1].' 1cm '.$data[3];
        return $ret;
    }
}

// golongan
if ( ! function_exists('golongan'))
{
    function golongan($string = null)
    {
        $string = str_replace(' I/a','',$string);
        $string = str_replace(' I/b','',$string);
        $string = str_replace(' I/c','',$string);
        $string = str_replace(' I/d','',$string);
        $string = str_replace(' I/e','',$string);
        $string = str_replace(' II/a','',$string);
        $string = str_replace(' II/b','',$string);
        $string = str_replace(' II/c','',$string);
        $string = str_replace(' II/d','',$string);
        $string = str_replace(' II/e','',$string);
        $string = str_replace(' III/a','',$string);
        $string = str_replace(' III/b','',$string);
        $string = str_replace(' III/c','',$string);
        $string = str_replace(' III/d','',$string);
        $string = str_replace(' III/e','',$string);
        $string = str_replace(' IV/a','',$string);
        $string = str_replace(' IV/b','',$string);
        $string = str_replace('IV/c','',$string);
        $string = str_replace(' IV/d','',$string);
        $string = str_replace(' IV/e','',$string);
        return $string;
    }
}

if ( ! function_exists('convertToReadableSize'))
{
    function convertToReadableSize($size){
      $base = log($size) / log(1024);
      $suffix = array("", "KB", "MB", "GB", "TB");
      $f_base = floor($base);
      return round(pow(1024, $base - floor($base)), 1) . $suffix[$f_base];
    }
}

if ( ! function_exists('getPermissions'))
{
    function getPermissions($key = null)
    {
      return \App\Support\Permission::getPermissions($key);
    }
}

if ( ! function_exists('encodeId'))
{
    function encodeId($id){
      return  md5($id . '-' . env('APP_KEY'));
    }
}

if ( ! function_exists('dateIndo'))
{
    function dateIndo($datetime){
        $month_num =  strftime('%m',  strtotime($datetime));

        $months = array(
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        );

        return  strftime('%e ' . $months[$month_num] . ' %Y',  strtotime($datetime));
    }
}

if ( ! function_exists('jamIndo'))
{
    function jamIndo($datetime){
        return  date('H:i:s',  strtotime($datetime));
    }
}

if ( ! function_exists('monthIndo'))
{
    function monthIndo($month){

        $month = (int) $month;

        $months = array(
            '',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        return  $months[$month];
    }
}

if ( ! function_exists('dayIndo'))
{
    function dayIndo($day){

        $day = (int) $day;

        $days = array(
            '',
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        );

        return  $days[$day];
    }
}

if ( ! function_exists('timeIndo'))
{
    function timeIndo($datetime){
        return  strftime('%H:%M:%S ',  strtotime($datetime));
    }
}

function penyebut($nilai) {
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " ". $huruf[$nilai];
    } else if ($nilai <20) {
        $temp = penyebut($nilai - 10). " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai/10)." puluh". penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai/100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai/1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai/1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai/1000000000) . " milyar" . penyebut(fmod($nilai,1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai/1000000000000) . " trilyun" . penyebut(fmod($nilai,1000000000000));
    }
    return $temp;
}

function terbilang($nilai) {
    if($nilai<0) {
        $hasil = "minus ". trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

if ( ! function_exists('agama'))
{
    function agama($id = null)
    {

        $list = [
          [
            'value' => 1,
            'label' => 'Islam',
          ],
          [
            'value' => 2,
            'label' => 'Kristen',
          ],
          [
            'value' => 3,
            'label' => 'Katolik',
          ],
          [
            'value' => 4,
            'label' => 'Hindu',
          ],
          [
            'value' => 5,
            'label' => 'Budha',
          ]
        ];

        if ($id) {
          $ret = "";
          foreach ($list as $key => $value) {


            if ($value['value'] == $id) {
              $ret = $value['label'];
            }
          }

          return $ret;
        }

        return $list;
    }
}

if ( ! function_exists('gender'))
{
    function gender($id = null)
    {

        $list = [
          [
            'value' => 'male',
            'label' => 'Laki-laki',
          ],
          [
            'value' => 'female',
            'label' => 'Perempuan',
          ]
        ];

        if ($id) {
          $ret = "";
          foreach ($list as $key => $value) {


            if ($value['value'] == $id) {
              $ret = $value['label'];
            }
          }

          return $ret;
        }

        return $list;
    }
}

if ( ! function_exists('perspektif'))
{
    function perspektif($id = null)
    {

        $list = [
          [
            'value' => '',
            'label' => '-= Pilih =-',
          ],
          [
            'value' => '1',
            'label' => 'Stakeholders',
          ],
          [
            'value' => '2',
            'label' => 'Internal Business Process',
          ],
          [
            'value' => '3',
            'label' => 'Learning & Growth',
          ],
          [
            'value' => '4',
            'label' => 'Financial',
          ]
        ];

        if ($id) {
          $ret = "";
          foreach ($list as $key => $value) {


            if ($value['value'] == $id) {
              $ret = $value['label'];
            }
          }

          return $ret;
        }

        return $list;
    }
}

if ( ! function_exists('status_perkawinan'))
{
    function status_perkawinan($id = null)
    {

        $list = [
          [
            'value' => '1',
            'label' => 'Menikah',
          ],
          [
            'value' => '2',
            'label' => 'Belum Menikah',
          ],
          [
            'value' => '3',
            'label' => 'Janda / Duda',
          ]
        ];

        if ($id) {
          $ret = "";
          foreach ($list as $key => $value) {


            if ($value['value'] == $id) {
              $ret = $value['label'];
            }
          }

          return $ret;
        }

        return $list;
    }
}


if ( ! function_exists('treeChild'))
{
    function treeChild($data, $dataParent){

        $html = "";

        if (!empty($data)) {

            foreach ($data as $item) {

                $html_user = '';

                if (!empty($item->users)) {
                  foreach ($item->users as $key => $user) {
                      $html_user = $html_user  . ($user ? $user->name : '');
                  }
                }

                $html .= '
                  <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '" class="td-' . $item->status . '">
                      <td style="height: 10px !important;">
                          ' . $item->name . '
                      </td>
                      <td>
                        ' . $html_user . '
                      </td>
                      <td>
                          <a href="'. url('/position/'.$item->id) .'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="'. url('/position/new/'.$item->id) .'" class="btn btn-primary btn-sm">
                              <i class="fa fa-plus"></i>
                          </a>
                          <a onClick="return remove('.$item->id.')" href="#" class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                          </a>

                      </td>
                  </tr>
                ' . (count($item->children) > 0 ? treeChild($item->children, $item) : '') ;
            }
        }

        return $html;

    }
}

if ( ! function_exists('treeSelectJabatan'))
{
    function treeSelectJabatan($data, $dataParent, $selected_id=0){

        $html = "";
        if (!empty($data)) {
            foreach ($data as $item) {

                $html .= '<option value="'.$item->id.'"  '.($item->id ==  $selected_id? 'selected=selected' : '').'>'.$item->name.'</option>' . (count($item->children) > 0 ? treeSelectJabatan($item->children, $item, $selected_id) : '') ;
            }
        }

        return $html;

    }
}

if ( ! function_exists('treeChildJabatan'))
{
    function treeChildJabatan($data, $dataParent){

        $html = "";

        if (!empty($data)) {

            foreach ($data as $item) {

                $html_user = '';

                if (!empty($item->users)) {
                  foreach ($item->users as $key => $user) {
                      $html_user = $html_user  . ($user ? $user->name : '');
                  }
                }

                $html .= '
                  <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '" class="td-' . $item->status . '">
                      <td style="height: 10px !important;">
                          ' . $item->name . '
                      </td>
                      <td>
                        ' . $html_user . '
                      </td>
                      <td>
                          <a href="'. url('/jabatan/'.$item->id) .'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="'. url('/jabatan/new/'.$item->id) .'" class="btn btn-primary btn-sm">
                              <i class="fa fa-plus"></i>
                          </a>
                          <a onClick="return remove('.$item->id.')" href="#" class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                          </a>

                      </td>
                  </tr>
                ' . (count($item->children) > 0 ? treeChildJabatan($item->children, $item) : '') ;
            }
        }

        return $html;

    }
}


if ( ! function_exists('treeSelectUnitKerja'))
{
    function treeSelectUnitKerja($data, $dataParent, $selected_id=0){

        $html = "";
        if (!empty($data)) {
            foreach ($data as $item) {

                $html .= '<option value="'.$item->id.'"  '.($item->id ==  $selected_id? 'selected=selected' : '').'>'.$item->name.'</option>' . (count($item->children) > 0 ? treeSelectUnitKerja($item->children, $item, $selected_id) : '') ;
            }
        }

        return $html;

    }
}

if ( ! function_exists('treeChildUnitKerja'))
{
    function treeChildUnitKerja($data, $dataParent){

        $html = "";

        if (!empty($data)) {

            foreach ($data as $item) {

                $html_user = '';

                if (!empty($item->users)) {
                  foreach ($item->users as $key => $user) {
                      $html_user = $html_user  .($key > 0 ? '<br/>' : ''). ($user ? $user->name : '');
                  }
                }

                $html .= '
                  <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '">
                      <td style="height: 10px !important;">
                          ' . $item->name . '
                      </td>
                      <td>
                        ' . $html_user . '
                      </td>
                      <td>
                          <a href="'. url('/unit_kerja/'.$item->id) .'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="'. url('/unit_kerja/new/'.$item->id) .'" class="btn btn-primary btn-sm">
                              <i class="fa fa-plus"></i>
                          </a>
                          <a onClick=\'return remove('.$item->id.', "'.$item->name.'")\' href="#" class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                          </a>

                      </td>
                  </tr>
                ' . (count($item->children) > 0 ? treeChildUnitKerja($item->children, $item) : '') ;
            }
        }

        return $html;

    }
}

if ( ! function_exists('treeChildUnitKerjaModal'))
{
    function treeChildUnitKerjaModal($data, $dataParent){

        $html = "";

        if (!empty($data)) {

            foreach ($data as $item) {

                $html .= '
                  <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '">
                  <td style="height: 10px !important;">
                      ' . $item->name . '
                  </td>
                  <td>
                      <a href="#" class="btn btn-success btn-sm" onclick=\'selectUnitKerja('.$item->id.',"'.$item->name.'");\'><i class="fa fa-check"></i> Pilih</a>
                  </td>
                  </tr>
                ' . (count($item->children) > 0 ? treeChildUnitKerjaModal($item->children, $item) : '') ;
            }
        }

        return $html;

    }
}

if ( ! function_exists('treeSelectIndikatorKinerja'))
{
    function treeSelectIndikatorKinerja($data, $dataParent, $selected_id=0){

        $html = "";
        if (!empty($data)) {
            foreach ($data as $item) {

                $html .= '<option value="'.$item->id.'"  '.($item->id ==  $selected_id? 'selected=selected' : '').'>'.$item->name.'</option>' . (count($item->children) > 0 ? treeSelectUnitKerja($item->children, $item, $selected_id) : '') ;
            }
        }

        return $html;

    }
}


if ( ! function_exists('treeChildIndikatorKinerja'))
{
    function treeChildIndikatorKinerja($data, $dataParent, $prefix, $incr){

        $html = "";
        if (!empty($data)) {
            foreach ($data as $key => $item) {

                $num = $key + 1;

                $html .= '
                  <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '" class="td-' . $item->status . '">
                      <td style="height: 10px !important;white-space: nowrap;">
                        '.(($prefix ? ($prefix .'.') : ''). $num).'
                      </td>
                      <td style="height: 10px !important;">
                          '.

                          ( !empty($item->perspektif_id) ?
                          '
                          <a href="#" class="tag tag-blue text-white">
                            '.($item->perspektif_id ? perspektif($item->perspektif_id) : '' ).'
                          </a>
                          <br />
                          ' : ''
                          )
                          .'

                          ' . $item->name . '
                      </td>
                      <td>
                          '. (!empty($item->unit_kerja->name) ? $item->unit_kerja->name : '') .'
                      </td>
                      <td>
                          <a href="'. url('/indikator_kinerja/'.$item->id) .'" class="btn btn-success btn-sm"><i class="fa fa-pencil"></i></a>
                          <a href="'. url('/indikator_kinerja/new/'.$item->id) .'" class="btn btn-primary btn-sm">
                              <i class="fa fa-plus"></i>
                          </a>
                          <a onClick=\'return remove('.$item->id.', "'.$item->name.'")\' href="#" class="btn btn-danger btn-sm">
                              <i class="fa fa-trash"></i>
                          </a>

                      </td>
                  </tr>
                ' . (count($item->children) > 0 ? treeChildIndikatorKinerja($item->children, $item,  (($prefix ? ($prefix .'.') : ''). $num), $num) : '') ;
            }
        }

        return $html;

    }
}



if ( ! function_exists('treeChildIndikatorKinerjaModal'))
{
    function treeChildIndikatorKinerjaModal($data, $dataParent, $prefix, $incr, $indikator_kerja_ids, $tipe_indikator_ditampilkan) {

        $html = "";

          // cetak($indikator_kerja_ids);
          // die();

          if (!empty($data)) {
              foreach ($data as $key => $item) {

                  $num = $key + 1;
                  if (in_array( $item->id ,$indikator_kerja_ids)) {
                  $html .= '
                    <tr data-node-id="' . $item->id . '" data-node-pid="' . (!empty($dataParent->id) ? $dataParent->id : 0) . '" >
                        <td style="height: 10px !important;white-space: nowrap;">
                          '.(($prefix ? ($prefix .'.') : ''). $num).'
                        </td>
                        <td style="height: 10px !important;">
                            ' . $item->name . '
                        </td>
                        <td>
                            '. (!empty($item->unit_kerja->name) ? $item->unit_kerja->name : '') .'
                        </td>
                        <td>' .
                            (in_array( $item->id ,$indikator_kerja_ids) && in_array($item->tipe_indikator, $tipe_indikator_ditampilkan) ? '<a href="#" onclick=\'return selectIndikatorKinerja(this, "' . $item->id  . '")\'  class="btn btn-success btn-sm"><i class="fa fa-check"></i> Pilih</a>' : '')
                        .'</td>
                    </tr>
                  ' . (count($item->children) > 0 ? treeChildIndikatorKinerjaModal($item->children, $item,  (($prefix ? ($prefix .'.') : ''). $num), $num, $indikator_kerja_ids, $tipe_indikator_ditampilkan) : '') ;
              }
          }
        }

        return $html;

    }
}
