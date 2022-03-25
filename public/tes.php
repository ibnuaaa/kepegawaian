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
       echo "X-signature: <input type='text' value='".$encodedSignature."' style='width:600px;'>" ;
    ?>
