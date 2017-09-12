var nid = location.search.getParam('nid');//微信昵称
var uid = location.search.getParam('uid');//9188用户名
var CP = {};
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p.center').html(msg);
			tag && $('#dAlert a.tureBtn').html(tag) || $('#dAlert a.tureBtn').html('确定');
			$('#mask, #dAlert').show();
			$('#dAlert a.tureBtn').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert,#mask').hide();
			});
		}
};
//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
};
CP.wxbind = (function(){
	var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
	var o = {
			bind_1: function(){
				$('#tab_u li').bind(start_ev, function(){
					if($(this).hasClass('cur')){
						return;
					}
					$(this).addClass('cur').siblings().removeClass('cur');
					$('#nuser_1,#nuser_2').hide();
					$('#nuser_'+$(this).attr('v')).show();
				});
				$('#isEnroll').click(function(){
					var u = $.trim($("#new_user").val());
					var p = $.trim($("#new_pwd").val());
					o.enroll(u,p,'绑定');
				});
				$('#isBind').click(function(){
					var u = $('#old_user').val();
					var p = $('#old_pwd').val();
					o.reg(u,p,'绑定');
				});
			},
			bind_3: function(){
				$('#relieve').click(function(){
					o.bind_4();
				});
			},
			bind_4: function(){
				$('#div_1,#div_2,#div_3,#div_4').hide();
				$('#div_4').show();
				$('#revise').click(function(){
					var u = $.trim($("#r_user").val());
					var p = $.trim($("#r_pwd").val());
					o.reg(u,p,'修改绑定');
				});
			},
			enroll : function(iName,iCode,msg){//注册
				var len = iCode.length;
				var cat = /^[\x20-\x7f]+$/;
				if(iName == "" && len == 0){
					D.alert('请输入用户名和密码');
					return false;
				}else if(iName == ""){
					D.alert('请输入用户名');
					return false;
				}else if (len == 0) {
					D.alert("请输入密码");
					return false;
				} else if (len < 6) {
					D.alert('您输入的密码不能低于6位');
					return false;
				} else if (len > 20) {
					D.alert('您输入的密码不能超过20位');
					return false;
				} else if (iCode == iName) {
					D.alert('密码不能够与用户名一致！请重新输入');
					return false;
				}else if (!(cat.test(iCode))) {
					D.alert('密码请勿包含中文');
					return false;
				}else{
					var data = 'uid='
					+ encodeURIComponent($.trim(iName))
					+ "&pwd="
					+ encodeURIComponent($.trim(iCode));
					$.ajax({
						 url: '/wechat/wxRegister.go',
				     	 type: 'POST',
				         data: data,
				         DataType:'XML',
				         success:function (xml){
				        	 var R = $(xml).find('Resp');
				        	 var c = R.attr('code');
				        	 var d = R.attr('desc');
				        	 if(c == 0){
				        		 localStorage.setItem("username", iName);
				        		o.reg(iName,iCode,msg);
				        	 }else{
				        		alert(d);
				        	 }
				         },
				         error:function(){
				        	  D.alert('网络异常');
				         }
				     });
				}
			},
			reg : function(iName,iCode,msg){//绑定
				var len = iCode.length;
				var cat = /^[\x20-\x7f]+$/;
				if(iName == "" && len == 0){
					D.alert('请输入用户名和密码');
					return false;
				}else if(iName == ""){
					D.alert('请输入用户名');
					return false;
				}else if (len == 0) {
					D.alert("请输入密码");
					return false;
				} else if (len < 6) {
					D.alert('您输入的密码不能低于6位');
					return false;
				} else if (len > 20) {
					D.alert('您输入的密码不能超过20位');
					return false;
				} else if (iCode == iName) {
					D.alert('密码不能够与用户名一致！请重新输入');
					return false;
				}else if (!(cat.test(iCode))) {
					D.alert('密码请勿包含中文');
					return false;
				}else{
					var data = 'uid='
					+ encodeURIComponent($.trim(iName))
					+ "&pwd="
					+ encodeURIComponent($.trim(iCode));
					$.ajax({
						 url: '/wechat/wxAuthorBind.go',
				     	 type: 'POST',
				         data: data,
				         DataType:'XML',
				         success:function (xml){
				        	 var R = $(xml).find('Resp');
				        	 var c = R.attr('code');
				        	 var d = R.attr('desc');
				        	 if(c == 0){
				        		 localStorage.setItem("username", iName);
				        		 $('#div_1,#div_2,#div_3,#div_4').hide();
				        		 $('#div_2').show();
				        		 $('#win').html(msg);
				        	 }else{
				        		 alert(d);
				        	 }
				         },
				         error:function(){
				        	  D.alert('网络异常');
				         }
				     });
				}
			}
	};
	var init = function(){
		$('#name_1,#name_2,#name_3').html(nid);
		$('#u9188').html(uid);
		$.ajax({
			url:'/user/mchklogin.go',
			type:'GET',
			DataType:'XML',
			success: function(xml){
				var R = $(xml).find('Resp');
				var code = R.attr('code');
				if(code==10000){//未登录
					//div_1 绑定、注册    div_2 绑定，注册成功     div_3 已绑定     div_4修改绑定
					$('#div_1').show();
					o.bind_1();
				}else if(code==10001){//已登录
					$('#div_3').show();
					o.bind_3();
				}
			}
		});
	};
	return {init : init};
})();
CP.wxbind.init();