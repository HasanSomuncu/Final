

<?php

header('Access-Control-Allow-Origin: *');
             header("Access-Control-Allow-Credentials: true"); 
             header('Access-Control-Allow-Headers: X-Requested-With');
             header('Access-Control-Allow-Headers: Content-Type');
             header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT'); // http://stackoverflow.com/a/7605119/578667
          
             header('Cache-Control: public, max-age=180'); 
 
$servername = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($servername, $username, $password) or die ("Could not connect: " . mysql_error());;
mysqli_select_db($con,'clearfix');

mysqli_query($con,"SET NAMES 'utf8'"); 
mysqli_query($con,"SET CHARACTER SET utf8"); 
mysqli_query($con,"SET COLLATION_CONNECTION = 'utf8_turkish_ci'");  
header('Content-type: text/html; charset=UTF-8');

$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    //$id = $request->id;
   $id = 1;

    



$sql = mysqli_query($con,"select ad,soyad,d_tarih,foto1,foto2,foto3,foto4,foto5,tarih,user_id,doktor_adi,doktor_soyadi from kayit,login,fotograflar where kayit.id = user_id and user_id = '".$id."' and doktor_id = login.id ") or die(mysqli_error($con));
$veri = mysqli_fetch_assoc($sql);
if($veri["doktor_adi"] == ""){
   $sql = mysqli_query($con,"select ad,soyad,d_tarih,foto1,foto2,foto3,foto4,foto5,tarih,user_id from kayit,fotograflar where kayit.id = user_id and user_id = '".$id."'") or die(mysqli_error($con));
   
   $satir=mysqli_num_rows($sql);
$say=1;
echo "[";
while($veri = mysqli_fetch_assoc($sql)){



$kullanici_ad = $veri['ad'];
$kullanici_soyad = $veri['soyad'];

$kullanici_d_tarih = strftime('%e %B %Y',strtotime($veri['d_tarih']));


$kullanici_user_id = $veri['user_id'];
$kullanici_foto1 = str_replace(array("\n", "\r"), '', $veri['foto1']);
$kullanici_foto2 = str_replace(array("\n", "\r"), '', $veri['foto2']);
$kullanici_foto3 = str_replace(array("\n", "\r"), '', $veri['foto3']);
$kullanici_foto4 = str_replace(array("\n", "\r"), '', $veri['foto4']);
$kullanici_foto5 = str_replace(array("\n", "\r"), '', $veri['foto5']);

if($say<$satir){
$virgul=",";
}else{
$virgul="";
}
echo  '{';
        echo '"ad":"'.$kullanici_ad.'",';
        echo '"soyad":"'.$kullanici_soyad.'",';
        echo '"tarih":"'.$veri['tarih'].'",';
        echo '"user_id":"'.$kullanici_user_id.'",';
        echo '"d_tarih":"'.$kullanici_d_tarih.'",';
        echo '"foto1":"'.$kullanici_foto1.'",';
        echo '"foto2":"'.$kullanici_foto2.'",';
        echo '"foto3":"'.$kullanici_foto3.'",';
        echo '"foto4":"'.$kullanici_foto4.'",';
        echo '"foto5":"'.$kullanici_foto5 .'"';

    echo  '}'.$virgul;
  //echo "{id:".$firma_id.",firma_ismi:'".$firma_adi.",kategori:'".$firma_kategori."',tel:'".$firma_tel."',logo:'".$firma_logo."'}".$virgul;
 

$say=$say+1;
}

// çekilen kayıtlar değişkenlere atanacak Döngü ile dönderilecek


echo "]";
}else{
$sql = mysqli_query($con,"select ad,soyad,d_tarih,foto1,foto2,foto3,foto4,foto5,tarih,user_id,doktor_adi,doktor_soyadi,durum from kayit,login,fotograflar where kayit.id = user_id and user_id = '".$id."' and doktor_id = login.id ") or die(mysqli_error($con));    
$satir=mysqli_num_rows($sql);
$say=1;
echo "[";

while($veri = mysqli_fetch_assoc($sql)){

setlocale(LC_ALL, 'turkish');

$kullanici_ad = $veri['ad'];
$kullanici_soyad = $veri['soyad'];
$veri['d_tarih'] = iconv('latin5','utf-8',strftime('%d %B %Y'));
$veri['tarih'] = iconv('latin5','utf-8',strftime('%d %B %Y'));
$kullanici_user_id = $veri['user_id'];
$kullanici_durum = $veri['durum'];
$kullanici_doktor_adi = $veri['doktor_adi'];
$kullanici_doktor_soyadi = $veri['doktor_soyadi'];
$kullanici_foto1 = str_replace(array("\n", "\r"), '', $veri['foto1']);
$kullanici_foto2 = str_replace(array("\n", "\r"), '', $veri['foto2']);
$kullanici_foto3 = str_replace(array("\n", "\r"), '', $veri['foto3']);
$kullanici_foto4 = str_replace(array("\n", "\r"), '', $veri['foto4']);
$kullanici_foto5 = str_replace(array("\n", "\r"), '', $veri['foto5']);

if($say<$satir){
$virgul=",";
}else{
$virgul="";
}
echo  '{';
        echo '"ad":"'.$kullanici_ad.'",';
        echo '"soyad":"'.$kullanici_soyad.'",';
        echo '"tarih":"'.$veri['tarih'].'",';
        echo '"user_id":"'.$kullanici_user_id.'",';
        echo '"d_tarih":"'.$veri['d_tarih'].'",';
        echo '"durum":"'.$kullanici_durum.'",';
        echo '"doktor_adi":"'.$kullanici_doktor_adi.'",';
        echo '"doktor_soyadi":"'.$kullanici_doktor_soyadi.'",';
        echo '"foto1":"'.$kullanici_foto1.'",';
        echo '"foto2":"'.$kullanici_foto2.'",';
        echo '"foto3":"'.$kullanici_foto3.'",';
        echo '"foto4":"'.$kullanici_foto4.'",';
        echo '"foto5":"'.$kullanici_foto5 .'"';

    echo  '}'.$virgul;
  //echo "{id:".$firma_id.",firma_ismi:'".$firma_adi.",kategori:'".$firma_kategori."',tel:'".$firma_tel."',logo:'".$firma_logo."'}".$virgul;
 

$say=$say+1;
}

// çekilen kayıtlar değişkenlere atanacak Döngü ile dönderilecek


echo "]";

}



?>