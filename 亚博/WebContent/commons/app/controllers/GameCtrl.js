angular.module('cpApp')
    .controller('GameCtrl', ['$rootScope', '$scope', '$stateParams', '$interval', '$timeout', 'gameService', '$http', 'ngDialog', 'UI', 'CPMisc', '$q', '$state',
    function($rootScope, $scope, $stateParams, $interval, $timeout, gameService, $http, ngDialog, UI, CPMisc, $q, $state) {
    	
    	
    	// 内部数据
    	$scope.data = {
    		betClosed: false, // 停止下注
    		closeTimeLeftLeft: {second: 1},
    		openTImeLeftLeft: {second: 1},
    		minBetMoney: 10,
    		betWin: {betUsrWin: '---', winMoney: '---', xzje: '---'},
    		betQs: $stateParams.qs, // 投注期数 
    	};
        if ($stateParams.name) {
            localStorage.setItem('xy28Name', $stateParams.name);
        }
        $scope.gameNames = {
            BJKL8: '幸运28',
            CAKENO: '加拿大28',
            xjp28: '新加坡28'
        };
        $scope.gameName = $scope.gameNames[localStorage.getItem('xy28Name')];

    	$rootScope.setTitle($scope.gameName);
        //倒计时
        getTopData();
        
        function getTopData() {
        	var defered = $q.defer();
            gameService.getData('/game/recent-issues', {
                params: {
                    gameCode: localStorage.getItem('xy28Name'),
                    qs: $scope.data.betQs
                },
                timeout: 30000
            }).then(function(res) {
                if (!res.data.rs) {
                	UI.exceptionAlert(res['data']['msg'], false);
                    return;
                }
            	$rootScope.setTitle(res.data.datas.gameCnName|| '数字游戏');
                $scope.bol = res.data.datas.bol;
                $scope.gameNumbers = res.data.datas.gameNumbers;
                $scope.lotKind = res.data.datas.gameCnName;
                $scope.lotEnName = res.data.datas.gameEnName;
                $scope.lastNumber = res.data.datas.lastNumber;
                $scope.lastResults = res.data.datas.lotteryBalls.split(',');
                $scope.resultsNumbers = res.data.datas.resultsNumbers;
                $scope.data.betWin = res.data.datas.lostWin;
                $scope.xy28 = $scope.lastResults.reduce(function(a, b) {
                    return a + Number(b);
                }, 0);
                $scope.currentNumber = res.data.datas.currentNumber;
                
                //获取倒计时时间
                $scope.downTimeLeft = Number(res.data.datas.downTimeLeft);
                $scope.betSeconds = $scope.downTimeLeft;
                $scope.betAdvanceTime = Number(res.data.datas.betAdvanceTime);
                $scope.data.closeTimeLeft = {second: $scope.downTimeLeft};
                $scope.data.openTimeLeft = {second: $scope.downTimeLeft + res.data.datas.betAdvanceTime}; // 开奖截至时间
                
	        	$scope.fun.switchBetQsToValid($scope.data.betQs, $scope.gameNumbers);
                
                // 回调通知
                defered.resolve();
                
            }, function(error) {
            	defered.reject();
            });
            
            return defered.promise;
        }
        //开奖结果

        $scope.pageLimit = 25; //每页默认显示条数
        $scope.currentPage = 1; //默认查询第一页
        $scope.pageIndex = 1; //默认最左边为1
        $scope.numberLimit = 3; //索引只显示1，2，3；若要1，2，3，4值值为4
        function getOpenData() {
            var resultsPromise = gameService.getData('/lotteryCenter/getAllGameTypeNewResultList', {
                params: {
                    code: localStorage.getItem('xy28Name'),
                    currentPage: $scope.currentPage,
                    pageLimit: $scope.pageLimit
                },
                timeout: 30000
            });
            resultsPromise.then(function(res) {
                if (!res.data.rs) {
                    return;
                }
                $scope.gameResults = res.data.datas.result;
                //分页
                $scope.totalCount = res.data.datas.totalCount;
                $scope.totalPages = Math.ceil($scope.totalCount / $scope.pageLimit);
            }, function(error) {
            	
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
                        code: localStorage.getItem('xy28Name'),
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
                	
                });
            }
        });

        //赔率
        var oddsPromise = gameService.getData('/game/server', {
            params: {
                'code': 'BJKL8',
                'code2': 'TM'
            },
            timeout: 30000
        });
        oddsPromise.then(function(res) {
            $scope.oddsDatas = res.data.datas;

            $scope.oddsDatas.map(function(a) {
                a.money = '';
                return a;
            });
            $scope.dataTMBS = $scope.oddsDatas.filter(function(a, b) {
                return a.id == 'TM-KL8TM-TMSB';
            });
            $scope.hunhe_1 = $scope.oddsDatas.slice(29, 34);
            // console.log($scope.hunhe_1);
            $scope.hunhe_2 = $scope.oddsDatas.slice(34, 39);
            // console.log($scope.hunhe_2);
            $scope.bose = (function() {
                var arr = [{}, {}, {}, {}, {}];
                angular.forEach($scope.oddsDatas, function(item, index) {
                    if (item.id == "TM-KL8TM-RED") {
                        arr[0] = item;
                    }
                    if (item.id == "TM-KL8TM-GREEN") {
                        arr[1] = item;
                    }
                    if (item.id == "TM-KL8TM-BLUE") {
                        arr[2] = item;
                    }
                });
                return arr;
            })();
            // console.log($scope.bose);
            //豹子处理
            $scope.baozi = $scope.oddsDatas.filter(function(a, b) {
                return a.id == 'TM-KL8TM-BAOZI';
            });
            $scope.baozi.unshift({});
            $scope.baozi.unshift({});
            $scope.baozi.push({});
            $scope.baozi.push({});
        }, function(error) {});

        //投注
        $scope.dialogTM = {};
        $scope.dialogTMBS = {};
        $scope.dialogHunde = {};
        $scope.dialogBose = {};
        $scope.dialogBaozi = {};
        $scope.gameRecords = []; //游戏记录
        $scope.getGameRecord = function() {
            var gameRecordPromise = gameService.getData('/cpOrder/getCpOrderList', {
                params: {
                    gameTypeCode: localStorage.getItem('xy28Name'),
                    xzdh: '',
                    beginTime: gameService.GetDateStr(new Date(), -300, true),
                    endTime: CPMisc.formatdate(new Date(), true),
                    status: '',
                    pageLimit: 10
                },
                timeout: 30000
            });
            gameRecordPromise.then(function(res) {
                if (!res.data.rs) {
                    return;
                }
                $scope.gameRecords = res.data.datas.result;
                $scope.gameRecords_format = $scope.gameRecords.map(function(a) {
//                    a.betTime = CPMisc.formatdate(new Date(a.XZSJ), true);
//                    var openDate = new Date(a.OPEN_TIME);
//                    if (openDate.isValid()) {
//                        a.openTime = CPMisc.formatdate(new Date(a.OPEN_TIME), true);
//                    } 
//                    else {
//                    	a.openTime = '0000-00-00 00:00:00';
//                    }
                    return a;
                });
            }, function(error) {
            	
            });
        };
        $scope.getGameRecord();
        $scope.bet = function() {
        	
        	// 已经关闭投注 ?? 
        	if ($scope.data.betClosed) {
        		UI.alert('对不起, 当前期已关闭');
        		return ;
        	}
        	
            $scope.$watch('oddsDatas', function(newVal, oldVal) {
                angular.forEach(newVal, function(a, b) {
                    if (b >= 0 && b < 27) {
                        $scope.dialogTM[a.number] = a.money;
                        // console.log($scope.dialogTM);
                    }
                    if (b == 28) {
                        $scope.dialogTMBS[a.number] = a.money;
                        // console.log($scope.dialogTMBS);
                    }
                    if (b >= 29 && b <= 38) {
                        $scope.dialogHunde[a.number] = a.money;
                        // console.log($scope.dialogHunde);
                    }
                    if (b >= 39 && b <= 41) {
                        $scope.dialogBose[a.number] = a.money;
                        // console.log($scope.dialogBose);
                    }
                    if (a.id == "TM-KL8TM-BAOZI") {
                        $scope.dialogBaozi[a.number] = a.money;
                        // console.log($scope.dialogBaozi);
                    }
                });
            });
            $scope.ballTMBS1 = 1;
            $scope.ballTMBS2 = 1;
            $scope.ballTMBS3 = 1;
            $scope.ballsTMBS = String($scope.ballTMBS1) + ',' + String($scope.ballTMBS2) + ',' + String($scope.ballTMBS3);
            $scope.totalMoney = $scope.oddsDatas.reduce(function(a, b) {
                // if(!angular.isNumber(a.money)){a.money = 0};
                if (isNaN(Number(b.money))) {
                	b.money = 0;
                }
                return a + Number(b.money);
            }, 0);

            //提交数据
            $scope.orderJsons = [];
            angular.forEach($scope.oddsDatas, function(item, index) {
            	betNumbersEmpty = false;
                $scope.orderJson = {
                    "uid": item.id,
                    "rate": item.pl,
                    "betQs": $scope.betQs,
                    "label": "PC蛋蛋",
                    "label2": $scope.gameName,
                    "xzje": item.money,
                    "number": item.number
                };
                if ($scope.orderJson.xzje) {
                    $scope.orderJsons.push($scope.orderJson);
                }
            });
            if ($scope.orderJsons.length <= 0) {
            	UI.alert('请填写投注内容!');
            	return ;
            }
            
            for (var i = 0; i < $scope.orderJsons.length; i++) {
            	if ($scope.orderJsons[i].xzje < $scope.data.minBetMoney) {
            		UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
        			return ;
            	}
            }
            
            ngDialog.openConfirm({
                template: 'betDialog',
                scope: $scope,
                plain: false,
                className: 'ngdialog-theme-default'
            }).then(
                function(value) {
                	//gameCode, flag, data 
                	CPMisc.saveOrder(localStorage.getItem('xy28Name'), CPMisc.NORMAL_FLAG, $scope.orderJsons, $scope.data.betQs).then(function (res) {
                		if (res.data.state === 0) {
                            UI.alert(res.data.msg);
                            return ;
                        }
                        if (res.data.state == 1) {
                            UI.alert(res.data.msg);
                            $scope.getGameRecord(); //更新游戏记录
                        }
                        
                        $scope.reset();
                	});
                },
                function(reason) {
                    // console.log('rejected, reason - ', reason);
                }
            );
        };
        //更新游戏记录
        $scope.getGameRecord();
        //弹窗标题显示控制
        $scope.showDialogTitle = function(value) {
            for (var index in value) {
                if (value[index]) {
                    return true;
                }
            }
            return false;
        };
        //重置
        $scope.reset = function() {
            $scope.oddsDatas.map(function(a, b) {
                a.money = '';
                return a;
            });
        };
        
        var i = 0;
        $scope.fun = {
        	closeTimeTickCb: function (time) {
        		$scope.data.closeTimeLeftLeft = time;
        		if (time <= 0) {
        			$scope.data.betClosed = true;
        			$scope.reset();
        			UI.alert('第' + $scope.currentNumber + '期已经截至投注,请注意期号!');
        		}
        	},
        	openTimeTickCb: function (time) {
        		$scope.data.openTimeLeftLeft = time;
        		 
        		if (time <= 0) {
        			
        			getOpenData();
        			
        	        getTopData().then(function () {
        	        	$scope.data.betClosed = false;
        	        	$scope.fun.switchBetQsToValid($scope.data.betQs, $scope.gameNumbers);
        	        });
        		}
        	},
        	countdowntickCb: function (leftSecond) {
        		$scope.betSeconds = leftSecond;
        		
        		$scope.closeTimeLeft --;
        		$scope.openTimeLeft --;
        	},
        	switchBetQsToValid: function (betQs, gameNumbers) {
        		console.log(['switch to bet qs', betQs, gameNumbers]);
        		// 检查当前期数是否符合开奖期数范围
                var validBetQs = false;
                angular.forEach(gameNumbers, function (gameNum) {
                	if (gameNum['number'] == betQs) {
                		validBetQs = true;
                	}
                });
                // 如果不是合理的期数 则返回一个合理的
                if (!validBetQs) {
                	$scope.data.betQs = gameNumbers[0]['number'];
                	var params = angular.extend({}, $state.params, {
                		qs: $scope.data.betQs
                	});
                	$state.go($state.current.name, params, {
                		location: false,
                		notify: false,
                		inherit: false,
                		reload: false,
                	});
                }
        	}
        };

    }]);