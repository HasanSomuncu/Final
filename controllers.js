angular.module('starter.controllers', ['ngCordova'])



.controller('AppCtrl', function($scope, $ionicModal, $state,$http,$cordovaDialogs,$rootScope) {





$scope.eposta = localStorage.getItem('eposta');
$scope.d_tarih_local = localStorage.getItem('d_tarih');
$scope.login= {};  
$scope.bilgi = [];
$scope.imgURI = [];


$ionicModal.fromTemplateUrl('templates/giris.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.giris = modal;
  });



  $scope.gir = function() {
    

    if(localStorage.getItem('eposta')){

      $http({
        url: "http://192.168.43.105/dashboard/giris.php",
        method: "POST",
        data: {
            'eposta': $scope.eposta,
            'd_tarih': $scope.d_tarih_local
            
        }
    }).success(function(response) {
        
        if(response){
            $rootScope.id = response;

            $state.go('app.profil');
            $scope.giris.hide();
        }
        else{

          $cordovaDialogs.alert('Böyle bir kullanıcı bulunmamaktadır.', 'Clearfix', 'Tamam')
                  .then(function() {
     
                });
          $state.go('app.anasayfa');
          localStorage.removeItem('eposta');
          localStorage.removeItem('d_tarih');

        }
    }).error(function(response) {
        
    });

    }
    else{
      $scope.giris.show();
    }
  };

  $scope.kapat = function() {
    $scope.giris.hide();
  };


  $scope.login = function(){

    $scope.d_tarih1 = $scope.login.d_tarih.substring(0,2);
    $scope.d_tarih2 = $scope.login.d_tarih.substring(2,4);
    $scope.d_tarih3 = $scope.login.d_tarih.substring(4,8);
    $scope.d_tarih = $scope.d_tarih3 +"-"+ $scope.d_tarih2 +"-"+ $scope.d_tarih1;

    

    localStorage.setItem('eposta',$scope.login.eposta);
    localStorage.setItem('d_tarih',$scope.d_tarih);
    $scope.eposta = localStorage.getItem('eposta');
    $scope.d_tarih_local = localStorage.getItem('d_tarih');
    


      $http({
        url: "http://192.168.43.105/dashboard/giris.php",
        method: "POST",
        data: {
            'eposta': $scope.login.eposta,
            'd_tarih':$scope.d_tarih
            
        }
    }).success(function(response) {
        
        if(response){
            $rootScope.id = response;

            $state.go('app.profil');
            $scope.giris.hide();
        }
        else{

          $cordovaDialogs.alert('Böyle bir kullanıcı bulunmamaktadır.', 'Clearfix', 'Tamam')
                  .then(function() {
     
                });


        }
    }).error(function(response) {
        
    });

  };



$ionicModal.fromTemplateUrl('templates/bilgilendirme.html', {
    scope: $scope
  }).then(function(modal) {
    $scope.gonder = modal;
  });

  $scope.closeGonder = function() {
    $scope.gonder.hide();
  };

})

  
.controller('ProfilCtrl', function($scope,$rootScope,$http,$ionicLoading,$state,$timeout) {
          $rootScope.kullanici = {};
          

          $ionicLoading.show({
          template: '<ion-spinner icon="lines" class="spinner-calm"></ion-spinner>'
           });

            $http({
              url: "http://192.168.43.105/dashboard/profil.php",
              method: "POST",
              data: {
                  'id': $rootScope.id
             }
          }).success(function(response) {
              console.log(response);
              if(response){
                $rootScope.kullanici = response;
                if($rootScope.kullanici[0].doktor_adi){
                  $scope.doktor = $rootScope.kullanici[0].doktor_adi +" "+ $rootScope.kullanici[0].doktor_soyadi;
                }
                else{
                  $scope.doktor = "Henüz Atanmamış";
                }

                if($rootScope.kullanici[0].durum == ""){
                  $scope.durum = "(Onay Bekleniyor)"
                }
                else if($rootScope.kullanici[0].durum == 1){
                  $scope.durum = "(Onaylandı)"
                }
                else{
                  $scope.durum = "(Onaylanmadı)"
                }

                $ionicLoading.hide();
                
              }
              else{

                

              }
          }).error(function(response) {
              
          });

          $scope.cikis = function(){
              localStorage.removeItem('eposta');
              localStorage.removeItem('d_tarih');
              $scope.login.eposta = null;
              $scope.login.d_tarih = null;
              $state.go('app.anasayfa');
          };

          $scope.yenile = function(){

            
      
      $http({
              url: "http://192.168.43.105/dashboard/profil.php",
              method: "POST",
              data: {
                  'id': $rootScope.id
             }
          }).success(function(response) {
              
              if(response){
                $rootScope.kullanici = response;
                if($rootScope.kullanici[0].doktor_adi){
                  $scope.doktor = $rootScope.kullanici[0].doktor_adi +" "+ $rootScope.kullanici[0].doktor_soyadi;
                }
                else{
                  $scope.doktor = "Henüz Atanmamış";
                }

                if($rootScope.kullanici[0].durum == ""){
                  $scope.durum = "(Onay Bekleniyor)"
                }
                else if($rootScope.kullanici[0].durum == 1){
                  $scope.durum = "(Onaylandı)"
                }
                else{
                  $scope.durum = "(Onaylanmadı)"
                }
                
                $scope.$broadcast('scroll.refreshComplete');
              }
              else{

                

              }
          }).error(function(response) {
              
          });

      //Stop the ion-refresher from spinning
      
    
    

            

          };

  
})

