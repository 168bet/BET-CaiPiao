angular.module('cpApp').service('gameService', ['$http', '$q', function($http, $q) {
  //ajax
  this.getData = function(url,config) {
    var deferred = $q.defer();
    config = config||{timeout:30000};
    $http.get(baseURI + url,config).then(function(data) {
      deferred.resolve(data);
    });
    return deferred.promise;
  };
  this.postData = function(url,params){
    var deferred = $q.defer();
    $http.post(baseURI+url,params,{timeout:30000}).then(function(){
      deferred.resolve(data);
    });
    return deferred.promise;
  };
  //获取前天昨天日期方法
  this.GetDateStr = function(day,AddDayCount,flag){
    var dd = new Date(day);
    //获取AddDayCount天后的日期
    dd.setDate(dd.getDate() + AddDayCount);
    var y = dd.getFullYear();
    //获取当前月份的日期
    var m = dd.getMonth() + 1 >= 10?dd.getMonth() + 1 : '0'+(dd.getMonth() + 1);
    var d = dd.getDate()>=10?dd.getDate():'0'+ dd.getDate();
    //时分秒
    var time = " "+ ("0"+dd.getHours()).slice(-2) + ':'+ ("0"+dd.getMinutes()).slice(-2) + ':' + ("0"+dd.getSeconds()).slice(-2);
    if(flag){
      return y + "-" + m + "-" + d + time;
    }else{
      return y + "-" + m + "-" + d;
    }
  };


}]);