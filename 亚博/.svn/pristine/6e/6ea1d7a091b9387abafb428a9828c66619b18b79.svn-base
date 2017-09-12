angular.module('cpApp')
.factory('UI', ['ngDialog', '$rootScope', '$timeout' ,function (ngDialog, $rootScope, $timeout) {
	
	function _alert(msg, title, autoClose, staySecond, clsNames) {
		
		title = title || ('温馨提示');
		autoClose = typeof autoClose == 'undefined' ? true : autoClose;
		clsNames = clsNames || '';
		if (autoClose) {
			staySecond = staySecond || 3e3; // 默认3秒自动关闭
		}
		var dialog = ngDialog.open({
			template: templateBaseURI + '/dialog/alert.html',
			appendClassName: clsNames,
			data: {msg: msg, title: title},
		});
		if (autoClose) {
			$timeout(function () {
				dialog.close();
			}, staySecond);
		}
		
		return dialog;
	}
	
	return {
		alert: function (msg, title, autoClose, staySecond) {
			return _alert(msg, title, autoClose, staySecond, 'alert-dialog');
		},
		showup: function (msg, title, autoClose, staySecond) {
			console.log('show up');
			return _alert(msg, title, autoClose, staySecond, 'showup-dialog');
		},
		exceptionAlert: function (msg, canBeClose) {
			canBeClose = canBeClose === undefined ? true: canBeClose;
			var options = {
				template: "<p class='alert-msg'>{{ngDialogData.msg}}</p>",
				plain: true,
				appendClassName: 'exception-dialog',
				data: {msg: msg},
			};
			if (!!!canBeClose) {
				options['showClose'] = false;
				options['closeByEscape'] = false;
				options['closeByNavigation'] = true;
				options['closeByDocument'] = false;
			}
			ngDialog.open(options);
		},
		openAlertMask: function(content, autoClose, maskAttachTo, closeHandler) {
			autoClose = autoClose == 'undefined' ? true: false;  // 是否自动关闭
			closeHandler = closeHandler || (function () {}); // 关闭后 回调函数
			
			var options = {
				data: {msg: content},
				plain: true,
				appendTo: maskAttachTo,
				showClose: true,
				closeByEscape: true,
				closeByNavigation: true,
				preCloseCallback: closeHandler,
				appendClassName: 'mask-ngDialog',
				template: '<p class="mask-msg">{{ngDialogData.msg}}</p>',
			};
			if (!autoClose) {
				options['showClose'] = false;
				options['closeByEscape'] = false;
				options['closeByDocument'] = false;
			}
			ngDialog.open(options);
			
			var cancelListenOpened = $rootScope.$on('ngDialog.opened', function (e, $dialog) {
				angular.element(document.body).addClass('mask-dialog-open');
				cancelListenOpened();
			});
			var cancelListenClosed = $rootScope.$on('ngDialog.closed', function (e, $dialog) {
				angular.element(document.body).removeClass('mask-dialog-open');
				cancelListenClosed();
			});
		},
		openUpdateProfitDialog: function (member, confirmCb, cancelCb) {
			confirmCb = confirmCb || (function () {});
			cancelCb = cancelCb || (function () {});
			
			var options = {
					data: {
						member: member,
						updated: {
							pc28Point: member['pc28Point'],
							cpPoint: member['cpPoint'],
						},
						confirm: function (data) {
							confirmCb(data);
							return true;
						},
						cancel: function () {
							cancelCb();
							return true;
						},
					},
					showClose:false,
					closeByEscape: true,
					closeByNavigation: true,
					closeByDocument: false,
					appendClassName: 'member-profit-ngDialog alert-dialog',
					template: templateBaseURI + '/dialog/member-profit.html',
				};
				

			var dialog = ngDialog.open(options);
			
		},
		openBetConfirmDialog: function (summaryData, orders, confirmCb, cancelCb) {
			confirmCb = confirmCb || (function () {});
			cancelCb = cancelCb || (function () {});
			
			var options = {
				data: {
					total: summaryData['total'],
					totalMoney: summaryData['totalMoney'],
					orders: orders,
					confirm: function () {
						confirmCb();
						return true;
					},
					cancel: function () {
						cancelCb();
						return true;
					},
				},
				showClose:false,
				closeByEscape: true,
				closeByNavigation: true,
				closeByDocument: false,
				appendClassName: 'bet-order-confirm-ngDialog',
				template: templateBaseURI + '/dialog/betConfirmDialog.html',
			};
			
			ngDialog.open(options);
		},
	};
}]);