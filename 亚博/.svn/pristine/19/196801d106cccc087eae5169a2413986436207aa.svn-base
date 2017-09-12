angular.module('cpApp')
.directive('phone', [function() {
	
	var PHONE_EXP = /^1\d{2}\d{8}$/i;
	
	return {
		require: 'ngModel',
		restrict: 'A',
		link: function (scope, elem, attrs, ctrl) {
			ctrl.$parsers.unshift(function (newval) {
				if (PHONE_EXP.test(newval)) {
					ctrl.$setValidity('phone', true);
					return newval;
				}
				else {
					ctrl.$setValidity('phone', false);
					return undefined;
				}
			});
		}
	};
}])
.directive('matchModel', ['$parse', function ($parse) {
	return {
		require: 'ngModel',
		restrict: 'A',
		link: function (scope, elem, attrs, ctrl) {
			var matchModel = attrs['matchModel'];
			var validator = function (value) {
				if (value.length <= 0) {
					ctrl.$setValidity('matchModel', true);
					return value;
				}
				var firstOne = $parse(matchModel)(scope);
				var equal = firstOne == value;
				ctrl.$setValidity('matchModel', equal);
				return value;
			};
			
			ctrl.$parsers.unshift(validator);
		}
	};
}]);