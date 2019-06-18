<link href="css/deneme.css" rel="stylesheet">
<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript"> 


  
    $(function(){
    
      var konu   = "value="+"";
       
       $.ajax({
         
         type: "POST",
               url: "arama.php",
               data: konu,
               success: function(sonuc){
           
              $("#sonuc").html(sonuc);
           
         }  
         
         
       });
     
     
     $("input[name=ara]").keyup(function(){
       
       var value  = $(this).val();
       
       var konu   = "value="+value;
       
       $.ajax({
         
         type: "POST",
               url: "arama.php",
               data: konu,
               success: function(sonuc){
           
              $("#sonuc").html(sonuc);
           
         }  
         
         
       });
       
       
       
     });
     
     
    
    
  });
  
  
  </script> 
<?php 
 
include("connect.php");
ob_start();
session_start();

?>
 <div class="container">
           <div class="content-container clearfix">
               <div class="col-md-12">
                   <h1 class="content-title" ><font color="#1e73be"><b>Gelen Kayıtlar</b></font></h1>
                   
                   <input type="text" name="ara" placeholder="Arama" class="form-control mail-search" />
                   <button class="btn" style="margin-left: 80%" onclick="location.href='logout.php'"> Çıkış </button>
                 <div id="sonuc">
                
     
                 </div>
   

 </div>
           </div>
           </div>
<?php ob_end_flush();


?>