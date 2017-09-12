angular.module('cpApp')
.directive('countDown', ['$rootScope', '$interval', function ($rootScope, $interval){
	
	return {
		restrict: 'E',
		scope: {
			time: '=',
			type: '@',
			tick: '='
		},
		link: function (scope, element, attrs, ctrl) {
			scope.data = {};
			if (typeof scope.type == 'undefined') {
				scope.data.type = 'normal';
			}
			else {
				scope.data.type = scope.type;
			}
			scope.timerHandler = null;
			var tickCb = scope.tick || (function () {} );
			scope.$watch('time', function (newval) {
				if (newval !== undefined && typeof newval['second'] != 'undefined') {
					console.log(['时间发生变化 倒计时 起动', newval]);
					startCounter();
				}
			});
			
			function _counter() {
				scope.timeLeft --;
				var timeLeft = scope.timeLeft;
				
		        tickCb(scope.timeLeft, scope.timerHandler);
		        
				if (timeLeft > 0) {
					scope.day = ('0' + Math.floor(timeLeft / 60 / 60 / 24)).slice(-2);
			        scope.hour = ('0' + (Math.floor(timeLeft / 60 / 60) - scope.day * 24)).slice(-2);
			        scope.minute = ('0' + (Math.floor(timeLeft / 60) - scope.day * 24 * 60 - scope.hour * 60)).slice(-2);
			        scope.second = ('0' + (timeLeft - scope.day * 24 * 60 * 60 - scope.hour * 60 * 60 - scope.minute * 60)).slice(-2);
				}
				else {
					$interval.cancel(scope.timerHandler);
					scope.timerHandler = null;
				}
			}
			
			function startCounter() {
				scope.timeLeft = scope.time['second'];
				if (scope.timerHandler) {
					$interval.cancel(scope.timerHandler);
				}
				scope.timerHandler = $interval(function () {
					_counter();
				}, 1000);
			}
			
			scope.$on('$destroy', function () {
				$interval.cancel(scope.timerHandler);
				scope.timerHandler = null;
			});
		},
		templateUrl: templateBaseURI + '/directives/countdown.html'
	};
}]);