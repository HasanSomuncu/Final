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
$con = mysqli_connect($servername, $username, $password) or die ("Could not connect: " . mysql_error());;
mysqli_select_db($con,'clearfix');

mysqli_query($con,"SET NAMES 'utf8'"); 
mysqli_query($con,"SET CHARACTER SET utf8"); 
mysqli_query($con,"SET COLLATION_CONNECTION = 'utf8_turkish_ci'");  
header('Content-type: text/html; charset=UTF-8');

$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $eposta = sec($request->eposta);
    $d_tarih = sec($request->d_tarih);



$sql = @mysqli_query($con,"select * from kayit where eposta='".$eposta."' and d_tarih='".$d_tarih."' ");
if(mysqli_num_rows($sql)){
    while( $row = mysqli_fetch_array( $sql ) ) {
      echo $row['id'];
   }
   
}
else{
    
}



?>