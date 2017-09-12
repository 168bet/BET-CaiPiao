angular.module('cpApp').controller('footCtrl', ['$rootScope', '$scope', '$state', '$interval', '$window', 'UI', function($rootScope, $scope, $state, $interval, $window, UI) {

    $scope.showCode = false;

    $scope.APPshow = $rootScope.APPshow = function() {
        UI.alert('敬请期待！');
    };

    $scope.withdraw = function() {
        if (!$rootScope.isLogged()) {
            UI.alert('请先登陆');
        } else {
            $state.go('user.funds/withdraw');
        }
    };
}]);