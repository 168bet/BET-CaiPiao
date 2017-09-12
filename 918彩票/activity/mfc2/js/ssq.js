
var CP={};
CP.Util={};

CP.MobileVer = (function ($) {
	//var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();
CP.calcTime = function (d, offset) {
	utc = d.getTime() + (d.getTimezoneOffset() * 60000);
	var nd = new Date(utc + (3600000*offset));
	return nd;
};
/**
 * @description 获取两个时间相差的天数
 * @param {Date} sDate1/sDate2 时间 yyyy-MM-dd格式
 * @return {Number} 返回相差天数
 */
CP.Util.dateDiff=function(sDate1, sDate2) {  //sDate1和sDate2是yyyy-MM-dd格式
    var aDate, oDate1, oDate2, iDays;
    aDate = sDate1.split("-");
    oDate1 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);  //转换为yyyy-MM-dd格式
    aDate = sDate2.split("-");
    oDate2 = new Date(aDate[1] + ',' + aDate[2] + ',' + aDate[0]);
    iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24); //把相差的毫秒数转换为天数
    return iDays;  
};
CP.Util.pad=function (source, length) {
	var pre = "",
	negative = (source < 0),
	string = String(Math.abs(source));
if (string.length < length) {
	pre = (new Array(length - string.length + 1)).join('0');
}
return (negative ? "-" : "") + pre + string;
};

//公用弹出层和加载层
var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 1e3);
	} else {
		$('body').append($('<div class="alertBox"><div class="box_loading"><div class="loading_mask"></div></div>' + msg + '</div>'));
		$('.alertBox').css({"webkitAnimationName": "boxfade_loading", "opacity": 0.8});
		$('#mask').show();
	}
};
var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};


