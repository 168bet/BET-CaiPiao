angular.module('cpApp')
.controller('ChartsCtrl', ['$rootScope', '$scope', '$stateParams', function ($rootScope, $scope, $stateParams) {
	$rootScope.title = "走势图";
	
	$scope.data = [{
		x: 25,
		y: 784720,
		data: '25'
	}, {
		x: 10,
		y: 784721,
		data: '10'
	}, {
		x: 2,
		y: 784722,
		data: '2'
	}, {
		x: 20,
		y: 784723,
		data: '20'
	}, {
		x: 18,
		y: 784724,
		data: '18'
	}];
	
	$scope.codeTableConfig = {
		codeRange: $rootScope.range(0, 28).concat(['单', '双', '中', '边', '大', '小', '极', '豹']),
	};
	
}]);