angular.module('cpApp').controller('HomeCtrl' ,['$rootScope' ,'$scope','$http','$interval', '$filter' , '$q', 'UserCenter', 'UI', 'CPMisc', 
function($rootScope ,$scope ,$http ,$interval, $filter, $q, UserCenter, UI, CPMisc) {
    
	$rootScope.title = '亚博彩票';
	$scope.formdata = {user: {}};
	
	$scope.fun = {
		login: function (form) {
			if (form.$invalid) return ;
			UserCenter.userLogin($scope.formdata.user.uname, $scope.formdata.user.upwd).then(function(res) {
				if (!res['data']['rs']) {
					UI.alert(res['data']['msg']);
				}
				else {
					$rootScope.loadAccountInfo();
				}
			});
		},
		alert: UI.alert
	};
	
	$scope.marqueeItems = [];
	CPMisc.cpWinnerList().then(function (res) {
		cpwinners = res['data']['datas'].slice(0, 10);
		var marqueeItems = [];
		angular.forEach(cpwinners, function (winner) {
			marqueeItems.push({content: '会员 <span class="user">'+ winner.userName+'</span>在' + winner.gameName+ '赢<span class="price">'+ $filter('money')(winner.kyje) + '元</span>'});
		});
		$scope.marqueeItems = marqueeItems;
	});
	
	$scope.lastIssue = {
		BJKL8: {},
		CAKENO: {},
		TJSSC: {}
	};
	
	$scope.fun.loadGamesIssue = function() {
		var promises = [];
		for (var gameCode in $scope.lastIssue) {
			promises.push(CPMisc.recentIssue(gameCode));
		}
		$q.all(promises).then(function (issues) {
			angular.forEach(issues, function(issue) {
				if (issue['data']['rs']) {
					var gameCode = issue['data']['datas']['gameEnName'];
					$scope.lastIssue[gameCode] = issue['data']['datas'];

		            $scope.lastIssue[gameCode].downTimeLeft = {second: Number(issue.data.datas.downTimeLeft)};
		            $scope.lastIssue[gameCode].betAdvanceTime = Number(issue.data.datas.betAdvanceTime);
		            $scope.lastIssue[gameCode].closeTimeLeft =  {second: $scope.lastIssue[gameCode].downTimeLeft + $scope.lastIssue[gameCode].betAdvanceTime};
				}
			});
		});
	};
	
	$scope.fun.totalInArray = function(array){
		var sum = 0;
		angular.forEach(array, function (val) {
			sum += val*1;
		});
		return sum;
	};
	
	// 封盘倒计时 回调
    $scope.fun.closeTickCb = function(leftSecond, intervalHandler) {
    	if (leftSecond <= 0) {
    		//
    	}
    };
    // 开奖倒计时回调
    $scope.fun.openTickCb = function (leftSecond, intervalHandler) {
    	if (leftSecond <= 0) {
            $timeout(function () {
            	$scope.fun.loadGamesIssue();
            }, 15e3);
    	}
    };
    
    // 加载开奖数据
    $scope.fun.loadGamesIssue();
	
}]);
