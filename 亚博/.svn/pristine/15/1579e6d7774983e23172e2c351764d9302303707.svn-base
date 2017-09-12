angular.module('cpApp').controller('helpsCtrl', ['$rootScope', '$scope', '$state', 'AnnoucementService', function($rootScope, $scope, $state, AnnoucementService) {
    
    $rootScope.title = "公告帮助";

    $scope.noticeActive = 'help';

    $scope.goDetail = function(id) {
        $state.go('helps.notice1_detail', {
            id: id
        });
        $scope.noticeActive = 'notice';
    };

    AnnoucementService.ancmtItems().then(function(res) {
        $scope.noticeDatas = res.data.datas;
    });
}]);