.controller('ProfilDetayCtrl', function($scope,$rootScope,$stateParams) {
  $scope.tarih=$rootScope.kullanici[$stateParams.profilDetayId].tarih;
  $scope.foto1=$rootScope.kullanici[$stateParams.profilDetayId].foto1;
  $scope.foto2=$rootScope.kullanici[$stateParams.profilDetayId].foto2;
  $scope.foto3=$rootScope.kullanici[$stateParams.profilDetayId].foto3;
  $scope.foto4=$rootScope.kullanici[$stateParams.profilDetayId].foto4;
  $scope.foto5=$rootScope.kullanici[$stateParams.profilDetayId].foto5;

  })

.controller('VideoCtrl', function($scope) {
   
   

  })

.controller('FotoEkleCtrl', function($scope,$rootScope,$state,$http,$cordovaCamera,$cordovaDialogs) {
 
  $scope.takePhoto = function (id) {
                  var options = {
                    quality: 75,
                    destinationType: Camera.DestinationType.DATA_URL,
                    sourceType: Camera.PictureSourceType.CAMERA,
                    allowEdit: true,
                    encodingType: Camera.EncodingType.JPEG,
                    targetWidth: 600,
                    targetHeight: 600,
                    cameraDirection: 1,
                    popoverOptions: CameraPopoverOptions,
                    saveToPhotoAlbum: false
                };
   
                    $cordovaCamera.getPicture(options).then(function (imageData) {
                        $scope.imgURI[id]="data:image/jpeg;base64," + imageData;
                    }, function (err) {
                        
                    });
                };

  $scope.ekle = function(){
  if(!$scope.imgURI[0] && !$scope.imgURI[1] && !$scope.imgURI[2] && !$scope.imgURI[3] && !$scope.imgURI[4] && !$scope.imgURI[5]){
    
    $cordovaDialogs.alert('Lütfen tüm fotoğraf alanlarını doldurunuz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });

  }
  else{

    $http({
        url: "http://192.168.43.105/dashboard/foto_ekle.php",
        method: "POST",
        data: {
            'user_id': $rootScope.kullanici[0].user_id,
            'foto1': $scope.imgURI[0],
            'foto2': $scope.imgURI[1],
            'foto3': $scope.imgURI[2],
            'foto4': $scope.imgURI[3],
            'foto5': $scope.imgURI[4]
        }
    }).success(function(response) {
      $cordovaDialogs.alert('Fotoğraflarınız gönderilmiştir.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
        
    }).error(function(response) {
       
    });

  
    
    $state.go('app.profil');
}
  };

})

.controller('FotoCtrl', function($filter,$scope,$http,$cordovaCamera,$cordovaDialogs,$state,$rootScope) {


$scope.kontrol = function(){
 


  if(!$scope.bilgi.ad){
    $cordovaDialogs.alert('Lütfen adınızı giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else if(!$scope.bilgi.soyad){
     $cordovaDialogs.alert('Lütfen soyadınızı giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });

  }
  else if(!$scope.bilgi.email){
    $cordovaDialogs.alert('Lütfen e-postanızı giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });

  }

  else if(!$scope.bilgi.tel){
    $cordovaDialogs.alert('Lütfen telefonunuzu giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else if(!$scope.bilgi.d_tarih){
    $cordovaDialogs.alert('Lütfen doğum tarihinizi giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else if(!$scope.bilgi.cinsiyet){
    $cordovaDialogs.alert('Lütfen cinsiyetinizi seçiniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else if(!$scope.bilgi.il){
    $cordovaDialogs.alert('Lütfen ilinizi giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else if(!$scope.bilgi.ilce){
    $cordovaDialogs.alert('Lütfen ilçenizi giriniz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else{
   
    $state.go('app.foto');
  }
  



  
};
  
  

$scope.takePhoto = function (id) {
                  var options = {
                    quality: 75,
                    destinationType: Camera.DestinationType.DATA_URL,
                    sourceType: Camera.PictureSourceType.CAMERA,
                    allowEdit: true,
                    encodingType: Camera.EncodingType.JPEG,
                    targetWidth: 600,
                    targetHeight: 600,
                    cameraDirection: 1,
                    popoverOptions: CameraPopoverOptions,
                    saveToPhotoAlbum: false
                };
   
                    $cordovaCamera.getPicture(options).then(function (imageData) {
                        $scope.imgURI[id]="data:image/jpeg;base64," + imageData;
                    }, function (err) {
                        
                    });
                };

                
            

$scope.ekle = function(){
  if(!$scope.imgURI[0] && !$scope.imgURI[1] && !$scope.imgURI[2] && !$scope.imgURI[3] && !$scope.imgURI[4] && !$scope.imgURI[5]){
    $cordovaDialogs.alert('Lütfen tüm fotoğraf alanlarını doldurunuz.', 'Clearfix', 'Tamam')
    .then(function() {
      // callback success
    });
  }
  else{
    $scope.tarih = $filter('date')($scope.bilgi.d_tarih, 'yyyy-MM-dd');
  $http({
        url: "http://192.168.43.105/dashboard/json_db_add.php",
        method: "POST",
        data: {
            'ad': $scope.bilgi.ad,
            'soyad': $scope.bilgi.soyad,
            'email': $scope.bilgi.email,
            'tel': $scope.bilgi.tel,
            'd_tarih':$scope.tarih,
            'cinsiyet': $scope.bilgi.cinsiyet,
            'il': $scope.bilgi.il,
            'ilce': $scope.bilgi.ilce,
            'ek': $scope.bilgi.ek,
            'oneSignal': $rootScope.oneSignalid,
            'foto1': $scope.imgURI[0],
            'foto2': $scope.imgURI[1],
            'foto3': $scope.imgURI[2],
            'foto4': $scope.imgURI[3],
            'foto5': $scope.imgURI[4]
        }
    }).success(function(response) {
        
    }).error(function(response) {
        
    });

    $scope.gonder.show();
    
    $scope.imgURI = [];

    $scope.bilgi.ad = null;
    $scope.bilgi.soyad= null;
    $scope.bilgi.email= null;
    $scope.bilgi.tel= null;
    $scope.bilgi.d_tarih= null;
    $scope.bilgi.cinsiyet= null;
    $scope.bilgi.il= null;
    $scope.bilgi.ilce= null;
    $scope.bilgi.ek= null;
    $state.go('app.anasayfa');
  }
  };
});
