angular.isEmpty = function(obj) {
  if (angular.isArray(obj)) return obj.length <= 0;
  if (angular.isObject(obj)) {
    var keys = Object.keys(obj);
    return keys.length=== 0;
  }
  if (angular.isString(obj)) return obj.length=== 0;
  if (angular.isNumber(obj)) return obj=== 0;
  
  return !!obj;
};

if (typeof Object.values == 'undefined') {
	Object.values = function (obj) {
		var values = [];
		for (var k in obj) {
			values.push(obj[k]);
		}
		return values;
	};
}

Date.prototype.isValid = function () {
	return !isNaN(this.getDate());
};

angular.module('cpApp', ['ui.router', 'ngDialog', 'rzModule', 'angular-loading-bar', 'ngAnimate', 'cfp.loadingBar', 'chart.js'])
  .config(['$stateProvider', '$urlRouterProvider', '$httpProvider', 'ngDialogProvider', 'cfpLoadingBarProvider',
   function($stateProvider, $urlRouterProvider, $httpProvider, ngDialogProvider, cfpLoadingBarProvider) {
	 
    $urlRouterProvider.otherwise('/home');
    $stateProvider
      .state('home', {
        url: '/home',
        controller: 'HomeCtrl',
        templateUrl: templateBaseURI + '/home.html',
      })
      .state('game', {
        url: '/game',
        templateUrl: templateBaseURI + '/game/game.html',
      })
      .state('game.name', {
        url: '/:name',
        views: {
          'game': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/game/' + $stateParams['name'].toLowerCase() + '.html';
            },
            controller: 'GameCtrl',
          }
        }
      })
      .state('game.name.play', {
        url: '/play/:qs',
        views: {
          'game@game': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/game/' + $stateParams['name'].toLowerCase() + '_play.html';
            },
            controller: 'GameCtrl',
          }
        }
      })
      .state('ssc', {
        url: '/ssc',
        controller: 'sscCtrl',
        templateUrl: templateBaseURI + '/ssc/ssc.html',
      })
      .state('ssc.name', {
        url: '/:name',
        views: {
          'ssc': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/ssc/' + $stateParams['name'].toLowerCase() + '.html';
            },
            controller: 'sscCtrl',
          }
        }
      })
      .state('ssc.name.play', {
        url: '/play/:qs',
        views: {
          'ssc@ssc': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/ssc/' + $stateParams['name'].toLowerCase() + '_play.html';
            },
            controller: 'sscCtrl',
          }
        }
      })
      .state('klsf', {
        url: '/klsf',
        controller: 'klsfCtrl',
        templateUrl: templateBaseURI + '/klsf/klsf.html',
      })
      .state('klsf.name', {
        url: '/:name',
        views: {
          'klsf': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/klsf/' + $stateParams['name'].toLowerCase() + '.html';
            },
            controller: 'klsfCtrl',
          }
        }
      })
      .state('klsf.name.play', {
        url: '/play/:qs',
        views: {
          'klsf@klsf': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/klsf/' + $stateParams['name'].toLowerCase() + '_play.html';
            },
            controller: 'klsfCtrl',
          }
        }
      })
      .state('fclhc', {
        url: '/fclhc',
        controller: 'fclhcCtrl',
        templateUrl: templateBaseURI + '/fclhc/fclhc.html',
      })
      .state('fclhc.name', {
        url: '/:name',
        views: {
          'fclhc': {
            templateUrl:function($stateParams) {
              return templateBaseURI + '/fclhc/' + $stateParams['name'].toLowerCase() + '.html';
            },
            controller: 'fclhcCtrl',
          }
        }
      })
      .state('fclhc.name.play', {
        url: '/play/:qs',
        views: {
          'fclhc@fclhc': {
            templateUrl: function($stateParams) {
              return templateBaseURI + '/fclhc/' + $stateParams['name'].toLowerCase() + '_play.html';
            },
            controllerProvider: ['$stateParams',function ($stateParams) {
            	if ($stateParams.name.toLowerCase() == 'hk6') {
            		return 'fclhcHk6Ctrl';
            	}
            	else if ($stateParams.name.toLowerCase() == 'fc3d') {
            		return 'fclhcF3dCtrl';
            	}
            	else if ($stateParams.name.toLowerCase() == 'pl3') {
            		return 'fclhcPl3Ctrl';
            	}
            	return 'fclhcCtrl';
            }]
          }
        }
      })
      .state('bjpk10', {
        url: '/bjpk10',
        params:{'name':null},
        controller: 'bjpk10Ctrl',
        templateUrl: templateBaseURI + '/game/bjpk10.html'
      })
      .state('bjpk10Bet', {
        url: '/bjpk10Bet/:qs',
        controller: 'bjpk10Ctrl',
        templateUrl: templateBaseURI + '/game/bjpk10_bet.html'
      })
      .state('user', {
          url: '/user',
          templateUrl: templateBaseURI + '/userCenter/userLayout.html',
          controller: ['$state',function ($state) {
        	//
          }],
        })
      .state('user.info', {
    	  url: '/info',
          controller: 'UserCtrl',
          templateUrl: templateBaseURI + '/userCenter/user.html'
      })
      .state('user.bank', {
        url: '/bank',
        controller: 'UserBankCtrl',
        templateUrl: templateBaseURI + '/userCenter/userBank.html',
      })
      .state('user.bank/add', {
        url: '/bank/add',
        controller: 'UserAddBankCtrl',
        templateUrl: templateBaseURI + '/userCenter/userAddBank.html',
      })
      .state('user.task', {
        url: '/task',
        controller: 'UserTaskCtrl',
        templateUrl: templateBaseURI + '/userCenter/userTask.html',
      })
      .state('user.bonus', {
        url: '/bonus',
        controller: 'UserBonusCtrl',
        templateUrl: templateBaseURI + '/userCenter/userBonus.html',
      })
      .state('user.tracelist', {
        url: '/trace-list',
        controller: 'UserTraceListCtrl',
        templateUrl: templateBaseURI + '/userCenter/userTraceList.html',
      })
      .state('user.accountdetail', {
        url: '/account-detail?user',
        controller: 'UserAccountDetailCtrl',
        templateUrl: templateBaseURI + '/userCenter/userAccountDetail.html',
      })
      .state('user.playwlost', {
        url: '/play-wlost',
        controller: 'UserPlayWLostCtrl',
        templateUrl: templateBaseURI + '/userCenter/userPlayWlost.html',
      })
      .state('user.historder', {
        url: '/history-order?user',
        controller: 'UserHistorderCtrl',
        templateUrl: templateBaseURI + '/userCenter/userHistorder.html',
      })
      .state('user.orderdetail', {
    	  url: '/order-detail/:id',
    	  controller: 'UserOrderDetailCtrl',
    	  templateUrl: templateBaseURI + '/userCenter/userOrderDetail.html',
      })
      .state('user.security', {
        url: '/security',
        templateUrl: templateBaseURI + '/userCenter/userSecurity.html',
        resolve: {
          '$rootScope': '$rootScope'
        },
        controller: ['$scope', '$rootScope', function($scope, $rootScope) {
          $rootScope.title = '安全中心';
        }],
      })
      .state('user.security/passwd', {
        url: '/security/:pwdtype',
        templateUrl: templateBaseURI + '/userCenter/userPasswd.html',
        controller: 'UserUpdatePasswdCtrl'
      })
      .state('user.security/question', {
        url: '/security/set/question',
        templateUrl: templateBaseURI + '/userCenter/userQuestion.html',
        controller: 'UserQuestionCtrl',
      })
      .state('user.securtiy/bindmail', {
        url: '/security/set/bindmail',
        templateUrl: templateBaseURI + '/userCenter/userBindmail.html',
        controller: 'UserBindmailCtrl',
      })
      .state('user.proxy/index', {
        url: '/proxy/index',
        templateUrl: templateBaseURI + '/userCenter/userProxyIndex.html',
        controller: 'UserProxyIndexCtrl',
      })
      .state('user.proxy/useradd', {
        url: '/proxy/useradd',
        templateUrl: templateBaseURI + '/userCenter/userProxyUseradd.html',
        controller: 'UserProxyUseraddCtrl',
      })
      .state('user.proxy/customer', {
        url: '/proxy/customer',
        templateUrl: templateBaseURI + '/userCenter/userProxyCustomer.html',
        controller: 'UserProxyCustomerCtrl'
      })
      .state('user.funds/charge', {
        url: '/funds/charge',
        templateUrl: templateBaseURI + '/userCenter/userFundsCharge.html',
        controller: 'UserFundsChargeCtrl'
      })
      .state('user.funds/bankcharge', {
        url: '/funds/charge/bank',
        templateUrl: templateBaseURI + '/userCenter/userFundsBankCharge.html',
        controller: 'UserFundsBankChargeCtrl',
      })
      .state('user.funds/weixinPay', {
        url: '/funds/charge/weixinPay',
        templateUrl: templateBaseURI + '/userCenter/weixinPay.html',
        controller: 'UserWeixinPayCtrl',
      })
      .state('user.funds/culturePay', {
        url: '/funds/charge/culturePay',
        templateUrl: templateBaseURI + '/userCenter/culturePay.html',
        controller: 'UserCulturePayCtrl',
      })
      .state('user.funds/onlinePay', {
        url: '/funds/charge/onlinePay',
        templateUrl: templateBaseURI + '/userCenter/onlinePay.html',
        controller: 'UserOnlinePayCtrl',
      })
      .state('user.funds/tradition_wx', {
        url: '/funds/charge/tradition_wx',
        templateUrl: templateBaseURI + '/userCenter/tradition_wx.html',
        controller: 'tradition_wxPayCtrl',
      })
      .state('user.funds/tradition_ali', {
        url: '/funds/charge/tradition_ali',
        templateUrl: templateBaseURI + '/userCenter/tradition_ali.html',
        controller: 'tradition_aliPayCtrl',
      })
      .state('user.funds/withdraw', {
        url: '/funds/withdraw',
        templateUrl: templateBaseURI + '/userCenter/userFundsWithdraw.html',
        controller: 'UserFundsWithdrawCtrl',
      })
      .state('user.funds/water', {
        url: '/funds/water',
        templateUrl: templateBaseURI + '/userCenter/userFundsWater.html',
        controller: 'UserFundsWaterCtrl',
      })
      .state('helps', {
        url: '/helps',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/helps.html'
      })
      .state('helps.help', {
        url: '/help',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/helps-help.html'
      })
      .state('helps.about', {
        url: '/about',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/helps-about.html'
      })
      .state('helps.notice', {
        url: '/notice',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/helps-notice.html'
      })
      .state('helps.provision', {
        url: '/provision',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/helps-provision.html'
      })
      .state('helps.notice1_detail', {
        url: '/notice1_detail/:id',
        controller:'helpsDetailCtrl',
        templateUrl: templateBaseURI + '/helps/notice1_detail.html'
      })
      .state('helps.notice2_detail', {
        url: '/notice2_detail',
        controller:'helpsCtrl',
        templateUrl: templateBaseURI + '/helps/notice2_detail.html'
      })
      .state('draw', {
        url: '/draw',
        controller: 'drawCtrl',
        templateUrl: templateBaseURI + '/draw/draw.html'
      })
      .state('drawDetail', {
        url: '/drawDetail',
        controller: 'drawDetailCtrl',
        params: {
          'drawDatas': null,
          'code': null,
          'date': null,
          'chineseNames': null
        },
        templateUrl: templateBaseURI + '/draw/drawDetail.html'
      })
      .state('charts', {
        url: '/charts',
        templateUrl: templateBaseURI + '/charts/charts.html'
      })
      .state('charts.name', {
        url: '/:name',
        templateUrl: function ($stateParams) {
        	return templateBaseURI + '/charts/charts-'+$stateParams.name.toLowerCase()+'.html';
        },
        controller: 'ChartsCtrl'
      })
      .state('register', {
        url: '/register',
        templateUrl: templateBaseURI + '/account/register.html',
        abstract: true,
        controller: 'UserRegisterCtrl',
      })
      .state('register.step/one', {
        url: '/step-one',
        templateUrl: templateBaseURI + '/account/registerStepOne.html',
        controller: 'UserRegisterCtrl',
      })
      .state('register.step/two', {
        url: '/step-two',
        templateUrl: templateBaseURI + '/account/registerStepTwo.html',
        controller: 'UserRegisterCtrl',
      })
      .state('register.step/three', {
        url: '/step-three',
        templateUrl: templateBaseURI + '/account/registerStepThree.html',
        controller: 'UserRegisterCtrl',
      })
      .state('login', {
        url: '/login',
        controller: 'loginCtrl',
        templateUrl: templateBaseURI + '/account/login.html'
      })
      .state('forget', {
        url: '/forget',
        controller: 'forgetCtrl',
        templateUrl: templateBaseURI + '/account/forget.html'
      })
      .state('lotteryCenter', {
        url: '/lotteryCenter',
        controller: 'lotteryCenterCtrl',
        templateUrl: templateBaseURI + '/lotteryCenter/lotteryCenter.html'
      })
      .state('payCenter', {
        url: '/payCenter',
        controller: 'payCenter',
        params:{pay_url:null,sendParams:null},
        templateUrl: templateBaseURI + '/userCenter/payCenter.html'
      });
  }])
  .run(['$rootScope', '$window', '$interval', '$cacheFactory', '$sce', '$http', '$state', 'UserCenter', 'UI', 'AnnoucementService',
    function($rootScope, $window, $interval, $cacheFactory, $sce, $http, $state, UserCenter, UI, AnnoucementService) {
      angular.extend($rootScope, {
        global: {
          user: null,
          noticeListTypeTwo: []
        },
        loadAccountInfo: function() {
          return UserCenter.userInfo().then(function(res) {
            if (res['data']['rs']) {
              $rootScope.global.user = res['data']['datas'];
            } else {
              $rootScope.global.user = null;
            }
          });
        },
        logout: function() {
          UserCenter.logout().then(function() {
            $rootScope.goHome();
          });
        },
        goHome: function() {
          window.location.href = baseURI;
        },
        isHome: function() {
          return baseURI + '/' == window.location.pathname;
        },
        templateURI: function(uri) {
          return templateBaseURI + uri;
        },
        baseURI: baseURI,
        staticURI: staticURI,
        isLogged: function() {
          return !!$rootScope.global.user;
        },
        setTitle: function(title) {
          window.document.title = title;
        },
        range: function(start, end, step) {
          step = step || 1;
          end = Math.ceil(end);
          var nums = [];
          for (var i = start; i < end; i += step) {
            nums.push(i);
          }
          return nums;
        },
      });

      $rootScope.$on('$stateChangeStart', function(event, toState, toParams, fromState, fromParams, options) {
        $rootScope.loadAccountInfo().then(function(res) {
          var name = toState['name'];
          if ((name.indexOf('user')=== 0) && !$rootScope.global.user) {
            $rootScope.goHome();
          }
        });
      });

      $rootScope.$watch('title', function(title) {
        $rootScope.setTitle(title);
      });

      AnnoucementService.ancmtItems().then(function(res) {
        var datas = res['data']['datas'];
        var items = [];
        angular.forEach(datas, function(item) {
          items.push({
            content: item['ggTitle']
          });
        });
        $rootScope.global.noticeListTypeTwo = items;

      });
    }
  ]);