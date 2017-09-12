angular.module('cpApp')
    .controller('UserCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', function($rootScope, $scope, UserCenter, UI) {
        $rootScope.title = '用户资料';
        $scope.formdata = {};
        UserCenter.userInfo().then(function(res) {
            $scope.formdata.user = res['data']['datas'];
        });

        $scope.fun = {
            saveUserInfo: function() {
                UserCenter.updateUserInfo({
                	userRealName: $scope.formdata.userRealName,
                }).then(function(res) {
                    UI.alert(res['data']['msg']);
                });
            },
        };
    }])
    .controller('UserBankCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', function($rootScope, $scope, UserCenter, UI) {
        $rootScope.title = '绑定银行卡';

        $scope.data = {};

        $scope.fun = {
            listBank: function() {
                return UserCenter.userBankList().then(function(res) {
                    $scope.data.bankList = res['data']['datas'];
                });
            }
        };

        $scope.fun.listBank();

    }])
    .controller('UserAddBankCtrl', ['$rootScope', '$scope', '$state', 'UserCenter', 'UI', function($rootScope, $scope, $state, UserCenter, UI) {
        $rootScope.title = '银行卡管理';

        $scope.data = {
            options: {
                cityAndProvince: {
                    cities: [],
                    provinces: []
                },
                bankList: [],
            }
        };
        $scope.formdata = {
            bankCode: '',
        };
        $scope.fun = {
            saveBankInfo: function(form) {
                if (form.$valid) {
                    UserCenter.userAddBank($scope.formdata).then(function(res) {
                        UI.alert(res['data']['msg']);
                        if (res['data']['rs']) {
                            $state.go('user.bank');
                        }
                    });
                }
            },
            loadProvince: function() {
                UserCenter.provinceAndCity().then(function(res) {
                    if (res['data']['rs']) {
                        $scope.data.options.cityAndProvince['provinces'] = res['data']['datas'];
                    }
                });
            },
            loadCity: function() {
                UserCenter.provinceAndCity($scope.formdata.province).then(function(res) {
                    if (res['data']['rs']) {
                        $scope.data.options.cityAndProvince['cities'] = res['data']['datas'];
                    }
                });
            },
            loadAvailabelBank: function() {
                return UserCenter.availableBankList().then(function(res) {
                    $scope.data.options.bankList = res['data']['datas'];
                });
            }
        };
        $scope.fun.loadProvince();
        $scope.fun.loadAvailabelBank();
    }])
    .controller('UserFundsBankChargeCtrl', ['$rootScope', '$scope', function($rootScope, $scope) {
        $rootScope.title = '在线充值';

        $scope.formdata = {
            bank: 1
        };
        var payParams = {
            payId: 1,
            payUrl: 'pay.com'

        };
        $scope.data = {
            step: 1,
        };

        $scope.fun = {
            goStepTwo: function(form) {
                if (form.$valid) {
                    $scope.data.step = 2;
                }
            },
            goStepOne: function() {
                $scope.data.step = 1;
                $scope.formdata = {
                    bank: 1
                };
            },
            chargeSubmit: function() {
                var url = window.location.protocol + '//' + window.location.host + baseURI + '/member/drawMoney';
                var query = [],
                    params = angular.extend(payParams, {
                        money: $scope.formdata.money
                    });

                for (var key in params) {
                    query.push(key + "=" + encodeURI(params[key]));
                }
                url += '?' + query.join('&');
                window.open(url, "_blank");
            }
        };
    }])
    .controller('UserFundsWithdrawCtrl', ['$rootScope', '$scope', '$state', '$location', 'UserCenter', 'UI', function($rootScope, $scope, $state, $location, UserCenter, UI) {
        $rootScope.title = '我要提现';

        $scope.data = {
            bankList: [],
            available: 0
        };
        $scope.formdata = {
            bankId: 1
        };
        $scope.fun = {
            loadBankList: function() {
                UserCenter.userBankList().then(function(res) {
                    if (res['data']['rs']) {
                        $scope.data.bankList = res['data']['datas'];
                    }
                });
            },
            submitWithdraw: function(form) {
                if (form.$valid) {
                    UserCenter.userWithdraw($scope.formdata).then(function(res) {
                        UI.alert(res['data']['msg']);
                        if (res['data']['rs']) {
                            var url = $state.href('user.accountdetail');
                            if (url[0] == '#') {
                                url = url.slice(1);
                            }
                            $location.path(url).search({
                                tab: 3
                            });
                        }
                    });
                }
            },
            loadBalance: function() {
                UserCenter.availableBalance().then(function(res) {
                    if (res['data']['rs']) {
                        $scope.data.available = res['data']['datas'];
                    }
                });
            }
        };

        $scope.fun.loadBankList();

        $scope.fun.loadBalance();

    }])
    .controller('UserTaskCtrl', ['$rootScope', '$scope', function($rootScope, $scope) {
        $rootScope.title = '任务中心';
    }])
    .controller('UserBonusCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', function($rootScope, $scope, UserCenter, UI) {
        $rootScope.title = '奖金详情';

        $scope.crtTab = 1;

        $scope.data = {
            betGameContents: [{
                id: '1',
                title: '重庆时时彩',
                bonusMoney: 2300,
                bonusPoint: 7,
                bonusContent: '',
            }],
            py28: '',
            limitation28: '',
        };

        $scope.fun = {
            showGameContent: function(betGame) {
                UI.showup(angular.element(document.getElementById("test")).html(), '奖金详情', false);
            },
            loadBetGames: function() {
                UserCenter.betGameBonusContents().then(function(res) {
                    /**
                     *  [{
                     *      id: '1', 详情内容id', 
                     *      title: '重庆时时彩', // 游戏名称
                     *      bonusMoney: 2300, // 奖金组 数值
                     *      bonusPoint: 7, // 返点,
                     *      bonusContent: '', // html 格式 - 奖金内容
                     *  }]
                     */
                    res = {
                        'data': {
                            'datas': [{
                                id: '1',
                                title: '重庆时时彩',
                                bonusMoney: 2300,
                                bonusPoint: 7,
                                bonusContent: '',
                            }]
                        }
                    };
                    $scope.data.betGameContents = res['data']['datas'];
                });
            },
        };

        $scope.fun.loadBetGames();
    }])
    .controller('UserHistorderCtrl', ['$rootScope', '$scope', '$stateParams', 'UserCenter', 'CPMisc', '$timeout', function($rootScope, $scope, $stateParams , UserCenter, CPMisc, $timeout) {
       
        if ($stateParams.user) {
        	$rootScope.title = '['+$stateParams.user+'] 的投注记录';
        }
        else {
        	 $rootScope.title = '投注记录';
        }

        $scope.formdata = {
            options: {},
            filter: {},
            day: 0
        };

        $scope.data = {
        };
        $scope.formdata.filter = {
        	userName: $stateParams.user ? $stateParams.user: '',
            gameCode: '',
            orderNo: '',
            beginTimeStr: CPMisc.formatdate(new Date(0)) + ' 00:00:00',
            endTimeStr: CPMisc.formatdate(new Date(0)) + ' 23:59:59',
            status: -1, //-1全部  0等待开奖 1未中奖  2已中奖
            pageSize: 10
        };
        $scope.formdata.options.gameTypeCode = [];

        $scope.data.orders = [];

        $scope.pageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageNo = page;
                $scope.formdata.filter.pageSize = pageSize;
                $scope.fun.filterSubmit().then(function() {

                });
            }
        };

        $scope.$watch('beginTime', function(newVal, oldVal) {
            if (newVal) {
                $scope.formdata.filter.beginTimeStr = newVal;
            }
        });
        $scope.$watch('endTime', function(newVal, oldVal) {
            if (newVal) {
                $scope.formdata.filter.endTimeStr = newVal;
            }
        });
        $scope.fun = {
            filterSubmit: function() {
                return UserCenter.getOrderHistory($scope.formdata.filter).then(function(res) {
                    $scope.data.orders = res['data']['datas']['result'];
                    $scope.pageConf = angular.extend($scope.pageConf, {
                        totalPage: res['data']['datas']['totalPages'],
                        pageSize: res['data']['datas']['pageSize'],
                        totalCount: res['data']['datas']['totalCount']
                    });

                });
            },
            setDay: function(day) {
                $scope.formdata.day = day;
                var date = new Date();
                var time = date.getTime();
                var startTime, endTime;
                startTime = time - (day * 24 * 60 * 60 + date.getHours() * 60 * 60 + date.getMinutes() * 60 + date.getSeconds()) * 1000;
                endTime = time;

                $scope.beginTime = CPMisc.formatdate(new Date(startTime)) + ' 00:00:00';
                $scope.endTime = CPMisc.formatdate(new Date(endTime)) + ' 23:59:59';
            },
            loadGameCodes: function() {
                return CPMisc.cpGameCodes().then(function(res) {
                    if (res['data']['rs']) {
                        $scope.formdata.options.gameTypeCode = res['data']['datas'];
                    }
                });
            }
        };

        var initer = $scope.$watch(function() {
            return $scope.endTime && $scope.beginTime
        }, function(updated) {
            if (updated) {
                $scope.fun.filterSubmit();
                $scope.fun.loadGameCodes();

                initer();
            }
        });

        $scope.fun.setDay(0);
    }])
    .controller('UserOrderDetailCtrl', ['$rootScope', '$scope', '$stateParams', 'UserCenter', 'CPMisc', function($rootScope, $scope, $stateParams, UserCenter, CPMisc) {
        $rootScope.title = '投注查询';

        $scope.data = {
            orderId: $stateParams.id,
            orderDetail: {},
        };
        $scope.fun = {
            orderDetail: function() {
                CPMisc.loadOrderDetail($scope.data.orderId).then(function(res) {
                    $scope.data.orderDetail = res['data']['datas'];
                });
            },
        };

        $scope.fun.orderDetail();

    }])
    .controller('UserTraceListCtrl', ['$rootScope', '$scope', 'UserCenter', 'CPMisc', function($rootScope, $scope, UserCenter, CPMisc) {
        $rootScope.title = '追号记录';

        $scope.formdata = {
            options: {},
            filter: {},
            day: 0
        };

        $scope.data = {};
        $scope.formdata.filter = {
            gameCode: $scope.itemGameCode,
            billno: '',
            beginTime: CPMisc.formatdate(new Date(0)) + ' 00:00:00',
            endTime: CPMisc.formatdate(new Date(0)) + ' 23:59:59',
            status: '',
            pageLimit: 10
        };
        $scope.formdata.filterAll = {
            xzdh: '',
            beginTime: CPMisc.formatdate(new Date(0)) + ' 00:00:00',
            endTime: CPMisc.formatdate(new Date(0)) + ' 23:59:59',
            status: '',
            pageLimit: 10
        };
        $scope.formdata.options.gameTypeCode = [];

        $scope.data.orders = [];
        $scope.$watch('itemGameCode', function(newVal, oldVal) {
            if (newVal) {
                console.log(newVal);
                $scope.formdata.filter.gameCode = newVal;
            };
        });
        $scope.$watch('beginTime', function(newVal, oldVal) {
            if (newVal) {
                console.log(newVal);
                $scope.formdata.filter.beginTime = newVal;
                $scope.formdata.filterAll.beginTime = newVal;
            };
        });
        $scope.$watch('endTime', function(newVal, oldVal) {
            if (newVal) {
                console.log(newVal);
                $scope.formdata.filter.endTime = newVal;
                $scope.formdata.filterAll.endTime = newVal;
            };
        });
        $scope.pageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.currentPage = page;
                $scope.formdata.filter.pageLimit = pageSize;
                console.log(['page', page, pageSize]);
                $scope.fun.filterSubmit().then(function() {

                });
            }
        };
        $scope.formdata.filterAll = {
            xzdh: '',
            beginTime: CPMisc.formatdate(new Date(0)) + ' 00:00:00',
            endTime: CPMisc.formatdate(new Date(0)) + ' 23:59:59',
            status: '',
            pageLimit: 10
        };
        $scope.fun = {
            filterSubmit: function() {
                return UserCenter.loadTraceOrder($scope.itemGameCode ? $scope.formdata.filter : $scope.formdata.filterAll).then(function(res) {
                    $scope.data.orders = res['data']['datas']['result'];
                    $scope.pageConf = angular.extend($scope.pageConf, {
                        totalPage: res['data']['datas']['totalPages'],
                        pageSize: res['data']['datas']['pageSize'],
                        totalCount: res['data']['datas']['totalCount']
                    });
                });
            },
            setDay: function(day) {
                $scope.formdata.day = day;
                var date = new Date();
                var time = date.getTime();
                var startTime, endTime;
                startTime = time - (day * 24 * 60 * 60 + date.getHours() * 60 * 60 + date.getMinutes() * 60 + date.getSeconds()) * 1000;
                endTime = time;

                $scope.beginTime = CPMisc.formatdate(new Date(startTime)) + ' 00:00:00';
                $scope.endTime = CPMisc.formatdate(new Date(endTime)) + ' 23:59:59';
            },
            loadGameCodes: function() {
                return CPMisc.cpGameCodes().then(function(res) {
                    if (res['data']['rs']) {
                        $scope.formdata.options.gameTypeCode = res['data']['datas'];
                    }
                });
            }
        };
        $scope.fun.setDay(0);
        $scope.fun.filterSubmit();
        $scope.fun.loadGameCodes();

    }])
    .controller('UserAccountDetailCtrl', ['$rootScope', '$scope', '$location', '$stateParams', 'UserCenter', 'CPMisc', function($rootScope, $scope, $location, $stateParams, UserCenter, CPMisc) {
        $rootScope.title = '账户详情';

        $scope.tabCurrent = $location.search()['tab'] ? $location.search()['tab'] : 1;
        
        if ($stateParams.user) {
        	$rootScope.title = '[ '+$stateParams.user+' ] 的账户详情';
        }

        $scope.formdata = {
            filter: {
            	userName: $stateParams.user ? $stateParams.user: '',
                actOptType: '',
                status: -1,
                beginTimeStr: CPMisc.formatdate(new Date()) + ' 00:00:00',
                endTimeStr: CPMisc.formatdate(new Date(), true),
                orderNo: '',
                pageSize: 10,
                pageNo: 1
            },
            options: {
                actOptType: [],
                status: [{
                    value: -1,
                    label: '全部',
                }, {
                    value: 0,
                    label: '等待审核'
                }, {
                    value: 1,
                    label: '通过未审核'
                }, {
                    value: 2,
                    label: '通过审核'
                }],
            },
        };
        $scope.data = {
            accountDetails: [],
            userName: $stateParams.user
        };
        $scope.fun = {
            actType: function(id) {
                var actType = null;
                angular.forEach($scope.formdata.options.actOptType, function(type) {
                    if (type['typeCode'] == id) actType = type;
                });
                return actType;
            }
        };

        $scope.pageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageSize = page;
                $scope.formdata.filter.pageNo = pageSize;
                $scope.fun.accountDetailsSubmit().then(function() {

                });
            }
        };

        $scope.depositPageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageNo = page;
                $scope.formdata.filter.pageSize = pageSize;
                $scope.fun.accountDepositSubmit().then(function() {

                });
            }
        };

        $scope.withdrawPageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageNo = page;
                $scope.formdata.filter.pageSize = pageSize;
                $scope.fun.accountWithdrawSubmit().then(function() {

                });
            }
        };

        $scope.fun.accountDetailsSubmit = function() {
            return UserCenter.getAccountDetailItems($scope.formdata.filter).then(function(res) {
                $scope.data.accountDetails = res['data']['datas']['result'];
                $scope.pageConf = angular.extend($scope.pageConf, {
                    totalPage: res['data']['datas']['totalPages'],
                    pageSize: res['data']['datas']['pageSize'],
                    totalCount: res['data']['datas']['totalCount']
                });
            });
        };
        $scope.fun.actOptTypes = function() {
            UserCenter.accountActTypes().then(function(res) {
                $scope.formdata.options.actOptType = res['data']['datas'];
            });
        };

        // 充值
        $scope.fun.accountDepositSubmit = function() {
            if ($scope.formdata.filter.status == null) $scope.formdata.filter.status = '';
            return UserCenter.accountDepositOrders($scope.formdata.filter).then(function(res) {
                $scope.data.depositDetails = res['data']['datas']['result'];
                $scope.depositPageConf = angular.extend($scope.depositPageConf, {
                    totalPage: res['data']['datas']['totalPages'],
                    pageSize: res['data']['datas']['pageSize'],
                    totalCount: res['data']['datas']['totalCount']
                });
            });
        };

        // 汇款
        $scope.fun.accountWithdrawSubmit = function() {
            if ($scope.formdata.filter.status == null) $scope.formdata.filter.status = '';
            return UserCenter.accountWithdrawOrders($scope.formdata.filter).then(function(res) {
                $scope.data.withdrawDetails = res['data']['datas']['result'];
                $scope.withdrawPageConf = angular.extend($scope.withdrawPageConf, {
                    totalPage: res['data']['datas']['totalPages'],
                    pageSize: res['data']['datas']['pageSize'],
                    totalCount: res['data']['datas']['totalCount']
                });
            });
        };
        $scope.fun.actOptTypes();

        $scope.fun.accountDetailsSubmit();
        $scope.fun.accountDepositSubmit();
        $scope.fun.accountWithdrawSubmit();

    }])
    .controller('UserPlayWLostCtrl', ['$rootScope', '$scope', 'UserCenter', 'CPMisc', function($rootScope, $scope, UserCenter, CPMisc) {
        $rootScope.title = '个人盈亏';

        $scope.formdata = {};
        $scope.filter = {
            startTimeStr: CPMisc.formatdate(new Date(), true),
            endTimeStr: CPMisc.formatdate(new Date, true),
            pageSize: 10,
            pageNo: 1
        };
        $scope.data = {
            profitLogs: [],
        };
        $scope.pageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageSize = page;
                $scope.formdata.filter.pageNo = pageSize;
                $scope.fun.loadUserProfit();
            }
        };

        $scope.fun = {
            loadUserProfit: function() {
                UserCenter.selfProfit($scope.filter).then(function(res) {
                    $scope.data.profitLogs = res['data']['datas']['result'];
                    $scope.pageConf = angular.extend({}, $scope.pageConf, {
                        totalPage: res['data']['datas']['totalPages'],
                        pageSize: res['data']['datas']['pageSize'],
                        totalCount: res['data']['datas']['totalCount']
                    });
                });
            },
        };

        $scope.fun.loadUserProfit();

    }])
    .controller('UserUpdatePasswdCtrl', ['$rootScope', '$scope', '$stateParams', 'UI', 'UserCenter', function($rootScope, $scope, $stateParams, UI, UserCenter) {

        $scope.data = {
            loginPasswd: {
            	
            },
            withdrawPasswd: {
            	
            },
        };

        $scope.subFun = {
            resetForm: function() {
                $scope.data.loginPasswd = {};
                $scope.data.withdrawPasswd = {};
            },
            setTitle: function (formType) {
            	$scope.loginPasswdForm = formType;
            	if ($scope.loginPasswdForm == 0) {
            		$rootScope.title = '修改安全密码';
            	}
            	else {
            		$rootScope.title = '修改登录密码';
            	}
            },
        };
        $scope.subFun.updateLoginPasswd = function(form) {
            if (form.$valid) {
                var oldpwd = $scope.data.loginPasswd.oldpwd,
                    newpwd = $scope.data.loginPasswd.newpwd,
                    cfmpwd = $scope.data.loginPasswd.cfmpwd;
                if (oldpwd == newpwd) {
                    UI.alert('请输入与当前密码不同的新密码');
                } else if (cfmpwd != newpwd) {
                    UI.alert('请输入正确的确认新密码');
                } else {
                    UserCenter.updateLoginPasswd(oldpwd, newpwd, cfmpwd).then(function(res) {
                        if (res['data']['rs']) {
                            UI.alert(res['data']['msg']);
                        } else {
                            UI.alert(res['data']['msg']);
                        }
                    });
                }
            }
        };

        $scope.subFun.updateWithdrawPasswd = function(form) {
            if (form.$valid) {
                var oldpwd = $scope.data.withdrawPasswd.oldpwd,
                    newpwd = $scope.data.withdrawPasswd.newpwd,
                    cfmpwd = $scope.data.withdrawPasswd.cfmpwd;
            }
            if (oldpwd == newpwd) {
                UI.alert('请输入与当前密码不同的新密码');
            } else if (cfmpwd != newpwd) {
                UI.alert('请输入正确的确认新密码');
            } else {
                UserCenter.updateWithdrawPasswd(oldpwd, newpwd, cfmpwd).then(function(res) {
                    if (res['data']['rs']) {
                        UI.alert(res['data']['msg']);
                    } else {
                        UI.alert(res['data']['msg']);
                    }
                });
            }
        };
        
        if ($stateParams.pwdtype == 'withdrawpwd') {
        	$scope.loginPasswdForm = 0;
        }
        else {
        	$scope.loginPasswdForm = 1;
        }
        $scope.subFun.setTitle($scope.loginPasswdForm);

    }])
    .controller('UserBindmailCtrl', ['$rootScope', '$scope', '$interval', 'UserCenter', 'UI',
        function($rootScope, $scope, $interval, UserCenter, UI) {
            $scope.validate = {
                step: 1
            };

            $scope.formdata = {
                mail: '',
                sending: false,
                leftSecond: 0
            };

            $rootScope.loadAccountInfo().then(function() {
                if ($rootScope.global.user.mailStatus == 0) {
                    $scope.validate.step = 1;
                } else if ($rootScope.global.user.mailStatus == 1) {
                    $scope.validate.step = 3;
                }
                $scope.formdata.mail = $rootScope.global.user['userMail'];
            });

            $scope.fun = {
                sendMailAddress: function(form) {
                    if (form.$valid) {
                        $scope.formdata.sending = true;
                        UserCenter.sendBindMailAddress($scope.formdata.mail).then(function(res) {
                            $scope.formdata.sending = false;
                            if (res['data']['rs']) {
                                $scope.validate.step = 2;
                                $scope.fun.startSendAgainTimer();
                            } else {
                                UI.alert(res['data']['msg']);
                            }
                        });
                    }
                },
                startSendAgainTimer: function() {
                    $scope.formdata.leftSecond = 60;
                    $interval(function() {
                        $scope.formdata.leftSecond > 0 && $scope.formdata.leftSecond--;
                    }, 1e3);
                }
            };

        }
    ])
    .controller('UserProxyUseraddCtrl', ['$rootScope', '$scope', '$state' ,'UserCenter', 'UI',
        function($rootScope, $scope, $state , UserCenter, UI) {
            $rootScope.title = '开户中心';
            $scope.slider = {
                options: {
                    precision: 1,
                    step: 0.1
                },
            };

            var defaultFormData = {
                pc28Point: .9,
                cpPoint: 6.9,
                userType: 0
            };

            $scope.formdata = angular.extend({}, defaultFormData);
            $scope.links = [];

            $scope.fun = {
                addProxyUser: function(form) {
                    if (form.$valid) {
                        UserCenter.proxyOpenAccount($scope.formdata).then(function(res) {
                            if (res['data']['rs']) {
                                UI.alert('开户成功');
                                $state.go('user.proxy/customer');
                            } else {
                                UI.alert(res['data']['msg']);
                            }
                        });
                    }
                },
                generateRegisterLink: function(form) {
                    console.log(form);
                    if (form.$valid) {
                        UserCenter.proxyAddRegisterLink($scope.formdata).then(function(res) {
                            if (res['data']['rs']) {
                                $scope.fun.registerLinks();
                            }
                            UI.alert(res['data']['msg']);
                        });
                    }
                },
                registerLinks: function() {
                    UserCenter.proxyRegisterLinks().then(function(res) {
                        if (res['data']['rs']) {
                            $scope.links = res['data']['datas'];
                        } else {
                            //
                        }
                    });
                },
                deleteRegisterLink: function(link) {
                	console.log([link, link['regCode']]);
                    if (confirm("确认删除?")) {
                        UserCenter.proxyDelRegisterLink(link['regCode']).then(function(res) {
                            if (res['data']['rs']) {
                                $scope.fun.registerLinks();
                            }
                            UI.alert(res['data']['msg']);
                        });
                    }
                },
            };

            $scope.fun.registerLinks();
        }
    ])
    .controller('UserProxyIndexCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', 'CPMisc', function($rootScope, $scope, UserCenter, UI, CPMisc) {
        $rootScope.title = '代理首页';
        $scope.totalDates = {
            fromDate: '',
            toDate: ''
        };
        
        var Chart = window.Chart;
        Chart.defaults.global.legend.display = true;
        
        Chart.defaults.global.elements.point.radius = 5;
        Chart.defaults.global.elements.point.hitRadius = 2;
        
        $scope.data = {
        	summary: {
        		
        	},
        	chart: {
        		timeData: [],
        		labels: ["0", "1"],
        		series: ["投注量"],
        		data: [[1, 1]],
        		options: {
        			lines: {
        	            show: true,
        	            lineWidth: 2
        	        },
        	        colors: ["#009ED0"],
        	        points: {
        	            show: true
        	        },
        	        xaxis: {
        	            tickDecimals: 0,
        	            color: '#EEE',
        	            tickSize: 1,
        	            fontSize: 12
        	        },
        	        yaxis: {
        	            color: '#EEE'
        	        },
        	        crosshair: {
        	            mode: "x",
        	            color: '#CCCCCC'
        	        },
        	        grid: {
        	            borderWidth: 1,
        	            color: '#D9D9D9',
        	            hoverable: true,
        	            autoHighlight: true
        	        },
        			legend: {
        				display: true,
        				color: '#000',
        				position: 'top',
        				labels:{
        					boxWidth: 20,
        				},
        			},
        			tooltips: {
            			caretSize: 0,
            			cornerRadius: 0,
            			xPadding: 10,
            			yPadding: 10,
            			bodySpacing: 5,
            			fill: false,
        				callbacks: {
        					title: function (label) {
        						return '';
        					},
        					label: function (toolTipItem, data) {
        						var html = [];
        						html.push('时间: ' + $scope.data.chart.timeData[toolTipItem['xLabel']] );
        						html.push(data['datasets'][0]['label']+': '+toolTipItem['yLabel']);
        						return html;
        					},
        					
        				},
        			}
        		},
        	},
        	type: 'bet',
        	typeLabels: {
        		bet: '投注量',
        		draw: '提现量',
        		point: '返点',
        		user: '新增用户数',
        	},
        };
        
        $scope.fun = {
        	chartClick: function(points, evt) {
        		console.log(['clicked', arguments]);
        	},
            agentIndex: function() {
                UserCenter.agentIndex($scope.totalDates.fromDate, $scope.totalDates.toDate).then(function(res) {
                    if (!res.data.rs) {
                        return
                    };
                    
                    $scope.data.summary = angular.extend({}, res['data']['datas']['total'], {
                    	teamMoney: res['data']['datas']['teamMoney'],
                    	teamNum: res['data']['datas']['teamNum'],
                    });
                    
                    
                    // 检查时间范围
                    var dertMicSecond = Date.parse($scope.totalDates.toDate) - Date.parse($scope.totalDates.fromDate);
                    var dayType = 'hour';
                    if (dertMicSecond <= 2* 24 * 60 * 60 * 1000) {
                    	var resData = res['data']['datas'][$scope.data.type];
                    	$scope.data.chart.series = [$scope.data.typeLabels[$scope.data.type]];
                    	var labels = [];
                    	
                    	var chartData = [[]];
                    	angular.forEach(resData, function (resDataItem) {
                    		var hour = resDataItem[0] < 10 ? "0"+resDataItem[0]+":00": resDataItem[0]+ ":00";
                    		labels.push(resDataItem[0]);
                    		$scope.data.chart.timeData.push(hour);
                    		chartData[0].push(resDataItem[1]);
                    	});
                    	
                    	$scope.data.chart.labels = labels;
                    	$scope.data.chart.data = chartData;
                    	
                    }
                    else {
                    	dayType = 'day';
                    	
                    	var startSecTime = Date.parse($scope.totalDates.toDate);
                    	
                    	var resData = res['data']['datas'][$scope.data.type];
                    	$scope.data.chart.series = [$scope.data.typeLabels[$scope.data.type]];
                    	var labels = [];
                    	
                    	var chartData = [[]];
                    	angular.forEach(resData, function (resDataItem) {
                    		var day = CPMisc.formatdate(new Date(startSecTime + resDataItem[0]* 24 * 60 *60 * 1000));
                    		
                    		labels.push(resDataItem[0]);
                    		$scope.data.chart.timeData.push(day);
                    		chartData[0].push(resDataItem[1]);
                    	});
                    	
                    	$scope.data.chart.labels = labels;
                    	$scope.data.chart.data = chartData;
                    	
                    }
                });
            },
            setDay: function(day) {
                $scope.day = day;
                var date = new Date();
                var time = date.getTime();
                var startTime, endTime;
                startTime = time - (day * 24 * 60 * 60 + date.getHours() * 60 * 60 + date.getMinutes() * 60 + date.getSeconds()) * 1000;
                endTime = time;

                $scope.totalDates.fromDate = CPMisc.formatdate(new Date(startTime)) ;
                $scope.totalDates.toDate = CPMisc.formatdate(new Date(endTime));
            },
        };

        //监听日期变化调取ajax数据
        $scope.$watch('totalDates', function(newVal, oldVal) {
            if (newVal) {
                $scope.fun.agentIndex();
            };
        }, true);
        
        $scope.fun.setDay(0);

    }])
    .controller('UserProxyCustomerCtrl', ['$rootScope', '$scope', 'UI', 'CPMisc', 'UserCenter', function($rootScope, $scope, UI, CPMisc, UserCenter) {
        $rootScope.title = '客户管理';
        
        $scope.filter = {
            fromMoney: '',
            toMoney: '',
            days: '',
            userName: '',
            pageSize: 10,
            pageNo: 1
        };
        $scope.data = {
            members: [],
        };
        $scope.pageConf = {
            totalPage: 0,
            pageSize: 10,
            totalCount: 0,
            crtPage: 1,
            pageChange: function(page, pageSize) {
                $scope.formdata.filter.pageSize = page;
                $scope.formdata.filter.pageNo = pageSize;
            }
        };
        $scope.fun = {
        	loadMembers: function () {
        		UserCenter.loadMyMembers($scope.filter).then(function (res) {
        			if (res['data']['rs']) {
        				$scope.pageConf = angular.extend({}, $scope.pageConf, {
	                        totalPage: res['data']['datas']['totalPages'],
	                        pageSize: res['data']['datas']['pageSize'],
	                        totalCount: res['data']['datas']['totalCount']
        				});
        				$scope.data.members = res['data']['datas']['result'];
        			}
        		});
        	},
        	openUpdateProfitDialog: function (member) {
        		UserCenter.loadUserProfitPoint(member['userName']).then(function (res) {
        			if (res['data']['rs']) {
        				// 
        			}
        			else {
    					UI.alert(res['data']['msg']);
        			}
        		});
        		UI.openUpdateProfitDialog(member, function (updated) {
        			updated['userName'] = member['userName'];
        			UserCenter.updateProfitPoint(updated).then(function (res) {
        				if (res['data']['rs']) {
        					// 修改成功 
        					$scope.fun.loadMembers();
        				}
        				else {
        					UI.alert(res['data']['msg']);
        				}
        			});
        		});
        	}
        };
        
        $scope.fun.loadMembers();
        
    }])
    .controller('UserFundsChargeCtrl', ['$rootScope', '$scope', function($rootScope, $scope) {
        $rootScope.title = '我要充值';
    }])
    .controller('UserFundsWaterCtrl', ['$rootScope', '$scope', function($rootScope, $scope) {
        $rootScope.title = '我要返水';
    }])
    .controller('UserQuestionCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', function($rootScope, $scope, UserCenter, UI) {

        $rootScope.title = '设置安全问题';

        $scope.questionGroupA = [{
            value: '我的宠物名字？',
            question: '我的宠物名字？',
        }, {
            value: '我最亲密的朋友是？',
            question: '我最亲密的朋友是？'
        }, {
            value: '我最喜欢的演员？',
            question: '我最喜欢的演员？'
        }];

        $scope.questionGroupB = [{
            value: '我的宠物名字？',
            question: '我的宠物名字？',
        }, {
            value: '我最亲密的朋友是？',
            question: '我最亲密的朋友是？'
        }, {
            value: '我最喜欢的演员？',
            question: '我最喜欢的演员？'
        }];

        $scope.questionGroupC = [{
            value: '我的宠物名字？',
            question: '我的宠物名字？',
        }, {
            value: '我最亲密的朋友是？',
            question: '我最亲密的朋友是？'
        }, {
            value: '我最喜欢的演员？',
            question: '我最喜欢的演员？'
        }];

        $scope.formdata = {};

        $scope.fun = {
            submitForm: function(form) {
                if (form.$valid) {
                    UserCenter.setSecurityQuestionAnwser($scope.formdata).then(function(res) {
                        if (res['data']['rs']) {
                            $rootScope.loadAccountInfo();
                        }
                        UI.alert(res['data']['msg']);
                    });
                }
            },
            validateSecurityFormSubmit: function(form) {
                if (form.$valid) {
                    UserCenter.validateUserQA($scope.formdata).then(function(res) {
                        if (res['data']['rs']) {
                            $scope.formdata = {};
                            $scope.formdata.qaValidated = true;
                        } else {
                            UI.alert(res['data']['msg']);
                        }
                    });
                }
            },
            resetQASubmit: function(form) {
                if (form.$valid) {
                    UserCenter.updateSecurityQuestionAnwser($scope.formdata).then(function(res) {
                        if (res['data']['rs']) {
                            $rootScope.loadAccountInfo();
                            $scope.formdata.qaReset = true;
                            $scope.formdata.qaValidated = false;
                        }
                        UI.alert(res['data']['msg']);
                    });
                }
            }
        };
    }])
    .controller('UserRegisterCtrl', ['$rootScope', '$scope', '$state', '$stateParams', '$location', 'UI', 'UserCenter', 
    function($rootScope, $scope, $state, $stateParams, $location, UI, UserCenter) {
    	
    	var code = $location.search();
    	
        $rootScope.title = '注册新账号';
        $scope.formdata = {
        	regCode: code['code'] === true ? '': code['code'],
        };
        $scope.data = {
        	pwdStrongLength: 0
        };
        $scope.fun = {
        	registerSubmit: function (form) {
        		if ($scope.formdata.allowRule) {
        			if (form.$valid) {
        				UserCenter.registerAccount($scope.formdata).then(function (res) {
        					if (res['data']['rs']) {
        						$state.go('login');
        					}
        					else {
        						UI.alert(res['data']['msg']);
        					}
        				});
            		}
    			}
    			else {
    				UI.alert('如果您不条款协议，将无法进行注册');
    			}
        	},
            pwdChange: function () {
            	var pwd = $scope.formdata.password1;
            	if (!pwd) {
                	$scope.data.pwdStrongLength = 0;
            		return ;
            	}
            	
            	function hasLowerChar() {
            		return /[a-z]/.test(pwd);
            	}
            	
            	function hasUpperChar() {
            		return /[A-Z]/.test(pwd);
            	}
            	
            	function hasSepcialChar() {
            		return /[\~\!\@\#\$\%\^\&\*\(\)\_\+\{\}\[\]\"\:\>\<\>\?\/\-"]/.test(pwd);
            	}
            	
            	function isFullLength() {
            		return pwd.length == 20;
            	}
            	
            	var per = 10;
            	if (hasLowerChar()) {
            		per += 20;
            	}
            	if (hasUpperChar()) {
            		per += 30;
            	}
            	if (hasSepcialChar()) {
            		per += 30;
            	}
            	if (isFullLength()) {
            		per += 10;
            	}
            	$scope.data.pwdStrongLength = per;
            	
            }
        };
    }])
    .controller('UserOnlinePayCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', '$state',function($rootScope, $scope, UserCenter, UI, $state) {
        $rootScope.title = '在线充值';
        $scope.data = {
            step: 1,
        };
        var bank_code = '';
        $scope.formdata = {
            money:'',
        };
        //获取banklist
        UserCenter.bankPayList().then(function(res){
            $scope.onlineData = res.data.datas.online_bank;
            $scope.showWxOnline = angular.isEmpty(res.data.datas.online_wx);
            $scope.showCompany = angular.isEmpty(res.data.datas.company);
            $scope.showOnline = angular.isEmpty(res.data.datas.online_bank);
            $scope.showTradition_ali = angular.isEmpty(res.data.datas.tradition_ali);
            $scope.showTradition_wx = angular.isEmpty(res.data.datas.tradition_wx);
        },function(err){console.log(err)});
        //充值
        $scope.goPayCenter = function(){
            UserCenter.payCenterData($scope.formdata.money,bank_code,$scope.onlineData.payId).then(function(res){
                console.log(res);
                if(res.data.rs){
                    var pay_url = res.data.datas.pay_url;
                    var sendParams = res.data.datas.sendParams;
                    var url = window.location.protocol + '//' + window.location.host + baseURI + '#/payCenter';
                    localStorage.setItem('pay_url', pay_url);
                    localStorage.setItem('sendParams', sendParams);
                    window.open(url,'_blank');
                    $scope.data.step = 2;
                } else {
                    UI.alert(res.data.msg);
                    return ;
                }
            },function(err){console.log(err)});
        };
    }])
    .controller('UserWeixinPayCtrl', ['$rootScope', '$scope', 'UserCenter', 'UI', '$state',function($rootScope, $scope, UserCenter, UI, $state) {
        $rootScope.title = '微信充值';

        $scope.data = {
            step: 1,
        };
        $scope.formdata = {
            money:'',
        };
        //获取banklist
        UserCenter.bankPayList().then(function(res){
            $scope.onlineWxData = res.data.datas.online_wx;
            $scope.showWxOnline = angular.isEmpty(res.data.datas.online_wx);
            $scope.showCompany = angular.isEmpty(res.data.datas.company);
            $scope.showOnline = angular.isEmpty(res.data.datas.online_bank);
            $scope.showTradition_ali = angular.isEmpty(res.data.datas.tradition_ali);
            $scope.showTradition_wx = angular.isEmpty(res.data.datas.tradition_wx);
        },function(err){console.log(err)});
        //充值
        $scope.goPayCenter = function(){
            UserCenter.wxPayCenterData($scope.formdata.money,$scope.onlineWxData.bank_code,$scope.onlineWxData.payId,$scope.onlineWxData.payType,$scope.onlineWxData.choosePayType).then(function(res){
                console.log(res);
                if(res.data.rs){
                    var pay_url = res.data.datas.pay_url;
                    var sendParams = res.data.datas.sendParams;
                    var url = window.location.protocol + '//' + window.location.host + baseURI + '#/payCenter';
                    localStorage.setItem('pay_url', pay_url);
                    localStorage.setItem('sendParams', sendParams);
                    window.open(url,'_blank');
                    $scope.data.step = 2;
                } else {
                    UI.alert(res.data.msg);
                    return ;
                }
            },function(err){console.log(err)});
        };
    }])
    .controller('UserCulturePayCtrl', ['$rootScope', '$scope','UserCenter', 'UI', function($rootScope, $scope, UserCenter, UI) {
        $rootScope.title = '公司入款';

         $scope.data = {
            step: 1,
        };
        var bank_code = '';
        $scope.formdata = {
            hkMoney:'',
            payNo:'',
            hkCompanyBank:'',
            hkType:'',
            payTime:'',
            hkUserName:'',
        };
        //获取banklist
        UserCenter.bankPayList().then(function(res){
            $scope.companyData = res.data.datas.company;
            $scope.companyData.bankLists = $scope.companyData.bankList.map(function(bank,index){
                var result = {};
                for(var i in bank){
                    result['id'] = i;
                    result['name'] = bank[i];
                }
                return result;
            });

            $scope.showWxOnline = angular.isEmpty(res.data.datas.online_wx);
            $scope.showCompany = angular.isEmpty(res.data.datas.company);
            $scope.showOnline = angular.isEmpty(res.data.datas.online_bank);
            $scope.showTradition_ali = angular.isEmpty(res.data.datas.tradition_ali);
            $scope.showTradition_wx = angular.isEmpty(res.data.datas.tradition_wx);
        },function(err){console.log(err)});
        //充值
        $scope.goPayCenter = function(){
            if($scope.formdata.payNo){
                $scope.formdata.hkCompanyBank = $scope.companyData.bankLists.filter(function(a,b){
                    return a.id == $scope.formdata.payNo;
                })[0]['name'];
            }
            UserCenter.companyPayCenterData($scope.formdata).then(function(res){
                if(res.data.rs){
                    UI.alert(res.data.msg);
                    $scope.data.step = 2;
                } else {
                    UI.alert(res.data.msg);
                    return ;
                }
            },function(err){console.log(err)});
        };
    }])
    .controller('payCenter', ['$rootScope', '$scope', '$stateParams', function($rootScope, $scope, $stateParams) {
        $rootScope.title = '充值中心';
        payCenterForm.attributes[0].value = 'http://'+localStorage.getItem('pay_url');
        payCenterForm[0].value = localStorage.getItem('sendParams');
        payCenterForm.submit();
        // 充值完了清空信息
        setTimeout(function(){
            localStorage.setItem('pay_url', '');
            localStorage.setItem('sendParams', '');
        }, 5000);
    }]);