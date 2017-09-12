angular.module('cpApp')
.filter('money', [function () {
	return function (input) {
		var num = Number(input);
		if (num == isNaN) num = 0;
		return num.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
	};
}])
.filter('default', [function () {
	return function (input, defaultStr) {
		if (input) return input;
		return defaultStr;
	};
}])
.filter('ifShow', [function () {
	return function (input, ifShow) {
		if (ifShow) return input;
		return '';
	};
}])
.filter('trustHTML', ['$sce', function ($sce) {
	return function (input) {
		return $sce.trustAsHtml(input+"");
	};
}]);