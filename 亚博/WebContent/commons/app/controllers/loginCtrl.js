angular.module('cpApp').controller('loginCtrl' ,['$rootScope' ,'$scope','$interval', '$state', '$filter' , 'UserCenter', 'CPMisc', 'UI',
function($rootScope ,$scope, $interval, $state, $filter , UserCenter, CPMisc, UI) {
	$rootScope.title = '用户登录';
	$scope.formdata = {user: {}};
	
	if ($rootScope.global.user) {
		$rootScope.goHome();
	}
	else {
		$rootScope.loadAccountInfo().then(function () {
			if ($rootScope.global.user) $state.go('user');
		});
	}
	
	$scope.fun = {
		alert: UI.alert,
		login: function (form) {
			if (form.$invalid) {
				if (form.uname.$invalid) {
					UI.alert('请输入正确的登陆用户名 (6-20位数字和字母组成)');
				}
				else if (form.upwd.$invalid) {
					UI.alert('请输入正确的登陆密码 (6-20位数字和字母组成)');
				}
			}
			else {
				UserCenter.userLogin($scope.formdata.user.uname, $scope.formdata.user.upwd).then(function(res) {
					if (!res['data']['rs']) {
						UI.alert(res['data']['msg']);
					}
					else {
						$rootScope.loadAccountInfo();
						$state.go('user.info');
					}
				});
			}
			
		}
	};
	
	$scope.marqueeItems = [];
	CPMisc.cpWinnerList().then(function (res) {
		cpwinners = res['data']['datas'].slice(0, 10);
		var marqueeItems = [];
		angular.forEach(cpwinners, function (winner) {
			marqueeItems.push({content: '会员 <span class="user">'+ winner.userName+'</span>在' + winner.gameName+ '<span class="price">'+ $filter('money')(winner.kyje) + '元</span>'});
		});
		$scope.marqueeItems = marqueeItems;
	});
	
	
}]);