// Ionic Starter App

// angular.module is a global place for creating, registering and retrieving Angular modules
// 'starter' is the name of this angular module example (also set in a <body> attribute in index.html)
// the 2nd parameter is an array of 'requires'
// 'starter.controllers' is found in controllers.js
angular.module('starter', ['ionic', 'starter.controllers' ,'ionMdInput'])

.run(function($ionicPlatform,$rootScope) {

  $ionicPlatform.ready(function() {
    
    if(window.Connection){
      if(navigator.connection.type == Connection.NONE){
        alert("İnternet bağlantınızı kontrole edip tekrar deneyiniz.");
      }

    }
   
     
    var notificationOpenedCallback = function(jsonData) {
      
    };

    // TODO: Update with your OneSignal AppId before running.
    window.plugins.OneSignal
      .startInit("")
      .handleNotificationOpened(notificationOpenedCallback)
      .endInit();

      window.plugins.OneSignal.getIds(function(ids) {
  
        $rootScope.oneSignalid = ids.userId;
      });
   
    if (window.StatusBar) {
      // org.apache.cordova.statusbar required
      StatusBar.styleDefault();
    }
  });
})

.config(function($stateProvider, $urlRouterProvider,$sceDelegateProvider) {
  
  $stateProvider

    .state('app', {
    url: '/app',
    abstract: true,
    templateUrl: 'templates/menu.html',
    controller: 'AppCtrl'
  })

  .state('app.anasayfa', {
    url: '/anasayfa',
    views: {
      'menuContent': {
        templateUrl: 'templates/anasayfa.html'
      }
    }
  })

  .state('app.giris', {
    url: '/giris',
    views: {
      'menuContent': {
        templateUrl: 'templates/giris.html',
        controller: 'LoginCtrl'
      }
    }
  })

  .state('app.profilDetay', {
    url: '/profil/:profilDetayId',
    views: {
      'menuContent': {
        templateUrl: 'templates/profilDetay.html',
        controller: 'ProfilDetayCtrl'
      }
    }
  })

  .state('app.profil', {
    url: '/profil',
    views: {
      'menuContent': {
        templateUrl: 'templates/profil.html',
        controller: 'ProfilCtrl'
      }
    }
  })

  .state('app.kılavuz', {
    url: '/kılavuz',
    views: {
      'menuContent': {
        templateUrl: 'templates/kılavuz.html',
        controller: 'VideoCtrl'
      }
    }
  })

  .state('app.videolar', {
    url: '/videolar',
    views: {
      'menuContent': {
        templateUrl: 'templates/videolar.html',
        controller: 'VideoCtrl'
      }
    }
  })

  .state('app.fotoEkle', {
    url: '/fotoEkle',
    views: {
      'menuContent': {
        templateUrl: 'templates/fotoEkle.html',
        controller: 'FotoEkleCtrl'
        
      }
    }
  })

  .state('app.foto', {
      url: '/foto',
      views: {
        'menuContent': {
          templateUrl: 'templates/foto.html',
          controller: 'FotoCtrl'

        }
      }
    })
    .state('app.form', {
      url: '/form',
      views: {
        'menuContent': {
          templateUrl: 'templates/form.html',
          controller: 'FotoCtrl'
          
        }
      }
    });
  // if none of the above states are matched, use this as the fallback
  $urlRouterProvider.otherwise('/app/anasayfa');
});
