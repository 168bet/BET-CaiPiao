angular.module('cpApp')
.factory('CPMisc', ['$http', 'UserCenter', 'gameService', '$q', '$stateParams', function ($http, UserCenter, gameService, $q, $stateParams) {
	return {
		NORMAL_FLAG: 'normal',
		CL_FLAG: 'cl',
		LM_FLAG: 'lm',
		MUL_FLAG: 'mul',
		YZGG_FLAG: 'yzgg',
		GROUP_FLAG: 'group',
		PABC_FUSHI: 1,
		PABC_DANTUO: 2,
		cpWinnerList: function () {
			return $http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/getWinningList',
			}));
		},
		noticeList: function (type) {
			return $http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/platformAnnouncement/announcement',
				data: {
					announcement: type,
				},
			}));
		},
		formatdate: function (date, withtime) {
			var month = date.getMonth() + 1 < 10 ? "0" + ( date.getMonth() + 1): date.getMonth() + 1;
			var day = date.getDate() < 10 ? "0" + date.getDate(): date.getDate();
			var time = '';
			if (withtime) {
				time = " "+ ("0"+date.getHours()).slice(-2) + ':'+ ("0"+date.getMinutes()).slice(-2) + ':' + ("0"+date.getSeconds()).slice(-2);
			}
			return date.getFullYear() + '-' +  month + '-' + day + time;
		},
		cpGameCodes: function() {
			return $http({
				url: baseURI + '/cpOrder/getCpGameCodeList',
				method: 'GET'
			});
		},
		recentIssue: function (gameCode) {
			return gameService.getData('/game/recent-issues', {
	            params: {
	                gameCode: gameCode
	            },
	            timeout: 30000
	        });
		},
		loadOrderDetail: function (orderId) {
			return $http({
				url: baseURI + '/cpOrder/orderDetail/'+orderId,
			});
		},
		saveOrder: function (gameCode, flag, data, qs) {
			qs = qs || $stateParams.qs;
			console.log($stateParams);
			console.log(['gamecode', gameCode]);
			var hasQsGameCodes = ['BJKL8', 'CAKENO'];
			
			// if (hasQsGameCodes.indexOf(gameCode) !== -1) {
			// 	qs = '';
			// }
			
			return $http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/saveOrder',
				data: {
					qs: qs,
					orderFlag: flag,
					gameCode: gameCode,
					jsons: JSON.stringify(data)
				}
			}));
		},
		getLmOrders: function (numbers, rrtype, pabc, dm1, dm2) {
			var defer = $q.defer();
			$http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/goLmOrder',
				data: {
					nums: numbers,
					gameCode: 'HK6',
					rrtype: rrtype,
					pabc: pabc,
					dm1: dm1,
					dm2: dm2
				},
			})).then(function (res) {
				var data = res['data'];
				
				if (typeof data['orderList'] == 'undefined') {
					defer.reject(res);
				}
				else {
					defer.resolve(data);
				}
			});
			
			return defer.promise;
		},
		getZybzOrders: function (cids, multilen) {
			var defer = $q.defer();
			$http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/goMultiGroupOrder',
				data: {
					cids: cids,
					gameCode: 'HK6',
					multilen: multilen
				},
			})).then(function (res) {
				var data = res['data'];
				
				if (typeof data['orderList'] == 'undefined') {
					defer.reject(res);
				}
				else {
					defer.resolve(data);
				}
			});
			
			return defer.promise;
		},
		getYzggOrders: function (bwNum, swNum, gwNum, gameCode, typeCode, cateCode , multilen) {
			var defer = $q.defer();
			$http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/getGroupOrderList',
				data: {
					bwNum: bwNum ? bwNum : '',
					swNum: swNum ? swNum : '',
					gwNum: gwNum ? gwNum: '',
					gameCode: gameCode,
					typeCode: typeCode,
					cateCode: cateCode,
					multilen: multilen
				},
			})).then(function (res) {
				var data = res['data'];
				
				if (typeof data['orderList'] == 'undefined') {
					defer.reject(res);
				}
				else {
					defer.resolve(data);
				}
			});
			
			return defer.promise;
		},
		getZxOrders: function (nums, gameCode, typeCode, cateCode, multilen) {
			var defer = $q.defer();
			$http(angular.extend(UserCenter.defaults, {
				url: baseURI + '/cpOrder/getGroupOrderList',
				data: {
					num: nums,
					gameCode: gameCode,
					typeCode: typeCode,
					cateCode: cateCode,
					multilen: multilen
				},
			})).then(function (res) {
				var data = res['data'];
				if (typeof data['orderList'] == 'undefined') {
					defer.reject(res);
				}
				else {
					defer.resolve(data);
				}
			});
			
			return defer.promise;
		}
		
	};
}]);