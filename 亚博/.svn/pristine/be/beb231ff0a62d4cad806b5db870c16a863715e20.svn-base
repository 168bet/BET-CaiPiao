angular.module('cpApp').controller('drawDetailCtrl', ['$rootScope','$scope', '$interval', '$stateParams','$http','$document',function($rootScope,$scope, $interval, $stateParams,$http,$document) {
  $rootScope.title = "开奖详情";
  console.log($stateParams);
  //获取传过来的参数
  $scope.chineseNames = $stateParams.chineseNames;
  $scope.curDate = $stateParams.date.split(' ')[0];
  $scope.secDate = $scope.curDate;
  $scope.code = $stateParams.code;
  $scope.curName = $scope.chineseNames[$stateParams.code];
  //每页显示个数默认设置为10
  $scope.pageLimit = 10;
  $scope.first = 1;
  $scope.second = 2;
  $scope.third = 3;
  $scope.curPageFlag = 1;//控制页码点击后样式

  $scope.onlyChinese = [];
  for (var key in $scope.chineseNames) {
    $scope.onlyChinese.push($scope.chineseNames[key]);
  }
  // console.log($scope.onlyChinese);
  //传参获取数据
  var url = baseURI + "/lotteryCenter/getAllGameTypeNewResultList";
  function getData(){
    $http.get(url, {params:{code:$stateParams.code,date:$scope.curDate},timeout:30000}).then(function(res){
      console.log(res);
      // if($scope.code == "FC3D"){
      //   $scope.code = "FTC";
      // };
      if(!res.data.rs){
        return;
      }
      if(res.data.datas.result){
        $scope.totalDatas = res.data.datas.result;
      }else{
        $scope.totalDatas = [];
      }
      console.log($scope.totalDatas);
      $scope.totalCount = res.data.datas.totalCount;
      console.log($scope.totalCount);
      $scope.pageNums = Math.ceil($scope.totalCount/$scope.pageLimit);
    },function(res){
      console.log(res);
    });
  }
  getData();
  //下拉框
  $scope.showKind = 'none';
  $scope.showList = function($event) {
    // $event.stopPropagation();
    if ($scope.showKind == 'none') {
      $scope.showKind = 'block';
    } else {
      $scope.showKind = 'none';
    }
  };
  $scope.hideList = function(){
    $scope.showKind = 'none';
  };
  // $scope.lotKinds = ['重庆时时彩', '北京PK拾', '幸运28', '加拿大28', '新加坡28', '动物转盘'];
  $scope.selectKind = function(index) {
    var curName = $scope.curName;
    $scope.curName = null;
    $scope.curKind = $scope.onlyChinese[index];
    for (var key in $scope.chineseNames) {
      if ($scope.chineseNames[key] == $scope.curKind) {
        $scope.code = key;
      }
    }
    if($scope.code=='FC3D'){
      $scope.secDate = $stateParams.drawDatas['FTC'][0].gtKjsj.split(' ')[0];
    }else if($scope.code=='PL3'){
      $scope.secDate = $stateParams.drawDatas['FTC'][1].gtKjsj.split(' ')[0];
    }else if($scope.code=='TJKLSF'){
      $scope.secDate = $stateParams.drawDatas['KLSF'][0].gtKjsj.split(' ')[0];
    }else{
      $scope.secDate = $stateParams.drawDatas[$scope.code][0].gtKjsj.split(' ')[0];
    }

    if ($scope.curKind == curName) {
      return false;
    } else {
      $http.get(url, {
        params: {
          code: $scope.code,
          date: $scope.secDate
        },
        timeout: 30000
      }).then(function(res) {
        console.log(res);
        if (!res.data.rs) {
          return;
        }

        // if ($scope.code == "FC3D") {
        //   $scope.code = "FTC";
        // };
        if (res.data.datas.result) {
          $scope.totalDatas = res.data.datas.result;
        } else {
          $scope.totalDatas = [];
        }
        console.log($scope.totalDatas);
        $scope.totalCount = res.data.datas.totalCount;
        console.log($scope.totalCount);
        $scope.pageNums = Math.ceil($scope.totalCount / $scope.pageLimit);
      }, function(res) {
        console.log(res);
      });
    }
  };

  $scope.today = true;
  $scope.yesterday = false;
  $scope.beforeYes = false;
  $scope.secToday = function() {
    if (!$scope.today) {
      $scope.secDate = new Date().toLocaleString().split(' ')[0].replace(/\//g,'-');
      console.log($scope.secDate);
      $http.get(url, {
        params: {
          code: $scope.code,
          date: GetDateStr(new Date(),0)
        },
        timeout: 30000
      }).then(function(res) {
        console.log(res);
         if (!res.data.rs) {
          return;
        }
        if (res.data.datas.result) {
          $scope.totalDatas = res.data.datas.result;
        } else {
          $scope.totalDatas = [];
        }
        console.log($scope.totalDatas);
        $scope.totalCount = res.data.datas.totalCount;
        console.log($scope.totalCount);
        $scope.pageNums = Math.ceil($scope.totalCount / $scope.pageLimit);
      }, function(res) {
        console.log(res);
      });
    }
    $scope.today = true;
    $scope.yesterday = false;
    $scope.beforeYes = false;
  };
  $scope.secYes = function() {
    if (!$scope.yesterday) {
      $scope.secDate = GetDateStr(new Date(),-1);
      $http.get(url, {
        params: {
          code: $scope.code,
          date: GetDateStr(new Date(),-1)
        },
        timeout: 30000
      }).then(function(res) {
        console.log(res);
         if (!res.data.rs) {
          return;
        }
        if (res.data.datas.result) {
          $scope.totalDatas = res.data.datas.result;
        } else {
          $scope.totalDatas = [];
        }
        console.log($scope.totalDatas);
        $scope.totalCount = res.data.datas.totalCount;
        console.log($scope.totalCount);
        $scope.pageNums = Math.ceil($scope.totalCount / $scope.pageLimit);
      }, function(res) {
        console.log(res);
      });
    }
    $scope.today = false;
    $scope.yesterday = true;
    $scope.beforeYes = false;
  };
  $scope.secBef = function() {
    if (!$scope.beforeYes) {
      $scope.secDate = GetDateStr(new Date(),-2);
      $http.get(url, {
        params: {
          code: $scope.code,
          date: GetDateStr(new Date(),-2)
        },
        timeout: 30000
      }).then(function(res) {
        console.log(res);
         if (!res.data.rs) {
          return;
        }
        if (res.data.datas.result) {
          $scope.totalDatas = res.data.datas.result;
        } else {
          $scope.totalDatas = [];
        }
        console.log($scope.totalDatas);
        $scope.totalCount = res.data.datas.totalCount;
        console.log($scope.totalCount);
        $scope.pageNums = Math.ceil($scope.totalCount / $scope.pageLimit);
      }, function(res) {
        console.log(res);
      });
    }
    $scope.today = false;
    $scope.yesterday = false;
    $scope.beforeYes = true;
  };

  // $scope.accordDate = (new Date()).toLocaleDateString().replace(/\//g, '-');
  // console.log($scope.accordDate);

 //日期选择
  $scope.laydate = function() {
    return laydate({
      elem: '#laydate', //需显示日期的元素选择器
      event: 'click', //触发事件
      format: 'YYYY-MM-DD', //日期格式
      istime: false, //是否开启时间选择
      isclear: true, //是否显示清空
      istoday: true, //是否显示今天
      issure: true, //是否显示确认
      festival: true, //是否显示节日
      min: '1900-01-01 00:00:00', //最小日期
      max: '2099-12-31 23:59:59', //最大日期
      start: new Date(), //开始日期
      fixed: false, //是否固定在可视区域
      zIndex: 99999999, //css z-index
      choose: function(calendarDate) { //选择好日期的回调
        console.log(calendarDate);
        $scope.secDate = calendarDate;
        $http.get(url, {
          params: {
            code: $scope.code,
            date: calendarDate
          },
          timeout: 30000
        }).then(function(res) {
          console.log(res);
           if (!res.data.rs) {
          return;
           }
          if (res.data.datas.result) {
            $scope.totalDatas = res.data.datas.result;
          } else {
            $scope.totalDatas = [];
          }
          console.log($scope.totalDatas);
          $scope.totalCount = res.data.datas.totalCount;
          console.log($scope.totalCount);
          $scope.pageNums = Math.ceil($scope.totalCount / $scope.pageLimit);
        }, function(res) {
          console.log(res);
        });
      }
    });
  };

 //获取前天昨天日期方法
 function GetDateStr(day,AddDayCount) {
    var dd = new Date(day);
    //获取AddDayCount天后的日期
    dd.setDate(dd.getDate() + AddDayCount);
    var y = dd.getFullYear();
    //获取当前月份的日期
    var m = dd.getMonth() + 1 >= 10?dd.getMonth() + 1 : '0'+(dd.getMonth() + 1);
    var d = dd.getDate()>=10?dd.getDate():'0'+ dd.getDate();
    return y + "-" + m + "-" + d;
  }

  //分页
  $scope.firstPage = function() {
    if ($scope.first == 1&&$scope.curPageFlag == 1) {
      return false;
    }

    $scope.first = 1;
    $scope.second = 2;
    $scope.third = 3;
    $scope.curPageFlag = 1;
    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit: $scope.pageLimit,
        currentPage: $scope.pageNo1
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };

  $scope.secPage1 = function(){
    if($scope.curPageFlag == 1){
      return false;
    }
    // $scope.first = 1;
    // $scope.second = 2;
    // $scope.third = 3;
    $scope.curPageFlag = 1;
    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit:$scope.pageLimit,
        currentPage:$scope.pageNo1
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };

  $scope.secPage2 = function(){
    if($scope.curPageFlag == 2){
      return false;
    }
    // $scope.first = 1;
    // $scope.second = 2;
    // $scope.third = 3;
    $scope.curPageFlag = 2;
    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit:$scope.pageLimit,
        currentPage:$scope.pageNo2
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };

  $scope.secPage3 = function(){
    if($scope.curPageFlag == 3){
      return false;
    }
    // $scope.first = 1;
    // $scope.second = 2;
    // $scope.third = 3;
    $scope.curPageFlag = 3;
    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit:$scope.pageLimit,
        currentPage:$scope.pageNo3
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };

  $scope.nextPage = function(){
    if($scope.curPageFlag == 1){
      $scope.secPage2();
      return false;
    }
    if($scope.curPageFlag == 2){
      $scope.secPage3();
      return false;
    }
    $scope.curPageFlag = 3;
    // $scope.pageNo3 += 1;
    $scope.first += 1;
    $scope.second += 1;
    $scope.third += 1;
    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit:$scope.pageLimit,
        currentPage:$scope.pageNo3
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };

  $scope.lastPage = function() {
    $scope.curPageFlag = 3;//控制样式

    $scope.first = Number($scope.pageNums)-2;
    $scope.second = Number($scope.pageNums)-1;
    $scope.third = Number($scope.pageNums);

    $scope.pageNo1 = $scope.first;
    $scope.pageNo2 = $scope.second;
    $scope.pageNo3 = $scope.third;
    $http.get(url, {
      params: {
        code: $scope.code,
        date: $scope.secDate,
        pageLimit: $scope.pageLimit,
        currentPage: $scope.pageNums
      },
      timeout: 30000
    }).then(function(res) {
      console.log(res);
       if (!res.data.rs) {
          return;
        }
      $scope.totalDatas = res.data.datas.result;
      console.log($scope.totalDatas);
    }, function(res) {
      console.log(res);
    });
  };
}]);