
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <script src="js/photo-gallery.js"></script>
    <link href="css/detay.css" rel="stylesheet">
    <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

  

</script>



<?php  
include("connect.php");
ob_start();
session_start();

function Bildirim($mesaj,$id,$ad,$soyad) {

  $content = array(
        "en" => "Sn.".$ad." ".$soyad." ".$mesaj,

        );

    $fields = array(
        'app_id' => "8415730c-d374-4401-a21e-e0dc2ee06b9b",
        'include_player_ids' => array($id),
        'data' => array("foo" => "bar"),
        
        'contents' => $content
    );

    $fields = json_encode($fields);


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                               'Authorization: Basic YTBkOGE0N2YtZTgxNC00YjMyLWE1YzQtZWRlN2ZlYzQwMWNk'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

    $response = curl_exec($ch);
    curl_close($ch);
   
}





$id=$_GET['KID'];

$doktor = mysqli_query($con,"select * from login where id != 1 ") or die(mysql_error());

$sql = mysqli_query($con,"select ad,soyad,cinsiyet,d_tarih,tel,eposta,il,ilce,ekleme,durum,oneSignal,doktor_id,doktor_adi,doktor_soyadi from kayit,login where kayit.id = '".$id."' and doktor_id = login.id ") or die(mysqli_error($con));

