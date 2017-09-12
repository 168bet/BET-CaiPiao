angular.module('cpApp').controller('drawCtrl', ['$rootScope','$scope', 'drawService', function($rootScope, $scope, drawService) {
  $rootScope.title = "开奖中心";
  $scope.theads = ['彩种', '期号', '开奖时间', '开奖号码', '奖池奖金', '开奖详情', '走势图', '投注'];
  //获取开奖数据333
  var promise = drawService.getData();
  promise.then(function(res) {
    console.log(res);
    $scope.datas = res.data.datas.result[0].dataJsonStr[0];
    var totalDatas = $scope.datas;
    console.log($scope.datas);//能打印出结果
    $scope.lotteryNames = Object.keys ? Object.keys($scope.datas) : getKeys($scope.datas);
    console.log($scope.lotteryNames);
    $scope.handleDatas = [];
    var lotteryNames = $scope.lotteryNames;
    for(var i=0;i<lotteryNames.length;i++){
      var perData = totalDatas[lotteryNames[i]];
      $scope.handleDatas.push(perData);
    }
    console.log($scope.handleDatas);
    $scope.chineseNames = {};
    angular.forEach(lotteryNames, function(value, key){
      if(value=="BJKL8"){
         $scope.chineseNames['BJKL8'] = '幸运28';
      }
      if(value=="BJPK10"){
         $scope.chineseNames['BJPK10'] = '北京PK拾';
      }
      if(value=="CAKENO"){
         $scope.chineseNames['CAKENO'] = '加拿大28';
      }
      if(value=="CQSSC"){
         $scope.chineseNames['CQSSC'] = '重庆时时彩';
      }
      if(value=="HK6"){
         $scope.chineseNames['HK6'] = '香港六合彩';
      }
      if(value=="KLSF"){
         $scope.chineseNames['TJKLSF'] = '天津快乐十分';
      }
      if(value=="FTC"){
         $scope.chineseNames['FC3D'] = '福彩3D';
         $scope.chineseNames['PL3'] = '排列3';
      }
    });
    console.log($scope.chineseNames);
    $scope.sscCodes = $scope.datas.CQSSC[0].kjjg.split(',');console.log($scope.sscCodes);
    $scope.pk10Codes = $scope.datas.BJPK10[0].kjjg.split(',');
    $scope.fc3dCodes = $scope.datas.FTC[0].kjjg.split(',');
    $scope.pl3Codes = $scope.datas.FTC[1].kjjg.split(',');
    $scope.sscMoney = parseFloat((500000000+10e8*Math.random()).toFixed(2)).toLocaleString();
    $scope.pk10Money = parseFloat((400000000+10e7*Math.random()).toFixed(2)).toLocaleString();
    $scope.kl8Money = parseFloat((800000000+10e8*Math.random()).toFixed(2)).toLocaleString();
    $scope.fc3dMoney = parseFloat((500000000+10e8*Math.random()).toFixed(2)).toLocaleString();
    $scope.pl3Money = parseFloat((500000000+10e8*Math.random()).toFixed(2)).toLocaleString();
    $scope.cakeMoney = parseFloat((50000000+10e4*Math.random()).toFixed(2)).toLocaleString();
    $scope.klsfMoney = parseFloat((50000000+10e4*Math.random()).toFixed(2)).toLocaleString();
    $scope.hk6Money = parseFloat((50000000+10e4*Math.random()).toFixed(2)).toLocaleString();
  },function(error){
    console.log(error);
  });

  //处理数据
  function getKeys(obj) {
    var arr = [];
    for (var key in obj) {
      arr.push(key);
    }
    return arr;
  }
}]);