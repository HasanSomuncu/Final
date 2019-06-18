<?php

function sec($veri) {
$veri = addslashes($veri);
$veri = htmlspecialchars($veri);
$veri = strip_tags($veri);
return $veri;
}

header('Access-Control-Allow-Origin: *');
             header("Access-Control-Allow-Credentials: true"); 
             header('Access-Control-Allow-Headers: X-Requested-With');
             header('Access-Control-Allow-Headers: Content-Type');
             header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT'); // http://stackoverflow.com/a/7605119/578667
          
             header('Cache-Control: public, max-age=180'); 
 
$servername = "localhost";
$username = "root";
$password = "";
$con = mysqli_connect($servername, $username, $password) or die ("Could not connect: " . mysqli_error($con));;
mysqli_select_db($con,'clearfix');

mysqli_query($con,"SET NAMES 'utf8'"); 
mysqli_query($con,"SET CHARACTER SET utf8"); 
mysqli_query($con,"SET COLLATION_CONNECTION = 'utf8_turkish_ci'");  
header('Content-type: text/html; charset=UTF-8');

$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $ad = sec($request->ad);
    $soyad = sec($request->soyad);
    $email = sec($request->email);
    $tel = sec($request->tel);
    $d_tarih = $request->d_tarih;
    $cinsiyet = sec($request->cinsiyet);
    $il = sec($request->il);
    $ilce = sec($request->ilce);
    $ek = sec($request->ek);
    $oneSignal = $request->oneSignal;
    $foto1 = $request ->foto1;
    $foto2 = $request ->foto2;
    $foto3 = $request ->foto3;
    $foto4 = $request ->foto4;
    $foto5 = $request ->foto5;

  date_default_timezone_set('Europe/Istanbul');
    $tarih =  date("Y-m-d h:i:s");


$sql = @mysqli_query($con,"INSERT INTO kayit (ad,soyad,eposta,tel,d_tarih,cinsiyet,il,ilce,ekleme,oneSignal) VALUES ( '$ad','$soyad','$email','$tel','$d_tarih','$cinsiyet','$il','$ilce','$ek','$oneSignal')");
$id = mysqli_insert_id($con);
$sql2 = @mysqli_query($con,"INSERT INTO fotograflar (user_id,foto1,foto2,foto3,foto4,foto5,tarih) VALUES ( '$id','$foto1','$foto2','$foto3','$foto4','$foto5','$tarih')");

echo ($id);

?>