<?php

// UPDATE `x_user` SET golongan_id='18' WHERE pangkat_gol='Non PNS'
// UPDATE `x_user` SET golongan_id='19' WHERE pangkat_gol='Kontrak Kerjasama'

$link = mysqli_connect("localhost", "root", "rspon2014", "kepegawaian"); 
$result = mysqli_query($link, "
    SELECT * FROM x_user 
    
");

while ($row=mysqli_fetch_assoc($result))
{
    // if($row['pangkat_gol']) {
    //     $pangkat_gol_x = explode(' ', $row['pangkat_gol']);
    //     $gol = str_replace('/','-',$pangkat_gol_x[count($pangkat_gol_x) -1 ]);

    //     $result2 = mysqli_query($link, "SELECT * FROM golongan where golongan='".$gol."'");
    //     $row2=mysqli_fetch_assoc($result2);

    //     if (!empty($row2['id'])) {
    //         mysqli_query($link, "update x_user set golongan_id='".$row2['id']."' where id='".$row['id']."'");   
    //     }

    // }

    // if($row['id'] == '5') {
    // if($row['unit_kerja']) {
    //     $unit_kerja_lama = str_replace('Kelompok Sub-substansi','Subkoordinator',$row['unit_kerja']);
    //     $unit_kerja_lama = str_replace('Kelompok Substansi','Koordinator',$unit_kerja_lama);

    //     $aaa = "update x_user set unit_kerja_lama='".$unit_kerja_lama."' where id='".$row['id']."'";
    //     mysqli_query($link, $aaa); 


    //     $result2 = mysqli_query($link, "SELECT * FROM unit_kerja where name='".$unit_kerja_lama."'");
    //     $row2=mysqli_fetch_assoc($result2);

    //     if (!empty($row2['id'])) {
    //         mysqli_query($link, "update x_user set unit_kerja_id='".$row2['id']."' where id='".$row['id']."'");   
    //     }

    // }
    // }


    $nip = $row['nip'];
    $nip = str_replace(' ','', $nip);

    $result2 = mysqli_query($link, "SELECT * FROM users where nip='".$nip."'");
    $row2=mysqli_fetch_assoc($result2);
        
    $pass = '$argon2id$v=19$m=1024,t=2,p=2$cjJ0TWhWRjR6ZUxBWVdSTA$ejlomlUBZaNGsaMuYA7AVYqz0YMiE9+X8IQrKuD+Ik0';
        


    if(!empty($row2['nip'])) {
        // if ($nip == '198202232015031001') {
            $jabatan_id = '56';
            if (!empty($row2['jabatan_id'])) { // users
                $jabatan_id = $row2['jabatan_id'];
            }
            // cetak($jabatan_id);

            // echo 
            $sqll = "update users set name='".$row['nama']."',
            golongan_id='".$row['golongan_id']."',
            unit_kerja_id='".$row['unit_kerja_id']."',
            jabatan_id='".$jabatan_id."'        
            where nip='".$nip."'";
            // die();
            mysqli_query($link, $sqll); 
        // }
    } else {

        // if (!empty($nip)) {
            // echo 
            $sqll = "insert into users(name,username,nip,password,golongan_id,unit_kerja_id,jabatan_id,position_id) 
                values
                ('".$row['nama']."','".$nip."','".$nip."','".$pass."','".$row['golongan_id']."','".$row['unit_kerja_id']."','56','6')
            ";
            mysqli_query($link, $sqll); 
        // }


        
    }
            // die();

}




    function cetak($string)
    {
        echo "<pre>";
        print_r($string);
        echo "</pre>";
    }

?>