var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		alert:function(msg, fn, tag){
			$('#dAlert p').html(msg);
			tag && $('#dAlert a.bfb').html(tag) || $('#dAlert a.bfb').html('确定');
			$("#dAlert").show();
			$(".zhezhao").show();
			$('#dAlert a.bfb').one('click',function(){
				if(typeof(fn) == "function"){fn();}
				$('#dAlert').hide();
				$(".zhezhao").hide();
			});
		},
		confirm:function(msg, fn, tag){
			$('#dConfirm p').html(msg);
			tag && $('#dConfirm div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			$('#dConfirm').show();
			$(".zhezhao").show();
			$('#dConfirm a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
			});
			$('#dConfirm a:eq(1)').one('click',function(){//确定
				//if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
		},
		
		confirm_login:function(msg,fn,fn1,tag,tag1){
			$('#dConfirm_login p').html(msg);
			tag && $('#dConfirm_login div.zfTrue a:eq(0)').html(tag) || $('#dConfirm div.zfTrue a:eq(0)').html('确定');
			tag1 && $('#dConfirm_login div.zfTrue a:eq(1)').html(tag1) || $('#dConfirm div.zfTrue a:eq(0)').html('取消');
			$('#dConfirm_login').show();
			$(".zhezhao").show()
			$('#dConfirm_login a:eq(0)').one('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
			$('#dConfirm_login a:eq(1)').one('click',function(){//确定
				if(typeof(fn1) == "function"){fn1();}
				$('#dConfirm').hide();
				$(".zhezhao").hide();
			});
		}
};

CP.ZLK=(function(){
	var hasTouch = 'ontouchstart' in window;
	var start_ev = hasTouch ? 'touchstart' : 'mousedown';
	var end_ev = hasTouch ? 'touchend' : 'mouseup';
	
	var init=function(){
		bindEvent()
	};
	
	
	var p={
			gid:"01",
			pid:"",
			codes:"",
			atime:"",
			fg:0//0:未登录,1登录
	}
	
	var get_qc=function(){
		var qc=""
		$.ajax({
			url:'/trade/info.go?gid=01',
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var rows = $(xml).find("rows");
				var pid = rows.attr("pid");
				p.pid=qc=pid;
				var atime = rows.attr("atime");
				g.atime=atime;//开奖时间
			}
		})
		return qc;
	}
	
	
	var getCode=function(){
		var codeString="";
		var redValue = "";
		var blueValue = "";
		$("#redBall cite.cur").each(function(){
			redValue+=$(this).text()+",";
		});
		redValue = redValue.substring(0, redValue.length-1);
		$("#blueBall cite.cur").each(function(){
			blueValue+=$(this).text()+",";
		});
		blueValue = blueValue.substring(0, blueValue.length-1);
		codeString = redValue+"|"+blueValue+":1:1";
		return codeString;
	}
	
	var bindEvent=function(){
		o.getTime();//获取系统时间
		$("#kj_slide").bind(start_ev,function(){//显隐开奖列表
			if($(this).find('.ssqup').hasClass('ssqdown')){
				$(this).next().show();
			}else{
				$(this).next().hide();
			}
			$(this).find('.ssqup').toggleClass('ssqdown');
		});
		
		//点击高亮显示红球
		$("#redBall cite").bind("click",function(){
			$(this).toggleClass("cur");
			$(this).toggleClass("ball_scale");
		});
		
		//点击高亮显示篮球
		$("#blueBall cite").bind("click",function(){
			$(this).toggleClass("cur");
			$(this).toggleClass("ball_scale");
		});
		
		//关闭登录层
		$(".clock").bind("click",function(){
			$("#dConfirm_login").hide();
			$(".zhezhao").hide();
		});
		
		$("#rules").bind("click",function(){
			$("#rulesCont").toggleClass("cur");
			$("body").scrollTop(999999);
		});
		
		//愉悦手下
		$(".popup").bind("click",function(){
			$(this).hide();
			$(".zhezhao").hide();
		});
		
		$(".popup2").bind("click",function(){
			$(this).hide();
			$(".zhezhao").hide();
		});
		
		//免费参与竞猜
		$("#btn").bind("click",function(){
			var redNum = parseInt($("#redBall cite.cur").length);
			var blueNum = parseInt($("#blueBall cite.cur").length);
			if(redNum !=6 || blueNum !=1){
				alert("请选择6个红球和1个蓝球")
				return;
			}
			
			//var pid=get_qc();
			var codes = getCode();
			var data = {
					gid : "01",//彩种编号
					pid : p.pid,//期号
					codes : codes//投注号码
			};
			$.ajax({
				url:"/activity/joinFreeGuess.go",
				dataType:'xml',
				data: data,
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code=="0"){//参与竞猜成功,并且去投注页面
						D.alert("免费参与竞猜成功");
					}else if(code=="1005"){//未绑定手机号码
						D.confirm("参与活动前,需先绑定手机号!",function(){
							window.location.href="phone.html";
						},"去绑定");
					}else if(code=="1006"){//未绑定身份证号码
						D.confirm("参与活动前,需先完善实名认证!",function(){
							window.location.href="idcard.html";
						},"去认证")
					}else if(code=="1"){
						D.confirm_login("参与活动前,需先登录!",function(){
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(3, '');
								} catch (e){
									window.location.href = "login.html";
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
									WebViewJavascriptBridge.callHandler('clickIosLogin');
								} catch (e){
									window.location.href = "login.html";
								}
							}else{//4g
								window.location.href = "login.html";
							}
						},function(){//注册
							if(CP.MobileVer.android){//android
								try {
									window.caiyiandroid.clickAndroid(4, '');
								} catch (e){
									window.location.href = "register.html";
								}
							}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
								try {
									WebViewJavascriptBridge.callHandler('clickIosRegister');
								} catch (e){
									window.location.href = "register.html";
								}
							}else{//4g
								window.location.href = "register.html";
							}
						},"登录","注册");
					}else{
						D.alert(desc)
					}
				},
			});
			
		});
	};
	
	var g = {
			'zhushu' : 0,//注数
			'beishu' : 1,//倍数
			'qishu' : 1,//追号期数
			'totalMoney' : 0,//投注总金额
			'zhuijia' : 2,//是否追加 追加为3 不追加为2
			'codes' : '',//投注号码
			'buyType' : 1,//1:自购 2:合买3:追号
			'loty_id' : "01", //彩种id
			'qihao_id' : '',//当前期号
			'hmMoney' : ''//合买应付金额
		};
	
	var o={
			
			
			
			/*获取期号数据[[*/
			getTime : function(){
				o.getQihao(function(data){
					var t = data.length,kjhtml='';
					for(var n=0; n<t; n++){
						var red = data[n].acode.split('|')[0];
						var blue = data[n].acode.split('|')[1];
						red = red.replace(/,/g,' ');
						blue = blue.replace(/,/g,' ');
						kjhtml += '<ul><li class="first">'+data[n].pid.substr(4,3)+'期</li><li><span class="red">'+red+'</span>&nbsp;<span class="blue">'+blue+'</span></li></ul>';
					}
					$("#kj_slide").next().html(kjhtml);
				});
			},
			/*]]获取期号数据*/
			
			
			/*渲染期号信息[[*/
			renderQihao:function(data){
				g.qihao_id=data.pid;  //设置当前期号
				var wk=["日","一","二","三","四","五","六"];
				var now = CP.calcTime(data.now,'+8');
				var et = data.atime;
				var severtime = now.getFullYear()+'-'+CP.Util.pad(now.getMonth()+1,2)+'-'+CP.Util.pad(now.getDate(),2);
				var et1 = et.substr(11,5),et2 = et.substr(0,10),et3 = et.substr(5,6);
				var timeText = '';
				timeText = CP.Util.dateDiff(severtime,et2);
				timeText = {'0':'今天','1':'明天','2':'后天'}[timeText]||et3;
				var tDATE = et.substr(0,10);
				tDATE = new Date(tDATE);
				var wk2 = '周'+wk[tDATE.getDay()];
				if(timeText!=''){
					$("#issue_info").html('第'+data.pid+'期 '+ timeText +''+ et1 +'('+wk2+') 截止');
					return true;
				}else{
					return false;
				}
			},
			/*]]渲染期号信息*/
			
			/*请求期号接口[[*/
			getQihao:function(callback){
				if(callback){
					$.ajax({
						url:'/trade/info.go?gid=01',
						dataType:'xml',
						cache:true,
//						async:callback?false:true,
						success: function(xml) {
							var data = {},issueInfo = [],miss_ = {};
							var R = $(xml).find('rows');
							p.pid=data.pid = R.attr('pid');//
							data.atime = R.attr('atime');//开奖时间
							data.tn = R.attr('tn');//购买状态
							data.now = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
							o.renderQihao(data);
							var rp = R.find('rowp');
							rp.each(function(a){
								var t = {};
								t.pid = $(this).attr('pid');//期号
								t.acode = $(this).attr('acode');//开奖号码
								t.tn = $(this).attr('tn');//认购状态
								issueInfo[a] = t;
							});
							
							/***
							if(lotteryType == 'ssq' || lotteryType == 'dlt'){//双色球和大乐透遗漏
								var r = R.find('row');
								r.each(function(){
									var color = $(this).attr('color');
									var curyl = $(this).attr('curyl');
									if(color == 'red'){
										miss_.red = curyl;
									}else{
										miss_.blue = curyl;
									}
								});
								o.miss(miss_);
								$('#yl').bind(start_ev,function(){
									if($(this).find('.omitico').hasClass('omitico2')){
										$(this).removeClass('red').addClass('gray');
										$dom.$ballRed.find('.omitnum').hide();
										$dom.$ballBlue.find('.omitnum').hide();
									}else{
										$(this).removeClass('gray').addClass('red');
										$dom.$ballRed.find('.omitnum').show();
										$dom.$ballBlue.find('.omitnum').show();
									}
									$(this).find('.omitico').toggleClass('omitico2');
								});
							}
							***/
							callback(issueInfo);
						},
						error:function(){
							$dom.$issueInfo.html('网络不通畅，请点击刷新');
							$dom.$issueInfo.bind(end_ev,function(){
								window.location.reload();
							});
						}
					});
				}else{
					return false;
				}
			}
	}
	
	
	return {
		init:init
	};
})();

$(function(){
	CP.ZLK.init();
})