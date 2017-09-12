angular.module('cpApp').service('drawService', ['$http','$q',function ($http,$q) {
  var deferred = $q.defer();
  $http.get(baseURI + "/lotteryCenter/getAllGameTypeNewResultList").then(function(data){
    deferred.resolve(data);
  });
  this.getData = function(){
    return deferred.promise;
  };
}]);
