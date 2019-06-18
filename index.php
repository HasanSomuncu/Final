<!DOCTYPE html>

<html lang="tr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/proje.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
      <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

      <script src="https://use.typekit.net/ayg4pcz.js"></script>
    <script>try{Typekit.load({ async: true });}catch(e){}</script>

    <div class="container">
    <h1 class="welcome text-center">Hoş Geldiniz <br> Tooth</h1>
        <div class="card card-container">
        <h2 class='login_title text-center'>Giriş</h2>
        <hr>
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

if(isset($_POST['username']) and isset($_POST['password'])) { 
    
$kadi = sec($_POST['username']);
$sifre = ($_POST['password']);

$sql_check = mysqli_query($con,"select * from login where username='".$kadi."' and password='".$sifre."' ") or die(mysqli_error($con));

if(mysqli_num_rows($sql_check))  {
    $_SESSION["login"] = "true";
    $_SESSION["user"] = $kadi;
    $_SESSION["pass"] = $sifre;
    $row = mysqli_fetch_array($sql_check);
    $_SESSION["id"] = $row["id"];
    header("Location:admin.php");
}
else {
    if($kadi=="" or $sifre=="") {
        /*echo "<center>Lutfen kullanici adi ya da sifreyi bos birakmayiniz..! <a href=javascript:history.back(-1)>Geri Don</a></center>";*/
    }
    else {
        echo "<center>Kullanici Adi/Sifre Yanlis.<br></center>";
    }
}
 
ob_end_flush();
}

?>



            <form class="form-signin" method="POST">
                <span id="reauth-email" class="reauth-email"></span>
                <p class="input_title">Kullanıcı Adı</p>
                <input type="text" id="inputEmail" name="username" class="login_box" placeholder="Kullanıcı Adınızı Giriniz" required autofocus>
                <p class="input_title">Şifre</p>
                <input type="password" id="password" name="password" class="login_box" placeholder="******" required>
                <div id="remember" class="checkbox">
                    <label>
                        
                    </label>
                </div>
                <button class="btn btn-lg btn-primary" id="btn" type="submit">Giriş</button>
            </form><!-- /form -->
        </div><!-- /card-container -->
    </div><!-- /container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   
  </body>

  
</html>