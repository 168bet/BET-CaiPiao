angular.module('cpApp').controller('helpsDetailCtrl', ['$stateParams', '$rootScope',
    '$scope', '$state', 'AnnoucementService',
    function($stateParams, $rootScope, $scope, $state, AnnoucementService) {

        AnnoucementService.ancmtDetail($stateParams.id).then(function(res) {
            $scope.detail = res.data.datas;
            $rootScope.title = res.data.datas.ggTitle;
        }, function(err) {
            console.log(err);
        });
        $scope.noticeActive = 'notice';
    }
]);