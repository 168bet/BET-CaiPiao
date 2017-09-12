angular.module('cpApp').controller('klsfCtrl', ['$rootScope', '$scope', 'gameService', '$stateParams', '$interval', '$timeout', 'ngDialog', 'UI' , '$q', 'CPMisc', 
    function($rootScope, $scope, gameService, $stateParams, $interval, $timeout, ngDialog, UI, $q, CPMisc) {
	
    $scope.data = {
		betClosed: false, // 停止下注
		closeTimeLeftLeft: 1,
		openTimeLeftLeft: 1,
		minBetMoney: 10, // 最小下注金额
   };
	console.log($stateParams);
    //获取头部信息
    if ($stateParams.name) {
        localStorage.setItem('klsfName', $stateParams.name);
    }
    if ($stateParams.qs) {
        localStorage.setItem('klsfQs', $stateParams.qs);
    }
    getTopData();

    function getTopData() {
    	var defered = $q.defer();
        gameService.getData('/game/recent-issues', {
            params: {
                gameCode: localStorage.getItem('klsfName')
            },
            timeout: 30000
        }).then(function(res) {
        	
        	defered.resolve();
        	
            if (!res.data.rs) {
                return;
            }
            $rootScope.title = res.data.datas.gameCnName || '快乐十分';
            $scope.lotKind = res.data.datas.gameCnName;
            $scope.lotEnName = res.data.datas.gameEnName;
            $scope.lastNumber = res.data.datas.lastNumber;
            $scope.lastResults = res.data.datas.lotteryBalls.split(',');
            $scope.currentNumber = res.data.datas.currentNumber;

            //获取倒计时时间
            $scope.downTimeLeft = Number(res.data.datas.downTimeLeft);
            $scope.betSeconds = $scope.downTimeLeft;
            $scope.betAdvanceTime = Number(res.data.datas.betAdvanceTime);
            $scope.data.closeTimeLeft = {second: $scope.downTimeLeft};
            $scope.data.openTimeLeft = {second: $scope.downTimeLeft + res.data.datas.betAdvanceTime};
            
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
                code: localStorage.getItem('klsfName'),
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
                    code: localStorage.getItem('klsfName'),
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
    //投注页面pl
    $scope.curPlay = 'D1Q'; //默认第一球
    $scope.colNum = 5; //页面布局每行列数
    getPls(localStorage.getItem('klsfName'), $scope.curPlay);

    function getPls(code, code2) {
        gameService.getData('/game/server', {
            params: {
                code: code,
                code2: code2,
            },
            timeout: 30000
        }).then(function(res) {
            if (!res.data.rs) {
                return;
            }
            $scope.pls = res.data.datas;
            $scope.curPlays = ['D1Q', 'D2Q', 'D3Q', 'D4Q', 'D5Q', 'D6Q', 'D7Q', 'D8Q'];
            $scope.curPlays.map(function(value, key) {
                if ($scope.curPlay == value) {
                    $scope[value.toLowerCase() + '_hm_pls'] = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'HM';
                    });
                    $scope[value.toLowerCase() + '_hm_pls_rows'] = Math.ceil($scope[value.toLowerCase() + '_hm_pls'].length / $scope.colNum);
                    $scope[value.toLowerCase() + '_sm_pls'] = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'SM';
                    });
                    $scope[value.toLowerCase() + '_sm_pls_rows'] = Math.ceil($scope[value.toLowerCase() + '_sm_pls'].length / $scope.colNum);
                    //重置
                    $scope.reset = function() {
                        $scope.pls.forEach(function(item, index) {
                            item.money = '';
                            item.label = localStorage.getItem('klsfName') == 'GDKLSF' ? '广东快乐十分' : '天津快乐十分';
                            item.label2 = $scope.curPlay;
                        });
                    };
                    $scope.reset();
                    //投注
                    $scope.showOrderList = function() {
                        //弹窗表单数据
                        $scope[value.toLowerCase() + '_betDatas'] = [];
                        $scope.pls.forEach(function(item, index) {
                            if (item.money) {
                            	var newItem = angular.extend(item, {
                                	uid: item.id,
                                	rate: item.pl,
                                	number: item.number,
                                	xzje: item.money
                            	});
                                $scope[value.toLowerCase() + '_betDatas'].push(newItem);
                            }
                        });
                        //总金额
                        $scope[value.toLowerCase() + '_totalMoney'] = $scope[value.toLowerCase() + '_betDatas'].reduce(function(a, b) {
                            return a + Number(b.money);
                        }, 0);
                        
                        if ($scope[value.toLowerCase() + '_betDatas'].length < 1) {
                        	UI.alert('请选择下注号码');
                        	return ;
                        }

                        for (var i = 0; i < $scope[value.toLowerCase() + '_betDatas'].length; i++) {
                        	if ($scope[value.toLowerCase() + '_betDatas'][i].xzje < $scope.data.minBetMoney) {
                        		UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                    			return ;
                        	}
                        }
                        
                        //弹窗
                        ngDialog.openConfirm({
                            template: value.toLowerCase() + '_betDialog',
                            scope: $scope,
                            plain: false,
                            className: 'ngdialog-theme-default'
                        }).then(function(res) {
                            gameService.getData('/cpOrder/saveOrder', {
                                params: {
                                    'qs':localStorage.getItem('klsfQs'),
                                    'jsons': angular.toJson($scope[value.toLowerCase() + '_betDatas']),
                                    'gameCode': localStorage.getItem('klsfName'),
                                    'orderFlag': 'normal'
                                },
                                timeout: 30000
                            }).then(function(res) {
                                UI.alert(res.data.msg);
                                return;
                            }, function(error) {});
                        }, function(reason) {});
                    };
                }
            });
            if ($scope.curPlay == 'ZHLH') {
                $scope.zhlh_pls = $scope.pls;
                $scope.zhlh_rows = Math.ceil($scope.zhlh_pls.length / $scope.colNum);
                //重置
                $scope.reset = function() {
                    $scope.pls.forEach(function(item, index) {
                        item.money = '';
                        item.label = localStorage.getItem('klsfName') == 'GDKLSF' ? '广东快乐十分' : '天津快乐十分';
                        item.label2 = $scope.curPlay;
                    });
                };
                $scope.reset();
                //投注
                $scope.showOrderList = function() {
                    //弹窗表单数据
                    $scope['zhlh' + '_betDatas'] = [];
                    $scope.pls.forEach(function(item, index) {
                        if (item.money) {
                        	
                        	var newItem = angular.extend(item, {
                            	uid: item.id,
                            	rate: item.pl,
                            	number: item.number,
                            	xzje: item.money
                        	});
                        	
                            $scope['zhlh' + '_betDatas'].push(newItem);
                        }
                    });
                    //总金额
                    $scope['zhlh' + '_totalMoney'] = $scope['zhlh' + '_betDatas'].reduce(function(a, b) {
                        return a + Number(b.money);
                    }, 0);
                    
                    if ($scope['zhlh' + '_betDatas'].length < 1) {
                    	UI.alert('请选择下注号码');
                    	return ;
                    }
                    for (var i = 0; i < $scope['zhlh' + '_betDatas'].length; i++) {
                    	if ($scope['zhlh' + '_betDatas'][i].xzje < $scope.data.minBetMoney) {
                    		UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                			return ;
                    	}
                    }
                    
                    //弹窗
                    ngDialog.openConfirm({
                        template: 'zhlh' + '_betDialog',
                        scope: $scope,
                        plain: false,
                        className: 'ngdialog-theme-default'
                    }).then(function(res) {
                        gameService.getData('/cpOrder/saveOrder', {
                            params: {
                                'qs':localStorage.getItem('klsfQs'),
                                'jsons': angular.toJson($scope['zhlh' + '_betDatas']),
                                'gameCode': localStorage.getItem('klsfName'),
                                'orderFlag': 'normal'
                            },
                            timeout: 30000
                        }).then(function(res) {
                            UI.alert(res.data.msg);
                            return;
                        }, function(error) {});
                    }, function(reason) {});
                };
            }
            if ($scope.curPlay == 'LM') {
                var filter_lm = function(text) {
                    return function(item, index) {
                        return item.id.split('-')[1] == text;
                    };
                };
                $scope.lm_kinds = ['RX2', 'RX3', 'RX4', 'RX5'];
                $scope.lm_kinds.forEach(function(value, index) {
                    $scope[value.toLowerCase() + '_pls'] = $scope.pls.filter(filter_lm(value));
                    $scope[value.toLowerCase() + '_rows'] = Math.ceil($scope[value.toLowerCase() + '_pls'].length / $scope.colNum);
                });
                //重置
                $scope.reset = function() {
                    $scope.pls.forEach(function(item, index) {
                        item.money = '';
                        item.label = localStorage.getItem('klsfName') == 'GDKLSF' ? '广东快乐十分' : '天津快乐十分';
                        item.label2 = $scope.curPlay;
                    });
                };
                $scope.reset();
                //投注
                $scope.showOrderList = function() {
                    //弹窗表单数据
                    $scope['lm' + '_betDatas'] = [];
                    $scope.pls.forEach(function(item, index) {
                        if (item.money) {
                            item.money = $scope.perMoney;
                            
                            var newItem = angular.extend(item, {
                            	uid: item.id,
                            	rate: item.pl,
                            	number: item.number,
                            	xzje: item.money
                        	});
                            
                            $scope['lm' + '_betDatas'].push(newItem);
                        }
                    });
                    //总金额
                    $scope['lm' + '_totalMoney'] = $scope['lm' + '_betDatas'].reduce(function(a, b) {
                        return a + Number(b.money);
                    }, 0);
                    
                    if ($scope['lm' + '_betDatas'].length < 1) {
                    	UI.alert('请选择下注号码');
                    	return ;
                    }
                    for (var i = 0; i < $scope['lm' + '_betDatas'].length; i++) {
                    	if ($scope['lm' + '_betDatas'][i].xzje < $scope.data.minBetMoney) {
                    		UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                			return ;
                    	}
                    }
                    
                    //弹窗
                    ngDialog.openConfirm({
                        template: 'lm' + '_betDialog',
                        scope: $scope,
                        plain: false,
                        className: 'ngdialog-theme-default'
                    }).then(function(res) {
                        gameService.getData('/cpOrder/saveOrder', {
                            params: {
                                'qs':localStorage.getItem('klsfQs'),
                                'jsons': angular.toJson($scope['lm' + '_betDatas']),
                                'gameCode': localStorage.getItem('klsfName'),
                                'orderFlag': 'normal'
                            },
                            timeout: 30000
                        }).then(function(res) {
                            UI.alert(res.data.msg);
                            return;
                        }, function(error) {});
                    }, function(reason) {});
                };
            }
        }, function(error) {});
    }
    $scope.$watch('curPlay', function(newVal, oldVal) {
        if (newVal) {
            getPls(localStorage.getItem('klsfName'), newVal);
        }
    });
    
    $scope.fun = {
    	closeTimeTickCb: function (time) {
    		$scope.data.closeTimeLeftLeft = time;
    		if (time <= 0) {
    			$scope.data.betClosed = true;
    			UI.alert('第' + $scope.currentNumber + '期已经截至投注,请注意期号!', true);
    		}
    	},
    	openTimeTickCb: function (time) {
    		$scope.data.openTimeLeftLeft = time;
    		 
    		if (time <= 0) {
    			console.log('已开奖重新获取数据');
    	        getTopData().then(function () {
    	        	console.log('重新获取数据成功');
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