$ilk = mysqli_fetch_assoc($sql);
if($ilk["doktor_adi"] == ""){
   $sql = mysqli_query($con,"select ad,soyad,cinsiyet,d_tarih,tel,eposta,il,ilce,ekleme,durum,oneSignal,doktor_id from kayit where kayit.id = '".$id."' ") or die(mysql_error());
   $ilk = mysqli_fetch_assoc($sql);
}
else{

}
 $sql_check = mysqli_query($con,"select foto1,foto2,foto3,foto4,foto5,tarih,user_id from fotograflar where user_id = '".$id."' ") or die(mysql_error());
   
   setlocale(LC_ALL, 'turkish');
    

   $d_tarih = iconv('latin5', 'utf-8', strftime('%e %B %Y',strtotime($ilk['d_tarih'])));

    
   ?>


    <div class="container">    
        <div class="row" style=" border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:10px;">
            <h3 style="text-align:center;font-family:arial; font-weight:bold; font-size:30px; color:#1e73be">
              <?php  echo $ilk["ad"].' '.$ilk["soyad"]; ?>
        </h3>
        <button onclick="location.href='admin.php'"  class="btn">Ana Sayfa</button>
        </div>
        <div class="row" style="border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:10px;">
        <h3 style="font-family:arial;font-size:20px; color:#1e73be">
              <?php echo '<b> Cinsiyet : </b>'.$ilk["cinsiyet"]."<br><br>". '<b> Doğum Tarihi :</b> '.$d_tarih."<br><br>".'<b> Telefon :</b> '.$ilk["tel"]."<br><br>".'<b> E-posta :</b> '.$ilk["eposta"]."<br><br>".'<b> İl :</b> '.$ilk["il"]."<br><br>".'<b> İlçe :</b> '.$ilk["ilce"]."<br><br>".'<b> Eklediği :</b> '.$ilk["ekleme"].'<br><br>';


                ?>
      <?php if($_SESSION["id"] == 1){   ?>   
                <form method="POST" action="<?php echo "detay.php?KID=$id"; ?>">
                <?php
                echo "<b>Durum :</b> ";   
                if($ilk["durum"] == NULL){?>
                               <font color="#fcc500"><?php echo " (Onay bekliyor)";?> </font>
                              <?php
               }
               
               elseif($ilk["durum"] == 1){
               ?>
                               <font color="#00ff00"><?php echo " (Onaylandı)";?> </font>
                              <?php
               }
               else{
                ?>
                               <font color="#ff0000"><?php echo " (Onaylanmadı)";?> </font>
                              <?php
               }
                
                ?>
                <select name="onay">
                    <option value="1" selected="selected">Onay</option>
                    <option value="0">Ret</option>
                </select>
                  
                  <button type="submit" name="Sec" class="btn" style="margin-bottom: 3px;">Seç</button>
                </form>
                
                

               <?php
              
               ?>
               <?php
               

              if(isset($_POST['onay'])){

                


                if($_POST['onay'] == 1){
                  $update = mysqli_query($con,"UPDATE kayit SET durum = 1 WHERE id = '".$id."'");

                 while($son["durum"] == NULL){ 
                  $sql2 = mysqli_query($con,"select durum from kayit where id = '".$id."' ") or die(mysqli_error($con,));
                  $son = mysqli_fetch_assoc($sql2);
                }
                if($son["durum"] != NULL){
                  header("Refresh:0; url=");
                }
                }
                else{
                  $update = mysqli_query($con,"UPDATE kayit SET durum = 0 WHERE id = '".$id."'");
                 while($son["durum"] == NULL){ 
                  $sql2 = mysqli_query($con,"select durum from kayit where id = '".$id."' ") or die(mysqli_error($con));
                  $son = mysqli_fetch_assoc($sql2);
                }
                if($son["durum"] != NULL){
                  header("Refresh:0; url=");
                }
                }


               if($_POST['onay'] == 1){

                Bildirim("başvurunuz onaylandı.",$ilk["oneSignal"],$ilk["ad"],$ilk["soyad"]);
               }
               else{
                  Bildirim("başvurunuz onaylanmadı.",$ilk["oneSignal"],$ilk["ad"],$ilk["soyad"]);
               }
                  
              }
              
              ?>
               

              <form method="POST" action="<?php echo "detay.php?KID=$id"; ?>">
                <?php echo "<b>Doktor :</b> "; 
                  if($ilk["doktor_id"] == 0){
                    echo "Doktor Atanmamış ";
                  }
                  else{
                    echo $ilk["doktor_adi"].' '.$ilk["doktor_soyadi"];
                  }

                ?>
                <select name="doktor" id="doktor">
                
                  
                  <?php  while($d_goster = mysqli_fetch_assoc($doktor)){ ?>,
                 <?php if($ilk["doktor_id"] != $d_goster["id"]){ ?>
                    <option value="<?php echo $d_goster["id"]; ?>"><?php echo $d_goster["doktor_adi"].' '.$d_goster["doktor_soyadi"]; ?></option>
                 <?php }
                   }
                ?>
                </select>
                <button type="submit" name="y_doktor" class="btn" style="margin-bottom: 3px;">Seç</button>
              </form>
              <?php
              
              if(isset($_POST['doktor'])){
                if($ilk["doktor_id"] == NULL){
                    Bildirim("Doktorunuz atandı.",$ilk["oneSignal"],$ilk["ad"],$ilk["soyad"]);
                  }
                  else{
                    Bildirim("doktorunuz değişti.",$ilk["oneSignal"],$ilk["ad"],$ilk["soyad"]);
                  }
                
                  $update = mysqli_query($con,"UPDATE kayit SET doktor_id = ".$_POST['doktor']. " WHERE id = '".$id."'");
                 while($son["doktor_id"] != $_POST['doktor']){ 
                  $sql2 = mysqli_query($con,"select doktor_id from kayit where id = '".$id."' ") or die(mysqli_error($con));
                  $son = mysqli_fetch_assoc($sql2);
                }
                
                  header("Refresh:0; url=");
                
              }
              ?>
                  
         <?php }   ?>   
        </h3>
        </div>

  <?php while($yaz = mysqli_fetch_assoc($sql_check)){

    $tarih = iconv('latin5', 'utf-8', strftime('%e %B %Y',strtotime($yaz['tarih']))); 
    ?>
        <div class="row" style="border-bottom:1px dashed #ccc;  padding:0 0 20px 0; margin-bottom:40px;">
            <h3 style="font-family:arial; font-weight:bold; font-size:20px;color:#1e73be ">
                <?php echo $tarih; ?>
                </h3>
          
        <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <img class="img-responsive" src="<?php echo $yaz["foto1"]; ?>">
            </li>
            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <img class="img-responsive" src="<?php echo $yaz["foto2"]; ?>">
            </li>
            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <img class="img-responsive" src="<?php echo $yaz["foto3"]; ?>">
            </li>
            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <img class="img-responsive" src="<?php echo $yaz["foto4"]; ?>">
            </li>
            <li class="col-lg-2 col-md-2 col-sm-3 col-xs-4">
                <img class="img-responsive" src="<?php echo $yaz["foto5"]; ?>">
            </li>
        </div>
      
<?php } ?>
    </div> <!-- /container -->
    
     
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">         
          <div class="modal-body">                
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
  


  

<?php ob_end_flush();


?>
