angular.module('cpApp').controller('fclhcHk6Ctrl', ['$rootScope', '$scope', 'gameService', '$stateParams', '$interval', '$timeout', 'CPMisc', 'localStorage', 'UI', '$q',
function($rootScope, $scope, gameService, $stateParams, $interval, $timeout, CPMisc, localStorage, UI, $q) {
    //获取头部信息
    if ($stateParams.name) {
        localStorage.setItem('fclhcName', $stateParams.name);
    }
    getTopData();

    function getTopData() {
        CPMisc.recentIssue($stateParams.name).then(function(res) {
            if (!res.data.rs) {
                return;
            }
            $rootScope.title = res.data.datas.gameCnName || '一般彩票';
            $scope.lotKind = res.data.datas.gameCnName;
            $scope.lotEnName = res.data.datas.gameEnName;
            $scope.lastNumber = res.data.datas.lastNumber;
            $scope.lastResults = res.data.datas.lotteryBalls.split(',');
            $scope.currentNumber = res.data.datas.currentNumber;
            //获取倒计时时间
            $scope.downTimeLeft = {second: Number(res.data.datas.downTimeLeft)};
            $scope.betAdvanceTime = Number(res.data.datas.betAdvanceTime);
            $scope.closeTimeLeft =  {second: $scope.downTimeLeft['second'] + $scope.betAdvanceTime};

        }, function(error) {});
    }
    
    //玩法tab切换

    localStorage.setItem('curPlay',"TM");//香港六合彩默认特码
    $scope.curPlay = localStorage.getItem('curPlay'); 
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
                    return;
                }
                $scope.pls = res.data.datas;
                $scope.cols = 5; //自定义列数
                if ($scope.curPlay == "ZPS") {
                    var zps_pls = ['WDW', 'QDW', 'BDW', 'SDW', 'GDW'];
                    var zps_filter = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text;
                        };
                    };
                    zps_pls.map(function(value, key) {
                        $scope[value.toLowerCase() + 'Pls'] = $scope.pls.filter(zps_filter(value));
                    });
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
                    $scope.yzzhPls = {
                        '全五一字组合': $scope.qwyzzhPls,
                    };
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
                }
                if ($scope.curPlay == 'EZ') {
                    $scope.ez_kinds = ['ezzh', 'bsdw', 'bgdw', 'sgdw', 'bghs', 'sghs'];
                    //写这个函数方便传参
                    var filter_ezFun = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text.toUpperCase();
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
                }
                if ($scope.curPlay == 'SZ') {
                    $scope.szLists = {};
                    $scope.szLists.szList = 'szzh'; //默认显示三字组合
                    $scope.sz_kinds = ['szzh', 'bsgdw', 'bsghs'];
                    //写这个函数方便传参
                    var filter_szFun = function(text) {
                        return function(item, index) {
                            return item.id.split('-')[1] == text.toUpperCase();
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
                }
                if ($scope.curPlay == 'KD') {
                    $scope.kd_kinds = ['kd'];
                    $scope.kd_kinds.map(function(item, index) {
                        $scope[item] = $scope.pls.filter(filter_kd(item));
                    });

                    var filter_kd = function(text) {
                        return function(value, key) {
                            return value.id.split('-')[1] == text.toUpperCase();
                        };
                    };
                    $scope.kd_kinds.map(function(item, index) {
                        $scope[item + '_lines'] = Math.ceil($scope[item].length / $scope.cols);
                    });
                }
                if ($scope.curPlay == 'QT') {
                    $scope.qt_kinds = ['qt_qt','qt_zd','qt_bch'];

                    var filter_qt = function(text) {
                        return function(value, key) {
                            return value.id.split('-')[1] == text.toUpperCase().split('_')[1];
                        };
                    };
                    $scope.qt_kinds.map(function(item, index) {
                        $scope[item] = $scope.pls.filter(filter_qt(item));
                    });
                }
                //六合彩部分
                if($scope.curPlay=='TM'){
                  $scope.tmTab = 'tmA';//默认显示特码A
                  $scope.tm_a_pls = $scope.pls.filter(function(value,key){
                    return value.id.split('-')[1] == 'TM_A';
                  });
                  $scope.tm_b_pls = $scope.pls.filter(function(value,key){
                    return value.id.split('-')[1] == 'TM_B';
                  });
                  //判断序号是否要红圈
                  $scope.ifBgCircle = function(arg){
                    return !isNaN(Number(arg));
                  };
                }
                if($scope.curPlay=='ZMT'){
                  $scope.zmtTab = 'z1t';//默认正1特
                  $scope.zmtKinds = ['z1t','z2t','z3t','z4t','z5t','z6t'];
                  var zmt_filter = function(text){
                    return function(item,index){
                      return item.id.split('-')[1] == text.toUpperCase();
                    };
                  };
                  $scope.zmtKinds.forEach( function(kind, index) {
                    $scope[kind + '_pls'] = $scope.pls.filter(zmt_filter(kind));
                  });
                }
                if($scope.curPlay=='ZM'){
                  $scope.zmTab = 'zmA';//默认显示特码A
                  $scope.zm_a_pls = $scope.pls.filter(function(value,key){
                    return value.id.split('-')[1] == 'ZM_A';
                  });
                  $scope.zm_b_pls = $scope.pls.filter(function(value,key){
                    return value.id.split('-')[1] == 'ZM_B';
                  });
                  //判断序号是否要红圈
                  $scope.ifBgCircle = function(arg){
                    return !isNaN(Number(arg));
                  };
                }
                if($scope.curPlay=='ZM1T6'){
                  $scope.zmtTab = 'zm1';//默认正1特
                  $scope.zmtKinds = ['zm1','zm2','zm3','zm4','zm5','zm6'];
                  var zm1t6_filter = function(text){
                    return function(item,index){
                      return item.id.split('-')[1] == text.toUpperCase();
                    };
                  };
                  $scope.zmtKinds.forEach( function(kind, index) {
                    $scope[kind + '_pls'] = $scope.pls.filter(zm1t6_filter(kind));
                  });
                }
                if($scope.curPlay=='GG'){
                  $scope.zmtTab = 'zm1';//默认正1特
                  $scope.zmtKinds = ['zm1','zm2','zm3','zm4','zm5','zm6'];
                  var zm1t6_filters = function(text){
                    return function(item,index){
                      return item.id.split('-')[1] == text.toUpperCase();
                    };
                  };
                  $scope.zmtKinds.forEach( function(kind, index) {
                    $scope[kind + '_pls'] = $scope.pls.filter(zm1t6_filters(kind));
                  });
                }
                if($scope.curPlay=='LM'){
                  var lm_kinds = ['3qz','z2','z3','2qz','zt','tz2','tc'];
                  lm_kinds.forEach(function(kind,index){
                    $scope['t'+kind+'_pl'] = $scope.pls.filter(lm_filter(kind))[0].pl;
                  });
                  // console.log($scope['t3qz_pl']);
                  var lm_filter = function(text){
                    return function(value,key){
                      return value.id.split('-')[2] == text.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'BB'){
                  $scope.bbTab = 'bb';//默认半波
                  var bbKinds = ['BB-BB-RED_ODD','BB-BB-RED_EVEN','BB-BB-RED_BIG','BB-BB-RED_SMALL','BB-BB-GREEN_ODD','BB-BB-GREEN_EVEN','BB-BB-GREEN_SMALL','BB-BB-GREEN_BIG','BB-BB-BLUE_ODD','BB-BB-BLUE_EVEN','BB-BB-BLUE_SMALL','BB-BB-BLUE_BIG','BB-BBB-RED_BIG_ODD','BB-BBB-RED_BIG_EVEN','BB-BBB-RED_SMALL_ODD','BB-BBB-RED_SMALL_EVEN','BB-BBB-GREEN_BIG_ODD','BB-BBB-GREEN_BIG_EVEN','BB-BBB-GREEN_SMALL_ODD','BB-BBB-GREEN_SMALL_EVEN','BB-BBB-BLUE_BIG_ODD','BB-BBB-BLUE_BIG_EVEN','BB-BBB-BLUE_SMALL_ODD','BB-BBB-BLUE_SMALL_EVEN'];
                  bbKinds.forEach(function(kind,index){
                    $scope[kind.split('-').join('')] = $scope.pls.filter(bb_filter(kind))[0];
                  });
                  var bb_filter = function(kind){
                    return function (item,index) {
                      return item.id == kind;
                    };
                  };
                }
                if($scope.curPlay == 'YXYZTW'){
                  $scope.yxztwTab = 'ztw';//默认显示正特尾
                  var yxztw_kinds = ['ztwxz','yxxz'];
                  yxztw_kinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(yxztw_filter(kind));
                  });
                  var yxztw_filter = function(kind){
                    return function (item,index) {
                      return item.id.split('-')[1]==kind.toUpperCase();
                    };
                  };
                  var yxxz_kinds = ['shu','niu','hu','tu','long','she','ma','yang','hou','ji','gou','zhu'];
                  yxxz_kinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope['yxxz_pls'].filter(yxxz_filter(kind))[0];
                  }); 
                  var yxxz_filter = function(kind) {
                    return function(item,index){
                      return item.id.split('-')[2] == kind.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'TXTW'){
                  var txtw_kinds = ['tmsx','ttw'];
                  txtw_kinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(txtw_filter(kind));
                  });
                  var txtw_filter = function(kind){
                    return function(item,index){
                      return item.id.split('-')[1] == kind.toUpperCase();
                    };
                  };
                  //生肖
                  var tmsx_kinds = ['shu','niu','hu','tu','long','she','ma','yang','hou','ji','gou','zhu'];
                  tmsx_kinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope['tmsx_pls'].filter(tmsx_filter(kind))[0];
                  }); 
                  var tmsx_filter = function(kind) {
                    return function(item,index){
                      return item.id.split('-')[2] == kind.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'ZYBZ'){
                  $scope.zybzTab = 'wbz';//
                  var zybz_kinds = ['wbz','qbz','jbz','szy','lzy'];
                  zybz_kinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(zybz_filter(kind));
                  });
                  var zybz_filter = function(kind){
                    return function(item,index){
                      return item.id.split('-')[1] == kind.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'WSL'){
                  $scope.wslTab = 'ewl';//默认显示二尾连
                  var wslKinds = ['ewl','sawl','siwl'];
                  wslKinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(wsl_filter(kind));
                  });
                  var wsl_filter =function(kind){
                    return function(item,index){
                      return item.id.split('-')[1] == kind.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'LX'){
                  $scope.lxTab = 'elx';//默认显示二连肖
                  var lxKinds = ['elx','salx','silx','wlx'];
                  lxKinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(lx_filter(kind));
                  });
                  var lx_filter = function(kind){
                    return function(item,index){
                      return item.id.split('-')[1] == kind.toUpperCase();
                    };
                  };
                  //生肖
                  var sx_kinds = ['shu','niu','hu','tu','long','she','ma','yang','hou','ji','gou','zhu'];
                  sx_kinds.forEach(function(kind,index){
                    $scope[kind+'_elx_pls'] = $scope['elx_pls'].filter(sx_filter(kind))[0];
                  }); 
                  sx_kinds.forEach(function(kind,index){
                    $scope[kind+'_salx_pls'] = $scope['salx_pls'].filter(sx_filter(kind))[0];
                  });
                  sx_kinds.forEach(function(kind,index){
                    $scope[kind+'_silx_pls'] = $scope['silx_pls'].filter(sx_filter(kind))[0];
                  });
                  sx_kinds.forEach(function(kind,index){
                    $scope[kind+'_wlx_pls'] = $scope['wlx_pls'].filter(sx_filter(kind))[0];
                  });
                  var sx_filter = function(kind) {
                    return function(item,index){
                      return item.id.split('-')[2] == kind.toUpperCase();
                    };
                  };
                }
                if($scope.curPlay == 'HX'){
                  $scope.hxTab = 'ex';//默认显示二连肖
                  var hxKinds = ['ex','sx','lx'];
                  hxKinds.forEach(function(kind,index){
                    $scope[kind+'_pls'] = $scope.pls.filter(hx_filter(kind));
                  });
                  var hx_filter = function(kind){
                    return function(item,index){
                      return item.id.split('-')[1] == kind.toUpperCase();
                    };
                  };
                  //生肖
                  var sx_Kinds = ['shu','niu','hu','tu','long','she','ma','yang','hou','ji','gou','zhu'];
                  sx_Kinds.forEach(function(kind,index){
                    $scope[kind+'_ex_pls'] = $scope['ex_pls'].filter(sx_filters(kind))[0];
                  }); 
                  sx_Kinds.forEach(function(kind,index){
                    $scope[kind+'_sx_pls'] = $scope['sx_pls'].filter(sx_filters(kind))[0];
                  });
                  sx_Kinds.forEach(function(kind,index){
                    $scope[kind+'_lx_pls'] = $scope['lx_pls'].filter(sx_filters(kind))[0];
                  });
                  var sx_filters = function(kind) {
                    return function(item,index){
                      return item.id.split('-')[2] == kind.toUpperCase();
                    };
                  };
                }
            },
            function(error) {
                console.log(error);
            });
    }
    getPL(localStorage.getItem('fclhcName'), $scope.curPlay);
    //监听玩法获取不同玩法的赔率
    $scope.$watch('curPlay', function(newVal, oldVal) {
        if (newVal) {
            getPL(localStorage.getItem('fclhcName'), newVal);
        }
    });

    $scope.data = {
    	zybzTab: 'wbz',
    	wslTab: 'ewl',
    	lxTab: 'elx',
    	hxTab: 'ex',
    	betMoney: {},
    	betSelected: {},
    	betPeiyuSelected: {},
    	betCode: {},
    	inputErrors: {},
    	quickOrderMoney: '',
    	lmObject: {
    		pabc: 1,
    		rrtype: 0,
    		dm1: '',
    		dm2: ''
    	},
    	minBetMoney: 10, // 暂时写死
    };
    $scope.fun = {
    	getPankouLabel: function (id) {
    		console.log(['id', id]);
    		if (id.indexOf('TM-')=== 0 && id.indexOf('TM_A') != -1 ) {
    			return '特码A';
    		}
    		if (id.indexOf('TM-')=== 0 && id.indexOf('TM_B') != -1) {
    			return '特码B';
    		}
    		if (id.indexOf('ZMT-')=== 0) {
    			var label = id.match(/Z\d+T/)[0];
    			var labels = {
    				'Z1T': '正一特',
    				'Z2T': '正二特',
    				'Z3T': '正三特',
    				'Z4T': '正四特',
    				'Z5T': '正五特',
    				'Z6T': '正六特'
    			};
    			return labels[label];
    		}
    		if (id.indexOf('ZM-')=== 0 && id.indexOf('ZM_A') != -1) {
    			return '正码A';
    		}
    		if (id.indexOf('ZM-')=== 0 && id.indexOf('ZM_B') != -1) {
    			return '正码B';
    		}
    		if (id.indexOf('ZM1T6-')=== 0 ) {
    			var label = id.match(/-(ZM\d+)-/)[1];
    			var labels = {
    				'ZM1': '正码一',
    				'ZM2': '正码二',
    				'ZM3': '正码三',
    				'ZM4': '正码四',
    				'ZM5': '正码五',
    				'ZM6': '正码六'
    			};
    			return labels[label];
    		}
    		if (id.indexOf('GG-')=== 0) {
    			var label = id.match(/ZM\d+/)[0];
    			var labels = {
    				'ZM1': '正码一',
    				'ZM2': '正码二',
    				'ZM3': '正码三',
    				'ZM4': '正码四',
    				'ZM5': '正码五',
    				'ZM6': '正码六'
    			};
    			return labels[label];
    		}
    		if (id.indexOf('BB-BB-')=== 0) {
    			return '半波';
    		}
    		if (id.indexOf('BB-BBB-')=== 0) {
    			return '半半波';
    		}
    		if (id.indexOf('YXYZTW-ZTWXZ-')=== 0) {
    			return '正特尾';
    		}
    		if (id.indexOf('YXYZTW-YXXZ-')=== 0) {
    			return '一肖';
    		}
    		if (id.indexOf('TXTW-TMSX-')=== 0) {
    			return '特码生肖';
    		}
    		if (id.indexOf('TXTW-TTW-')=== 0 ) {
    			return '特头尾';
    		}
    	},
    	quickOrderMoneyChanged: function (quickMoney) {
    		if ($scope.curPlay.toLowerCase() == 'gg') {
    			for(var id in $scope.data.betCode) {
    				$scope.data.betCode[id]['xzje'] = $scope.data.quickOrderMoney;
    			}
    		}
    		else {
        		for (var id in $scope.data.betPeiyuSelected) {
    				$scope.data.betMoney[id] = quickMoney;
            		$scope.fun.codeSelected($scope.data.betPeiyuSelected[id]);
        		}
    		}
    	},
    	peiyuSelected: function (obj) {
    		var id = obj.id;
    		if (typeof $scope.data.betPeiyuSelected[id] == 'undefined') {
    			$scope.data.betPeiyuSelected[id] = obj;
    		}
    		else {
    			delete $scope.data.betPeiyuSelected[id];
    			$scope.fun.codeUnselected(id);
    		}
    		
    		$scope.fun.quickOrderMoneyChanged($scope.data.quickOrderMoney);
    	},
    	codeUnselected: function (id) {
    		delete $scope.data.betCode[id];
    		delete $scope.data.betMoney[id];
    	},
        codeSelected: function (obj) {
        	var money = $scope.data.betMoney[obj.id];
        	if (money < $scope.data.minBetMoney ) {
        		$scope.data.inputErrors[obj.id] = true;
        	}
        	else {
            	$scope.data.betCode[obj.id] = {
            		uid: obj.id,
            		rate: obj.pl,
            		xzje: money,
            		number: obj.number
                };
            	delete $scope.data.inputErrors[obj.id];
        	}
        },
        zybzCodeSelected: function (obj) {
        	if ($scope.data.betMoney[obj.id]) {
        		$scope.data.betCode[obj.id] = true;
        	}
        	else {
        		delete $scope.data.betCode[obj.id];
        	}
        },
        singleCodeSelected: function (obj) {
        	var newBetCode = {};
        	for (var id in $scope.data.betSelected) {
        		for (var idv2 in $scope.data.betCode) {
        			if (id == idv2 ) {
        				newBetCode[idv2] = $scope.data.betCode[idv2];
        			}
        		}
        	}
        	newBetCode[obj.id] = {
        		uid: obj.id,
        		rate: obj.pl,
        		xzje: $scope.data.betMoney[obj.id],
        		number: obj.number
        	};
        	$scope.data.betCode = newBetCode;
        },
        lmSubmitOrder: function () {
        	
        	if (angular.isEmpty($scope.data.quickOrderMoney)) {
        		UI.alert('下注金额最少为'+$scope.data.minBetMoney + '元');
        		return ;
        	}
        	
        	var nums = [];
        	for (var num in $scope.data.betSelected) {
        		if ($scope.data.betSelected[num]) {
        			nums.push(num.replace('id_', ''));
        		}
        	}
        	// 生成连码订单
        	nums = nums.join(',');
        	var defered = $q.defer();
        	CPMisc.getLmOrders(nums, $scope.data.lmObject.rrtype, $scope.data.lmObject.pabc, $scope.data.lmObject.dm1, $scope.data.lmObject.dm2).then(function(lmOrders) {
    			var orders = [];
    			var summary = {
    				total: 0,
    				totalMoney: 0,
    			};
    			lmOrders['orderList'].forEach(function(lmOrder) {
    				orders.push({
    					number: lmOrder['number'],
    					pl: lmOrder['rate'],
    					xzje: $scope.data.quickOrderMoney,
    				});
    				summary['total'] += 1;
    				summary['totalMoney'] += $scope.data.quickOrderMoney*1;
    			});
    			
    			defered.resolve({
    				summary: summary,
    				orders: orders,
    				token: lmOrders['token']
    			});
    		});
        	
        	// 通过生成的连码订单 提交订单数据
        	defered.promise.then(function(lmOrderData) {
        		UI.openBetConfirmDialog(lmOrderData['summary'], lmOrderData['orders'], function () {
        			CPMisc.saveOrder($stateParams.name, CPMisc.LM_FLAG, [{
        				token: lmOrderData['token'],
        				xzje: $scope.data.quickOrderMoney
        			}]).then(function (res) {
        				if (typeof res['data'] == 'string') {
            				UI.alert(res['data']['msg']);
            			}
            			else {
            				UI.alert(res['data']['msg']);
            			}
            			// 重置
            			$scope.fun.cancelOrder();
        			});
        		});
        	});
        },
        // 中与不中 & 尾连数 订单提交
        zybzSubmitOrder: function () {
        	var cids = Object.keys($scope.data.betCode);
        	var limitConfig = {
        		wbz: 5,
        		qbz: 7,
        		jbz: 9,
        		szy: 4,
        		lzy: 6,
        		ewl: 2,
        		sawl: 3,
        		siwl: 4,
        		elx: 2, 
        		salx: 3,
        		silx: 4,
        		wlx: 5,
        		ex: 2,
        		sx: 4,
        		lx: 6
        	};
        	var tab = $scope.data.zybzTab.toLowerCase();
        	if ($scope.curPlay.toLowerCase() == 'wsl') {
        		tab = $scope.data.wslTab.toLowerCase();
        	}
        	else if ($scope.curPlay.toLowerCase() == 'lx') {
        		tab = $scope.data.lxTab.toLowerCase();
        	}
        	else if ($scope.curPlay.toLowerCase() == 'hx') {
        		tab = $scope.data.hxTab.toLowerCase();
        	}
        	console.log(['tab', tab, $scope.curPlay.toLowerCase()]);
        	if (cids.length < limitConfig[tab]) {
        		UI.alert("至少需要选择"+limitConfig[tab]+"个号码！");
        		return;
        	}
        	if ($scope.data.quickOrderMoney <= 0) {
        		UI.alert('下注金额最少为'+$scope.data.minBetMoney + '元');
        		return ;
        	}
        	
        	CPMisc.getZybzOrders(cids, limitConfig[tab]).then(function (zybzOrders) {
        		var orders = [];
    			var summary = {
    				total: 0,
    				totalMoney: 0,
    			};
    			zybzOrders['orderList'].forEach(function(zybzOrder) {
    				orders.push({
    					number: zybzOrder['cateName']+ ':' +zybzOrder['number'],
    					pl: zybzOrder['rate'],
    					xzje: $scope.data.quickOrderMoney,
    				});
    				summary['total'] += 1;
    				summary['totalMoney'] += $scope.data.quickOrderMoney*1;
    			});
    			
    			UI.openBetConfirmDialog(summary, orders, function () {
        			CPMisc.saveOrder($stateParams.name, CPMisc.MUL_FLAG, [{
        				typeCode: $scope.curPlay.toUpperCase(),
        				cateCode: tab,
        				token: zybzOrders['token'],
        				xzje: $scope.data.quickOrderMoney
        			}]).then(function (res) {
        				if (typeof res['data'] == 'string') {
            				UI.alert(res['data']['msg']);
            			}
            			else {
            				UI.alert(res['data']['msg']);
            			}
            			// 重置
            			$scope.fun.cancelOrder();
        			});
        		});
        	});
        },
        submitOrder: function () {
    		var orders = [];
        	var summary = {
        		total: 0,
        		totalMoney: 0
        	};
        	
        	// 连码订单提交  - 单独处理
        	if ($scope.curPlay.toLowerCase() == 'lm') {
        		return $scope.fun.lmSubmitOrder();
        	}
        	if ($scope.curPlay.toLowerCase() == 'zybz' 
        		|| $scope.curPlay.toLowerCase() == 'lx'
        		|| $scope.curPlay.toLowerCase() == 'wsl'
        		|| $scope.curPlay.toLowerCase() == 'hx') {
        		return $scope.fun.zybzSubmitOrder();
        	}
        	
        	// 过关单独计算弹出框数据
        	if ($scope.curPlay.toLowerCase() == 'gg') {
        		var order = {
        			'number': '过关',
        			'pl': 0,
        			'xzje': $scope.data.quickOrderMoney
        		};
        		var pl = 1;
        		var number = [];
        		for (var id in $scope.data.betCode){
        			pl *= $scope.data.betCode[id]['rate']*1;
        			number.push($scope.fun.getPankouLabel(id)+$scope.data.betCode[id]['number']);
        			summary['total'] += 1;
        			summary['totalMoney'] += $scope.data.betCode[id]['xzje']*1;
        		}
        		order['pl'] = new Number(pl).toFixed(2);
        		order['number'] += ': ' + number.join(',');
        		orders.push(order);

        		if (summary.total < 2 ) {
        			UI.alert('请任选2-6个号码为一投注组合！');
        			return ;
        		}
        	}
        	else {
            	for (var id in $scope.data.betCode) {
            		summary.totalMoney += $scope.data.betCode[id]['xzje']*1;
            		summary.total += 1;
            		
            		orders.push({
            			number: $scope.fun.getPankouLabel(id) + ':' + $scope.data.betCode[id]['number'],
            			pl: $scope.data.betCode[id]['rate'],
            			xzje: $scope.data.betCode[id]['xzje']
            		});
            	}
        	}
        	
        	if (summary.totalMoney <= 0 || isNaN(summary.totalMoney)) {
    			UI.alert('下注金额最少为'+$scope.data.minBetMoney + '元');
    			return ;
    		}
        	
        	if (summary.total <= 0 ) {
        		UI.alert('至少选一个号码为一投注组合！');
        		return ;
        	}
        	
        	UI.openBetConfirmDialog(summary, orders, function () {
        		// 提交的flag 是？
            	var flag = CPMisc.NORMAL_FLAG;
            	if ($scope.curPlay.toLowerCase() == 'gg') {
            		flag = CPMisc.CL_FLAG;
            	}
            	
            	CPMisc.saveOrder($stateParams.name, flag, Object.values($scope.data.betCode))
            		.then(function (res) {
            			if (typeof res['data'] == 'string') {
            				UI.alert(res['data']['msg']);
            			}
            			else {
            				UI.alert(res['data']['msg']);
            			}
            			
            			// 重置
            			$scope.fun.cancelOrder();
            	});
        	}, function () {
        		$scope.fun.cancelOrder();
        	});
        },
        cancelOrder: function () {
        	$scope.data.betCode = {};
        	$scope.data.betMoney = {};
        	$scope.data.betSelected = {};
        	$scope.data.betQuickOrderMoney = '';
        	$scope.data.betPeiyuSelected = {};
        	$scope.data.inputErrors = {};
        	$scope.data.quickOrderMoney = '';
        	$scope.data.lmObject.dm1 = '';
        	$scope.data.lmObject.dm2 = '';
        },
        lmCodeSelected: function (number) {
        	if ($scope.data.lmObject.pabc == CPMisc.PABC_DANTUO) {
        		if (angular.isEmpty($scope.data.lmObject.dm1)) {
        			$scope.data.lmObject.dm1 = number;
        		}
        		else if (angular.isEmpty($scope.data.lmObject.dm2)) {
        			$scope.data.lmObject.dm2 = number;
        		}
        	}
        	else {
        		$scope.data.lmObject.dm1 = $scope.data.lmObject.dm2 = '';
        	}
        },
        lmFushiOrDantuoSelected: function () {
        	$scope.fun.cancelOrder();
        },
    };
    // 封盘倒计时 回调
    $scope.fun.closeTickCb = function(leftSecond, intervalHandler) {
    	if (leftSecond <= 0) {
    		// 弹出封盘图层
    		$scope.data.fengpanMaskDialog = UI.openAlertMask('当前封盘中', false, '.game-main-wrap');
    	}
    };
    // 开奖倒计时回调
    $scope.fun.openTickCb = function (leftSecond, intervalHandler) {
    	if (leftSecond <= 0) {
    		// 弹出封盘图层
    		$scope.data.fengpanMaskDialog.close();
    		UI.openAlertMask('当前开奖中', false, '.hk6-game-play');
    		// 15s后重新获取数据
            $scope.data.kaiJiangMaskDialog = $timeout(function () {
            	$scope.data.kaiJIangMaskDialog.close();
            	getTopData();
            }, 15e3);
    	}
    };
}]);