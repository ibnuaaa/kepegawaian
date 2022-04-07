DEVELOP<br>
<?php
       $data = "29946";
       $secretKey = "rsotak211016nas21jkt";
             // Computes the timestamp
              date_default_timezone_set('UTC');
              $tStamp = strval(time()-strtotime('1970-01-01 00:00:00'));
               // Computes the signature by hashing the salt with the secret key as the key
       $signature = hash_hmac('sha256', $data."&".$tStamp, $secretKey, true);

       // base64 encode�
       $encodedSignature = base64_encode($signature);

       // urlencode�
       // $encodedSignature = urlencode($encodedSignature);

       echo "X-cons-id: " .$data ."<br>";
       echo "X-timestamp:" .$tStamp ."<br>";
       echo "X-signature: <input type='text' value='".$encodedSignature."' style='width:1000px;'>" ;
    ?>
<br><br><br>
PROD<br>
<?php

       $uid = "29946";
		$timestmp = time();
		//=== menggunakan timestamp dari BPJS === //
		// $uri = $this->uri;
		// $completeurl = "$uri/ReferensiRest/sample/getTime";
		// $xml = simplexml_load_file($completeurl);
		// $strtimeserverbpjs = $xml->response;
		// $arrtimestamp = explode(" | ",$strtimeserverbpjs);
		// $timestmp = $arrtimestamp[0];
		//========eof===//
		// $str = $data."&".$uid."&".$timestmp;
		$str = $uid."&".$timestmp;
		$secret = 'rs445otak998nas21jkt';
		$hasher = base64_encode(hash_hmac('sha256', utf8_encode($str), utf8_encode($secret), TRUE)); //signature;

       echo "X-cons-id: " .$uid ."<br>";
       echo "X-timestamp:" .$timestmp ."<br>";
       echo "X-signature: <input type='text' value='".$hasher."' style='width:600px;'>" ;
    ?>
