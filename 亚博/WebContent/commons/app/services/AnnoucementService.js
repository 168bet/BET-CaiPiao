angular.module('cpApp').factory('AnnoucementService', ['$http', function($http) {
    return {
        ancmtItems: function() {
            return $http({
                url: baseURI + '/announcement/goList',
                method: 'GET',
            });
        },
        ancmtDetail: function(id) {
            return $http({
                url: baseURI + '/announcement/detail/'+id,
                method: 'GET',
            });
        }
    };
}]);