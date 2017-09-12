angular.module('cpApp').controller('sscCtrl', ['$rootScope', '$scope', 'gameService', '$stateParams', '$interval', '$timeout', 'ngDialog', 'UI', '$q', 'CPMisc',
    function($rootScope, $scope, gameService, $stateParams, $interval, $timeout, ngDialog, UI, $q, CPMisc) {
    //获取头部信息
    if ($stateParams.name) {
        localStorage.setItem('sscName', $stateParams.name);
    }
    if ($stateParams.qs) {
        localStorage.setItem('sscQs', $stateParams.qs);
    }
    getTopData();
    
    $scope.data = {
		betClosed: false, // 停止下注
		closeTimeLeftLeft: 1,
		openTimeLeftLeft: 1,
		minBetMoney: 10, // 最小下注金额
		betQs: $stateParams.qs, // 投注期数 
    };

    function getTopData() {
    	var defered = $q.defer();
        gameService.getData('/game/recent-issues', {
            params: {
                gameCode: localStorage.getItem('sscName')
            },
            timeout: 30000
        }).then(function(res) {
        	defered.resolve();
            if (!res.data.rs) {
                return ;
            }
            $rootScope.title = res.data.datas.gameCnName || '时时彩';
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
                code: localStorage.getItem('sscName'),
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
                    code: localStorage.getItem('sscName'),
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
    $scope.curPlay = "ZPS"; //默认主盘式
    $scope.yzLists = {};
    $scope.yzLists.yzList = "yzzh"; //默认显示一字组合;
    $scope.ezLists = {};
    $scope.ezLists.ezList = "ezzh"; //默认显示二字组合;
    $scope.swTabs = {};
    $scope.swTabs.swTab = 'qsw'; //默认显示前三位;
    //label名字
    function getLabelName() {
        if (localStorage.getItem('sscName') == 'CQSSC') {
            return '重庆时时彩';
        } else if (localStorage.getItem('sscName') == 'TJSSC') {
            return '天津时时彩';
        } else if (localStorage.getItem('sscName') == 'XJSSC') {
            return '新疆时时彩';
        } else {
            return '时时彩';
        }
    }
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
                    return;
                }
                // console.log(res);
                $scope.pls = res.data.datas;
                $scope.cols = 5; //自定义列数
                if ($scope.curPlay == "ZPS") {
                    var zps_pls = ['YZZH', 'WDW', 'QDW', 'BDW', 'SDW', 'GDW'];
                    var zps_filter = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text;
                        };
                    };
                    zps_pls.map(function(value, key) {
                        $scope[value.toLowerCase() + 'Pls'] = $scope.pls.filter(zps_filter(value));
                    });
                    //重置
                    $scope.reset = function() {
                        $scope.pls.forEach(function(item, index) {
                            item.money = '';
                            item.label = getLabelName();
                            item.label2 = $scope.curPlay;
                        });
                    };
                    $scope.reset();
                    //投注
                    $scope.showOrderList = function() {
                        $scope.zps_betDatas = [];
                        //获取填写金额的选项
                        $scope.pls.forEach(function(item, index) {
                            if (item.money) {
                            	var newItem = angular.extend(item, {
                                	uid: item.id,
                                	rate: item.pl,
                                	number: item.number,
                                	xzje: item.money
                            	});
                                $scope.zps_betDatas.push(newItem);
                            }
                        });
                        //总金额
                        $scope.zps_totalMoney = $scope.zps_betDatas.reduce(function(a, b) {
                            return a + Number(b.money);
                        }, 0);
                        
                        if ($scope.zps_betDatas.length <= 0) {
                        	UI.alert('请选择下注号码');
                        	return ;
                        }
                        
                        for (var i = 0; i < $scope.zps_betDatas.length; i++) {
                        	if ($scope.zps_betDatas[i].xzje < $scope.data.minBetMoney) {
                        		UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                    			return ;
                        	}
                        }
                        
                        //弹窗
                        ngDialog.openConfirm({
                            template: 'zps_betDialog',
                            scope: $scope,
                            plain: false,
                            className: 'ngdialog-theme-default'
                        }).then(function(res) {
                        	
                        	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope.zps_betDatas).then(function (res) {
                                UI.alert(res.data.msg);
                                return;
                        	});
                        	
                        }, function(reason) {});
                    };
                }
                if ($scope.curPlay == "YZ") {
                    $scope.qwyzzhPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('_')[0] == 'YZ-YZZH-QW';
                    });
                    $scope.qsyzzhPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('_')[0] == 'YZ-YZZH-QSW';
                    });
                    $scope.zsyzzhPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('_')[0] == 'YZ-YZZH-ZSW';
                    });
                    $scope.hsyzzhPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('_')[0] == 'YZ-YZZH-HSW';
                    });
                    $scope.yzzh_pls = {
                        '全五一字组合': $scope.qwyzzhPls,
                        '前三一字组合': $scope.qsyzzhPls,
                        '中三一字组合': $scope.zsyzzhPls,
                        '后三一字组合': $scope.hsyzzhPls
                    };
                    $scope.yzzhPls = $scope.qwyzzhPls.concat($scope.qsyzzhPls).concat($scope.zsyzzhPls).concat($scope.hsyzzhPls);
                    $scope.wdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'WDW';
                    });
                    $scope.wdwNumPls = $scope.wdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    $scope.qdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'QDW';
                    });
                    $scope.qdwNumPls = $scope.qdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    $scope.bdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'BDW';
                    });
                    $scope.bdwNumPls = $scope.bdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    $scope.bdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'BDW';
                    });
                    $scope.bdwNumPls = $scope.bdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    $scope.sdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'SDW';
                    });
                    $scope.sdwNumPls = $scope.sdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    $scope.gdwPls = $scope.pls.filter(function(item, index) {
                        return item.id.split('-')[1] == 'GDW';
                    });
                    $scope.gdwNumPls = $scope.gdwPls.filter(function(item, index) {
                        var num = item.id.split('-')[2];
                        return !isNaN(Number(num));
                    });
                    var yz_kinds = ['yzzh', 'wdw', 'qsw', 'bdw', 'sdw', 'gdw'];
                    $scope.$watch('yzLists.yzList', function(newVal, oldVal) {
                        if (newVal) {
                            $scope.reset = function() {
                                $scope[newVal + 'Pls'].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope[newVal + 'Pls'].forEach(function(item, index) {
                                    if (item.money) {
                                    	var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                        $scope[newVal + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                                
                                for (var i = 0; i < $scope[newVal + '_betDatas'].length; i++) {
                                	if ($scope[newVal + '_betDatas'][i].xzje < $scope.data.minBetMoney) {
                                    	UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                                	}
                                }
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal + '_betDatas']).then(function () {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                }, function(reason) {});
                            };
                        }
                    });
                }
                if ($scope.curPlay == 'EZ') {
                    $scope.ez_kinds = ['ezzh_qsw', 'ezzh_zsw', 'ezzh_hsw', 'bsdw_qsw', 'bsdw_zsw', 'bsdw_hsw', 'bgdw_qsw', 'bgdw_zsw', 'bgdw_hsw', 'sgdw_qsw', 'sgdw_zsw', 'sgdw_hsw', 'bghs_qsw', 'bghs_zsw', 'bghs_hsw', 'sghs_qsw', 'sghs_zsw', 'sghs_hsw'];
                    //写这个函数方便传参
                    var filter_ezFun = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text.split('_')[0].toUpperCase() && item.id.split('-')[2] == text.split('_')[1].toUpperCase();
                        };
                    };
                    //分割传过来的数据数组方便渲染
                    $scope.ez_kinds.map(function(value, key) {
                        $scope[value] = $scope.pls.filter(filter_ezFun(value));
                    });
                    //行数控制
                    $scope.ez_kinds.map(function(value, key) {
                        $scope[value + '_lines'] = Math.ceil($scope[value].length / $scope.cols);
                    });
                    //投注
                    $scope.$watch('[ezLists.ezList,swTabs.swTab]', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope[newVal[0] + '_' + newVal[1]].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal[0] + '_' + newVal[1] + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope[newVal[0] + '_' + newVal[1]].forEach(function(item, index) {
                                    if (item.money) {
                                    	var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                        $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal[0] + '_' + newVal[1] + '_totalMoney'] = $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal[0] + '_' + newVal[1] + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].length; i++) {
                            		if ($scope[newVal[0] + '_' + newVal[1] + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal[0] + '_' + newVal[1] + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	
                                	CPMIsc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal[0] + '_' + newVal[1] + '_betDatas']).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
                if ($scope.curPlay == 'SZ') {
                    $scope.szLists = {};
                    $scope.szLists.szList = 'szzh'; //默认显示三字组合
                    $scope.sz_kinds = ['szzh_qsw', 'szzh_zsw', 'szzh_hsw', 'bsgdw_qsw', 'bsgdw_zsw', 'bsgdw_hsw', 'bsghs_qsw', 'bsghs_zsw', 'bsghs_hsw'];
                    //写这个函数方便传参
                    var filter_szFun = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text.split('_')[0].toUpperCase() && item.id.split('-')[2] == text.split('_')[1].toUpperCase();
                        };
                    };
                    //分割传过来的数据数组方便渲染
                    $scope.sz_kinds.map(function(value, key) {
                        $scope[value] = $scope.pls.filter(filter_szFun(value));
                    });
                    //行数控制
                    $scope.sz_kinds.map(function(value, key) {
                        $scope[value + '_lines'] = Math.ceil($scope[value].length / $scope.cols);
                    });
                    //投注
                    $scope.$watch('[szLists.szList,swTabs.swTab]', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope[newVal[0] + '_' + newVal[1]].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal[0] + '_' + newVal[1] + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope[newVal[0] + '_' + newVal[1]].forEach(function(item, index) {
                                    if (item.money) {
                                    	var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                        $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal[0] + '_' + newVal[1] + '_totalMoney'] = $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal[0] + '_' + newVal[1] + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[newVal[0] + '_' + newVal[1] + '_betDatas'].length; i++) {
                            		if ($scope[newVal[0] + '_' + newVal[1] + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal[0] + '_' + newVal[1] + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal[0] + '_' + newVal[1] + '_betDatas']).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
                if ($scope.curPlay == 'YZGG') {
                    $scope.yzzh_qsw = $scope.pls.filter(function(value, index) {
                        return value.id.split('-')[1] == 'QSW';
                    });
                    $scope.yzzh_zsw = $scope.pls.filter(function(value, index) {
                        return value.id.split('-')[1] == 'ZSW';
                    });
                    $scope.yzzh_hsw = $scope.pls.filter(function(value, index) {
                        return value.id.split('-')[1] == 'HSW';
                    });
                    $scope.yzzh_qsw_lines = Math.ceil($scope.yzzh_qsw.length / 3);
                    $scope.yzzh_zsw_lines = Math.ceil($scope.yzzh_zsw.length / 3);
                    $scope.yzzh_hsw_lines = Math.ceil($scope.yzzh_hsw.length / 3);
                    //投注
                    $scope.$watch('swTabs.swTab', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope['yzzh_' + newVal].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope['yzzh_' + newVal].forEach(function(item, index) {
                                    if (item.money) {
                                    	if (!$scope.swTabs.perMoney) {
                                    		$scope.swTabs.perMoney = 0;
                                    	}
                                        item.money = $scope.swTabs.perMoney;
                                        var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                        
                                        $scope[newVal + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[newVal + '_betDatas'].length; i++) {
                            		if ($scope[newVal + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal + '_betDatas']).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
                if ($scope.curPlay == 'ZXS' || $scope.curPlay == 'ZXL') {
                    var zxs_kinds = ['zxs_qsw', 'zxs_zsw', 'zxs_hsw'];
                    var minNumRequired = $scope.curPlay == 'ZXS' ? 5: 4;

                    var zxs_filter = function(kind) {
                        return function(item, index) {
                            return item.id.split('-')[1] == kind.split('_')[1].toUpperCase();
                        };
                    };
                    zxs_kinds.forEach(function(kind, index) {
                        $scope[kind] = $scope.pls.filter(zxs_filter(kind));
                    });
                    //投注
                    $scope.$watch('swTabs.swTab', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope['zxs_' + newVal].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal + '_betDatas'] = [];
                                $scope.checkedCount = 0;
                                //获取填写金额的选项
                                $scope['zxs_' + newVal].forEach(function(item, index) {
                                    if (item.money) {
                                        $scope.checkedCount++;
                                        
                                        var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: $scope.swTabs.perMoney
                                    	});
                                        
                                        $scope[newVal + '_betDatas'].push(newItem);
                                    }
                                });
                                if ($scope.checkedCount >= minNumRequired) {
                                	
                                    gameService.getData('/cpOrder/getGroupOrderList', {
                                        params: {
                                            num: $scope[newVal + '_betDatas'].map(function(item, index) {
                                                return item.number;
                                            }).join(','),
                                            gameCode: localStorage.getItem('sscName'),
                                            typeCode: $scope.curPlay,
                                            cateCode: $scope.swTabs.swTab.toUpperCase(),
                                            multilen: $scope.curPlay == 'ZXS'?'3':'6'
                                        },
                                        timeout: 30000
                                    }).then(function(res) {
                                        console.log(res);
                                        $scope.swTabs.token = res.data.token;
                                        $scope.swTabs.orderList = res.data.orderList;
                                    }, function(error) {});
                                } else {
                                    UI.alert('至少选择'+minNumRequired+'项');
                                    return;
                                }
                                    //总金额
                                $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                
                                console.log(['true or false', $scope.swTabs.perMoney , $scope.swTabs.perMoney < $scope.data.minBetMoney]);
                                
                                if (!$scope.swTabs.perMoney || $scope.swTabs.perMoney < $scope.data.minBetMoney ) {
                        			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                        			return ;
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(arg) {
                                	
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.GROUP_FLAG, [{
                                        'token': $scope.swTabs.token,
                                        'xzje': $scope.swTabs.perMoney,
                                        'typeCode': $scope.curPlay,
                                        'cateCode': $scope.swTabs.swTab.toUpperCase()
                                    }]).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                    });
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
                if ($scope.curPlay == 'KD') {
                    $scope.kd_kinds = ['kd_qsw', 'kd_zsw', 'kd_hsw'];
                    $scope.kd_kinds.map(function(item, index) {
                        $scope[item] = $scope.pls.filter(filter_kd(item));
                    });

                    var filter_kd = function(text) {
                        return function(value, key) {
                            return value.id.split('-')[1] == text.split('_')[1].toUpperCase();
                        };
                    };
                    $scope.kd_kinds.map(function(item, index) {
                        $scope[item + '_lines'] = Math.ceil($scope[item].length / $scope.cols);
                    });
                    //投注
                    $scope.$watch('swTabs.swTab', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope['kd_' + newVal].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope['kd_' + newVal].forEach(function(item, index) {
                                    if (item.money) {
                                    	var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                        $scope[newVal + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[newVal + '_betDatas'].length; i++) {
                            		if ($scope[newVal + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal + '_betDatas'],localStorage.getItem('sscQs')).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
                if ($scope.curPlay == 'QT') {
                    $scope.qt_kinds = ['qt_qsw_qt', 'qt_zsw_qt', 'qt_hsw_qt', 'qt_qsw_zd', 'qt_zsw_zd', 'qt_hsw_zd', 'qt_qsw_bch', 'qt_zsw_bch', 'qt_hsw_bch'];

                    var filter_qt = function(text) {
                        return function(value, key) {
                            return value.id.split('_')[0] == text.toUpperCase().split('_').join('-');
                        };
                    };
                    $scope.qt_kinds.map(function(item, index) {
                        $scope[item] = $scope.pls.filter(filter_qt(item));
                    });
                    $scope.qt_qsw = $scope['qt_qsw_qt'].concat($scope['qt_qsw_zd']).concat($scope['qt_qsw_bch']);
                    $scope.qt_zsw = $scope['qt_zsw_qt'].concat($scope['qt_zsw_zd']).concat($scope['qt_zsw_bch']);
                    $scope.qt_hsw = $scope['qt_hsw_qt'].concat($scope['qt_hsw_zd']).concat($scope['qt_hsw_bch']);
                    //投注
                    $scope.$watch('swTabs.swTab', function(newVal, oldVal) {
                        if (newVal) {
                            console.log(newVal);
                            $scope.reset = function() {
                                $scope['qt_' + newVal].forEach(function(item, index) {
                                    item.money = '';
                                    item.label = getLabelName();
                                    item.label2 = $scope.curPlay;
                                });
                            };
                            $scope.reset();
                            //投注
                            $scope.showOrderList = function() {
                                $scope[newVal + '_betDatas'] = [];
                                //获取填写金额的选项
                                $scope['qt_' + newVal].forEach(function(item, index) {
                                    if (item.money) {
                                    	
                                    	var newItem = angular.extend(item, {
                                        	uid: item.id,
                                        	rate: item.pl,
                                        	number: item.number,
                                        	xzje: item.money
                                    	});
                                    	
                                        $scope[newVal + '_betDatas'].push(newItem);
                                    }
                                });
                                    //总金额
                                $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                    return a + Number(b.money);
                                }, 0);
                                
                                if ($scope[newVal + '_betDatas'].length <= 0) {
                                	UI.alert('请选择下注号码');
                                	return ;
                                }
                            	for (var i = 0; i < $scope[newVal + '_betDatas'].length; i++) {
                            		if ($scope[newVal + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                            			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                            			return ;
                            		}
                            	}
                                
                                //弹窗
                                ngDialog.openConfirm({
                                    template: newVal + '_betDialog',
                                    scope: $scope,
                                    plain: false,
                                    className: 'ngdialog-theme-default'
                                }).then(function(res) {
                                	
                                	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.NORMAL_FLAG, $scope[newVal + '_betDatas']).then(function (res) {
                                        UI.alert(res.data.msg);
                                        return;
                                	});
                                	
                                }, function(reason) {});
                            };
                        }
                    }, true);
                }
            },
            function(error) {
                console.log(error);
            });
    }
    getPL(localStorage.getItem('sscName'), $scope.curPlay);
    //监听玩法获取不同玩法的赔率
    $scope.$watch('curPlay', function(newVal, oldVal) {
        if (newVal) {
            if (newVal == 'FSZH') {
                $scope.fs_qsw_b = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_qsw_s = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_qsw_g = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_zsw_b = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_zsw_s = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_zsw_g = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_hsw_b = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_hsw_s = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_hsw_g = [{number:0},{number:1},{number:2},{number:3},{number:4},{number:5},{number:6},{number:7},{number:8},{number:9}];
                $scope.fs_qsw = $scope.fs_qsw_b.concat($scope.fs_qsw_s).concat($scope.fs_qsw_g);
                $scope.fs_zsw = $scope.fs_zsw_b.concat($scope.fs_zsw_s).concat($scope.fs_zsw_g);
                $scope.fs_hsw = $scope.fs_hsw_b.concat($scope.fs_hsw_s).concat($scope.fs_hsw_g);
                //投注
                $scope.$watch('swTabs.swTab', function(newVal, oldVal) {
                    if (newVal) {
                        console.log(newVal);
                        $scope.reset = function() {
                            $scope['fs_' + newVal].forEach(function(item, index) {
                                item.money = '';
                                item.label = getLabelName();
                                item.label2 = $scope.curPlay;
                            });
                        };
                        $scope.reset();
                        //投注
                        $scope.showOrderList = function() {
                            $scope[newVal + '_betDatas'] = [];
                            $scope[newVal + '_b' + '_betDatas'] = [];
                            $scope[newVal + '_s' + '_betDatas'] = [];
                            $scope[newVal + '_g' + '_betDatas'] = [];
                            $scope.checkedCount = 0;
                            $scope.checkedCount_b = 0;
                            $scope.checkedCount_s = 0;
                            $scope.checkedCount_g = 0;
                            //获取填写金额的选项
                            $scope['fs_' + newVal + '_b'].forEach(function(item, index) {
                                if (item.money) {
                                	var newItem = angular.extend(item, {
                                    	uid: item.id,
                                    	rate: item.pl,
                                    	number: item.number,
                                    	xzje: item.money
                                	});
                                    $scope.checkedCount_b++;
                                    $scope[newVal + '_b' + '_betDatas'].push(newItem);
                                    $scope[newVal + '_betDatas'].push(newItem);
                                }
                            });
                            $scope['fs_' + newVal + '_s'].forEach(function(item, index) {
                                if (item.money) {
                                	var newItem = angular.extend(item, {
                                    	uid: item.id,
                                    	rate: item.pl,
                                    	number: item.number,
                                    	xzje: item.money
                                	});
                                    $scope.checkedCount_s++;
                                    $scope[newVal + '_s' + '_betDatas'].push(newItem);
                                    $scope[newVal + '_betDatas'].push(newItem);
                                }
                            });
                            $scope['fs_' + newVal + '_g'].forEach(function(item, index) {
                                if (item.money) {
                                	var newItem = angular.extend(item, {
                                    	uid: item.id,
                                    	rate: item.pl,
                                    	number: item.number,
                                    	xzje: item.money
                                	});
                                    $scope.checkedCount_g++;
                                    $scope[newVal + '_g' + '_betDatas'].push(newItem);
                                    $scope[newVal + '_betDatas'].push(newItem);
                                }
                            });
                            $scope.checkedCount = $scope.checkedCount_b + $scope.checkedCount_s + $scope.checkedCount_g;
                            $scope.swTabs.bwNum = $scope[newVal + '_b' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(',');
                            $scope.swTabs.swNum = $scope[newVal + '_s' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(',');
                            $scope.swTabs.gwNum = $scope[newVal + '_g' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(',');
                            if ($scope.checkedCount >= 9&&$scope.checkedCount_b>=1&&$scope.checkedCount_s>=1&&$scope.checkedCount_g>=1) {
                                gameService.getData('/cpOrder/getGroupOrderList', {
                                    params: {
                                        bwNum: $scope[newVal + '_b' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(','),
                                        swNum:$scope[newVal + '_s' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(','),
                                        gwNum:$scope[newVal + '_g' + '_betDatas'].map(function(item, index) {
                                            return item.number;
                                        }).join(','),
                                        gameCode: localStorage.getItem('sscName'),
                                        typeCode: $scope.curPlay,
                                        cateCode: $scope.swTabs.swTab.toUpperCase(),
                                        multilen: 99
                                    },
                                    timeout: 30000
                                }).then(function(res) {
                                    console.log(res);
                                    $scope.swTabs.token = res.data.token;
                                    $scope.swTabs.orderList = res.data.orderList;
                                }, function(error) {});
                            } else {
                                UI.alert('至少选择9项且百拾个至少选1项');
                                return;
                            }
                                //总金额
                            $scope[newVal + '_totalMoney'] = $scope[newVal + '_betDatas'].reduce(function(a, b) {
                                return a + Number(b.money);
                            }, 0);
                            
                            for (var i = 0; i < $scope[newVal + '_betDatas'].length; i++) {
                            	console.log(['money', $scope[newVal + '_betDatas'][i].xzje]);
                        		if ($scope[newVal + '_betDatas'][i].xzje < $scope.data.minBetMoney ) {
                        			UI.alert('最小下注金额为'+ $scope.data.minBetMoney);
                        			return ;
                        		}
                        	}
                            
                            //弹窗
                            ngDialog.openConfirm({
                                template: newVal + '_betDialog',
                                scope: $scope,
                                plain: false,
                                className: 'ngdialog-theme-default'
                            }).then(function(arg) {
                            	
                            	CPMisc.saveOrder(localStorage.getItem('sscName'), CPMisc.GROUP_FLAG, [{
                                    'token': $scope.swTabs.token,
                                    'xzje': $scope.swTabs.perMoney,
                                    'typeCode': $scope.curPlay,
                                    'cateCode': $scope.swTabs.swTab.toUpperCase()
                                }]).then(function (res) {
                                    UI.alert(res.data.msg);
                                    return;
                                });
                            }, function(reason) {});
                        };
                    }
                }, true);
                return;
            }
            getPL(localStorage.getItem('sscName'), newVal);
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
     //球色
    $scope.topCircle = function(num){
        num = Number(num);
        var redArr = [1,4,7,10,13,16,19,22,25,28,31,34,37,40,43,46,49];
        var blueArr = [2,5,8,11,14,17,20,23,26,29,32,35,38,41,44,47,50];
        var greenArr = [0,3,6,9,12,15,18,21,24,27,30,33,36,39,42,45,48];
        if(redArr.indexOf(num)!=-1){
            return 'red';
        }
        if(greenArr.indexOf(num)!=-1){
            return 'green';
        }
        if(blueArr.indexOf(num)!=-1){
            return 'blue';
        }
    };
}]);