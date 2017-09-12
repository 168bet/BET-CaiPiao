angular.module('cpApp').controller('bjpk10Ctrl', ['$stateParams', '$scope', '$rootScope', 'gameService', '$interval', '$timeout', 'ngDialog', 'UI', '$q', 'CPMisc',
    function($stateParams, $scope, $rootScope, gameService, $interval, $timeout, ngDialog, UI, $q, CPMisc) {
    //获取头部信息
    if ($stateParams.name) {
        localStorage.setItem('pk10Name', $stateParams.name);
    }
    
	// 内部数据
	$scope.data = {
		betClosed: false, // 停止下注
		closeTimeLeftLeft: 1,
		openTImeLeftLeft: 1,
		minBetMoney: 10, // 最小下注金额
		betQs: $stateParams.qs, // 投注期数 
	};
    
    getTopData();
    function getTopData() {
    	var defered = $q.defer();
        gameService.getData('/game/recent-issues', {
            params: {
                gameCode: localStorage.getItem('pk10Name')
            },
            timeout: 30000
        }).then(function(res) {
        	
            if (!res.data.rs) {
                return;
            }
            $rootScope.title = res.data.datas.gameCnName || '北京PK拾';
            $scope.lotKind = res.data.datas.gameCnName;
            localStorage.setItem('pk10Label', $scope.lotKind);
            $scope.lotEnName = res.data.datas.gameEnName;
            $scope.lastNumber = res.data.datas.lastNumber;
            $scope.lastResults = res.data.datas.lotteryBalls.split(',');
            $scope.gameNumbers = res.data.datas.gameNumbers;
            $scope.currentNumber = res.data.datas.currentNumber;
            //获取倒计时时间
            $scope.downTimeLeft = Number(res.data.datas.downTimeLeft);
            $scope.betSeconds = $scope.downTimeLeft;
            $scope.betAdvanceTime = Number(res.data.datas.betAdvanceTime);
            $scope.data.closeTimeLeft = {second: Number(res.data.datas.downTimeLeft)};
            $scope.data.openTimeLeft = {second: Number(res.data.datas.downTimeLeft) + Number(res.data.datas.betAdvanceTime)};
            
            console.log(['open & close time left', $scope.data.closeTimeLeft, $scope.data.openTimeLeft]);
        	
        	defered.resolve();
            
        }, function(error) {
        	defered.reject();
        });
        
        return defered.promise;
    }
    
    //开奖数据与分页
    $scope.pageLimit = 25; //每页默认显示条数
    $scope.currentPage = 1; //默认查询第一页
    $scope.pageIndex = 1; //默认最左边为1
    $scope.numberLimit = 3; //索引只显示1，2，3；若要1，2，3，4值值为4
    function getOpenData() {
        var resultsPromise = gameService.getData('/lotteryCenter/getAllGameTypeNewResultList', {
            params: {
                code: localStorage.getItem('pk10Name'),
                currentPage: $scope.currentPage,
                pageLimit: $scope.pageLimit
            },
            timeout: 30000
        });
        resultsPromise.then(function(res) {
            console.log(res);
            if (!res.data.rs) {
                return;
            }
            $scope.gameResults = res.data.datas.result;
            //分页
            $scope.totalCount = res.data.datas.totalCount;
            $scope.totalPages = Math.ceil($scope.totalCount / $scope.pageLimit);
        }, function(error) {
            console.log(error);
        });
    }
    getOpenData();
    //分页
    $scope.secPage = function(arg) {
        $scope.currentPage = arg;
    };
    $scope.firstPage = function() {
        $scope.currentPage = 1;
        $scope.pageIndex = 1;
    };
    $scope.lastPage = function() {
        $scope.currentPage = $scope.totalPages;
        $scope.pageIndex = $scope.totalPages - ($scope.numberLimit - 1);
    };
    $scope.nextPage = function() {
        if ($scope.currentPage == $scope.totalPages) {
            return;
        }
        if ($scope.currentPage == $scope.pageIndex + ($scope.numberLimit - 1)) {
            $scope.pageIndex++;
        }
        $scope.currentPage++;
    };
    $scope.prevPage = function() {
        if ($scope.currentPage == 1) {
            return;
        }
        if ($scope.currentPage == $scope.pageIndex) {
            $scope.pageIndex--;
        }
        $scope.currentPage--;
    };
    $scope.$watch('currentPage', function(newVal, oldVal) {
        if (newVal) {
            gameService.getData('/lotteryCenter/getAllGameTypeNewResultList', {
                params: {
                    code: localStorage.getItem('pk10Name'),
                    currentPage: newVal,
                    pageLimit: $scope.pageLimit
                },
                timeout: 30000
            }).then(function(res) {
                if (!res.data.rs) {
                    return;
                }
                $scope.gameResults = res.data.datas.result;
            }, function(error) {
                console.log(error);
            });
        }
    });
    //玩法tab切换
    $scope.curPlay = "SM"; //默认双面
    $scope.yzLists = {};
    $scope.yzLists.yzList = "yzzh"; //默认显示一字组合;
    $scope.ezLists = {};
    $scope.ezLists.ezList = "ezzh"; //默认显示二字组合;
    $scope.swTabs = {};
    $scope.swTabs.swTab = 'qsw'; //默认显示前三位;
    //赔率
    function getPL(code, code2) {
        gameService.getData('/game/server', {
            params: {
                code: code,
                code2: code2,
            },
            timeout: 30000
        }).then(function(res) {
                if (!res.data.rs) {
                    return ;
                }
                // console.log(res);
                $scope.pls = res.data.datas;
                $scope.cols = 5; //自定义列数
                $scope.sm_top_menu = ['大', '小', '单', '双', '龙', '虎'];
                $scope.sm_left_menu = ['冠军', '亚军', '季军', '第四名', '第五名', '第六名', '第七名', '第八名', '第九名', '第十名'];
                if ($scope.curPlay == 'SM') {
                    var menu_kinds = ['gj', 'yj', 'jj', 'd4m', 'd5m', 'd6m', 'd7m', 'd8m', 'd9m', 'd10m'];

                    var sm_filter = function(text) {
                        return function(value, key) {
                            return value.id.split('-')[1] == text.toUpperCase();
                        };
                    };
                    var filter_pls = [];
                    menu_kinds.forEach(function(kind, index) {
                        $scope[kind + '_pls'] = $scope.pls.filter(sm_filter(kind));
                        filter_pls.push($scope[kind + '_pls']);
                    });
                    // console.log(filter_pls);
                    $scope.filter_pls = (function() {
                        var result_pls = [];
                        filter_pls.forEach(function(a, b) {
                            a.rank = $scope.sm_left_menu[b];
                            a.sort = b;
                            result_pls.push(a);
                        });
                        return result_pls;
                    })();
                    //初始化money,重置
                    $scope.reset = function() {
                        angular.forEach($scope.filter_pls, function(arrItem, arrKey) {
                            angular.forEach(arrItem, function(item, key) {
                                item.money = '';
                                item.label = localStorage.getItem('pk10Name') == 'BJPK10' ? '北京PK10' : '北京PK10';
                                item.label2 = $scope.curPlay;
                            });
                        });
                    };
                    $scope.reset();
                    var existIds = [];
                    $scope.showOrderList = function() {
                        //表单提交数据
                        $scope.pk10BetDatas = [];
                        //获取填写金额的表单放入表单数组
                        angular.forEach($scope.filter_pls, function(arrItem, arrKey) {
                            angular.forEach(arrItem, function(item, key) {
                                if (item.money) {
                                	var newItem = angular.extend(item, {
                                    	uid: item.id,
                                    	rate: item.pl,
                                    	number: item.number,
                                    	xzje: item.money
                                	});
                                    $scope.pk10BetDatas.push(newItem);
                                }
                            });
                        });
                        $scope['pk10BetDatas'].forEach(function(item, index) {
                                existIds.push(item.uid);
                        });
                        //总金额
                        $scope.totalMoney = $scope.pk10BetDatas.reduce(function(a, b) {
                            return a + Number(b.xzje);
                        }, 0);
                        
                        if ($scope.pk10BetDatas.length <= 0) {
                        	UI.alert('请选择下注号码');
                        	return ;
                        }
                    	for (var i = 0; i < $scope.pk10BetDatas.length; i++) {
                    		if ($scope.pk10BetDatas[i].xzje < $scope.data.minBetMoney ) {
                    			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                    			return ;
                    		}
                    	}
                        
                        ngDialog.openConfirm({
                            template: 'pk10BetDialogSM',
                            scope: $scope,
                            plain: false,
                            className: 'ngdialog-theme-default'
                        }).then(function(res) {
                        	//gameCode, flag, data
                        	CPMisc.saveOrder(localStorage.getItem('pk10Name').toUpperCase(), CPMisc.NORMAL_FLAG, $scope.pk10BetDatas).then(function (res) {
                        		UI.alert(res.data.msg);
                        	});
                        	
                        }, function(reason) {});
                    };
                }
                else {
                	var curPlay_kinds = $scope.curPlay_kinds = ['gj', 'yj', 'jj', 'd4m', 'd5m', 'd6m', 'd7m', 'd8m', 'd9m', 'd10m','gyjh'];
                    $scope.curPlay_kinds.forEach(function(kind, index) {
                        if ($scope.curPlay == kind.toUpperCase()) {
                            //重置与添加money,label,label2属性
                            $scope.reset = function() {
                                angular.forEach($scope.pls, function(item, index) {
                                    item.money = '';
                                    item.label = localStorage.getItem('pk10Name') == 'BJPK10' ? '北京PK10' : '北京PK10';
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //弹窗提交数据
                            var existIds = [];
                            $scope.showOrderList = function() {
                                $scope[kind + '_betDatas'] = []; //存放提交数据
                                function kind_arg(kind) {
                                    return function(item, index) {
                                        if (item.money) {
                                        	var newItem = angular.extend(item, {
                                            	uid: item.id,
                                            	rate: item.pl,
                                            	number: item.number,
                                            	xzje: item.money
                                        	});
                                            $scope[kind + '_betDatas'].push(newItem);
                                        }
                                    };
                                }
                                angular.forEach($scope.pls, kind_arg(kind));
                                $scope[kind + '_betDatas'].forEach(function(item, index) {
                                    existIds.push(item.id);
                                });
                                $scope[kind + '_totalMoney'] = $scope[kind + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[kind + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[kind + '_betDatas'].length; i++) {
                            		if ($scope[kind + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                ngDialog.openConfirm({
                                    template: kind + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	CPMisc.saveOrder(localStorage.getItem('pk10Name'), CPMisc.NORMAL_FLAG, $scope[kind + '_betDatas']).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {
                                	
                                });
                            };
                        }
                    });
                }
            },
            function(error) {
                console.log(error);
            });
    }
    getPL(localStorage.getItem('pk10Name'), $scope.curPlay);
    //监听玩法获取不同玩法的赔率
    $scope.$watch('curPlay', function(newVal, oldVal) {
        if (newVal) {
            getPL(localStorage.getItem('pk10Name'), newVal);
        }
    });
    
    $scope.fun = {
    	closeTimeTickCb: function (time) {
    		$scope.data.closeTimeLeftLeft = time;
    		if (time <= 0) {
    			$scope.data.betClosed = true;
    			console.log("i'm pk 10 ");
    			UI.alert('第' + $scope.currentNumber + '期已经截至投注,请注意期号!');
    		}
    	},
    	openTimeTickCb: function (time) {
    		$scope.data.openTimeLeftLeft = time;
    		
    		console.log(['open time tick cb', time]);
    		
    		if (time <= 0) {
    			console.log('开奖后 重新加载数据');
    	        getTopData().then(function () {
    	        	console.log('重新加载数据成功');
    	        	$scope.data.betClosed = false;
    	        });
    		}
    	},
    	countdowntickCb: function (leftSecond) {
    		$scope.betSeconds = leftSecond;
    		
    		$scope.closeTimeLeft --;
    		$scope.openTimeLeft --;
    	},
    };
}]);