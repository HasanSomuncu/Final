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
$con = mysqli_connect($servername, $username, $password) or die ("Could not connect: " . mysqli_error());;
mysqli_select_db( $con,'clearfix');


mysqli_query($con,"SET NAMES 'utf8'"); 
mysqli_query($con,"SET CHARACTER SET utf8"); 
mysqli_query($con,"SET COLLATION_CONNECTION = 'utf8_turkish_ci'");  
header('Content-type: text/html; charset=UTF-8');

$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
    $user_id = $request->user_id;
    
    $foto1 = $request ->foto1;
    $foto2 = $request ->foto2;
    $foto3 = $request ->foto3;
    $foto4 = $request ->foto4;
    $foto5 = $request ->foto5;


  date_default_timezone_set('Europe/Istanbul');
    $tarih =  date("Y-m-d h:i:s");


$sql = @mysqli_query($con,"INSERT INTO fotograflar (user_id,foto1,foto2,foto3,foto4,foto5,tarih) VALUES ('$user_id','$foto1','$foto2','$foto3','$foto4','$foto5','$tarih')");



?>