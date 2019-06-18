<?php 
include("connect.php");
ob_start();
session_start();

function sec($ara) {
$ara = addslashes($ara);
$ara = htmlspecialchars($ara);
$ara = strip_tags($ara);
return $ara;
}
                    
$value = sec($_POST['value']);
if($_SESSION["id"] == 1){
$sql_check = mysqli_query($con,"select * from kayit where ad like '%".$value."%' or soyad like '%".$value."%' order by id desc" ) or die(mysql_error());
}
else{
	$sql_check = mysqli_query($con,"select * from kayit where doktor_id =".' '.$_SESSION["id"]." and (ad like '%".$value."%' or soyad like '%".$value."%') order by ad" ) or die(mysqli_error($con));
}
?>
<?php while($yaz = mysqli_fetch_assoc($sql_check)){?>
                    
                  <?php  $d_tarih = strftime('%e %B %Y',strtotime($yaz['d_tarih'])); ?>
                  
                   <ul class="mail-list">

                       <li>
                       <hr> 
                           <?php $id = $yaz["id"]; ?>
                           <a  href="<?php echo "detay.php?KID=$id"; ?>">
                               <span class="mail-sender"><font color="#1e73be"><?php echo $yaz["ad"].' '.$yaz["soyad"];?></font><?php
                               if($_SESSION["id"] == 1){
                               if($yaz["durum"] == NULL){?>
                               <font color="#fcc500"><?php echo " (Onay bekliyor)";?> </font>
                              <?php }
                               elseif($yaz["durum"] == 1){
                                ?>
                               <font color="#00ff00"><?php echo " (Onaylandı)";?> </font>
                              <?php
                               }
                               else{
                                ?>
                               <font color="#ff0000"><?php echo " (Onaylanmadı)";?> </font>
                              <?php
                               }
                             }

                               ?></span>
                              
                               <span class="mail-subject"><?php echo 'Cinsiyet : '.$yaz["cinsiyet"]. ' Doğum Tarihi : '.$d_tarih.' Telefon : '.$yaz["tel"].' E-posta : '.$yaz["eposta"].' İl : '.$yaz["il"].' İlçe : '.$yaz["ilce"] ; ?>

                               </span>
                               
                           </a>
                           </hr> 
                       </li>
                       
                       
                   </ul>
               
<?php } ?>


                    