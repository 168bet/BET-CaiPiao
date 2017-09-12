String.prototype.getParam = function(n){
		var r = new RegExp("[\?\&]"+n+"=([^&?]*)(\\s||$)", "gi");
		var r1=new RegExp(n+"=","gi");
		var m=this.match(r);
		if(m==null){
			return "";
		}else{
			return typeof(m[0].split(r1)[1])=='undefined'?'':decodeURIComponent(m[0].split(r1)[1]);
		}
	};
	

var pageLoading = {
		show: function () {
			if ($("#loadpop").length) {
				$("#loadpop").show();
			} else {
				$(document.body).append($('<div class="loadpop" id="loadpop"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>'));
			}
		},
		hide: function () {
			setTimeout(function () {
				$("#loadpop").fadeOut();
			}, 150);
		}
};

	

var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 1000);
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

var CP={};

CP.MobileVer = (function ($) {
	var tag = location.search.getParam('tag') || false;//ios 判断版本 不为false调他们的充值页面 否则弹窗提示
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
CP.Util={};
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

CP.ZLK=(function(){
	var date_ = '';
	
	
	//初始化方法
	var init=function(){
		//getQihao();
		setJx();
		tokenLogin();
		//jcjlInfo();
		bindEvent();
	};
	
	
	var zeroStr=function (num, n) {
	    var len = num.toString().length;
	    while(len < n) {
	        num = "0" + num;
	        len++;
	    }
	    return num;
	};
	
	
	
	 /*渲染期号信息[[*/
	 var renderQihao=function(data){
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
			$("#qcCont span").html('双色球'+data.pid+'期 '+ timeText +''+'<cite class="red">'+ et1+'</cite>' +'('+wk2+') 截止');
			//$("#qcCont span").html('双色球'+data.pid+'期,'+timeText+'<cite class="red">'+et1+'</cite>开奖')
			return true;
		}else{
			return false;
		}
	};
	/*]]渲染期号信息*/
	
	//生成随机数
	var Random=function(count) {
	    var original = new Array; //原始数组 
	    //给原始数组original赋值 
		for (var i = 0; i < count; i++) {
	        original[i] = i + 1;
	    }
	    original.sort(function() { return 0.5 - Math.random(); });
	    var arrayList = new Array();
	    for (var i = 0; i < count; i++) {
	        arrayList[i] = original[i];
	    }
	    return arrayList;
	};
	
	var jxNum=function(obj){
		var ssq = Random(33),i;
		ssq = ssq.slice(0,6).sort(function(a,b){return a-b;});
		for(i=0; i<6; i++){
			obj[i].innerHTML=zeroStr(ssq[i],2);
		}
		var ssq_b = Random(16);
		obj[6].innerHTML=zeroStr(ssq_b[6],2);
	};
	var setJx=function () {//机选一注
        clearInterval(j_);
        var g = 0,
        q = 100;
        $('#ball span').addClass('rotate_jx');
        jxNum($('#ball span'));
        var j_ = setInterval(function () {
            $('#ball span:eq(' + g + ')').removeClass('rotate_jx');
            g++;
            if (g > 6) {return false;}
        }, q);
	};
	
	
	//判断用户是否登录，如果登录显示竞猜记录
	var jcjlInfo = function(){
		$.ajax({
			url:"/activity/userFreeGuessCon.go?gid="+g.gid+"&pid="+g.pid,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				
				var rows = R.find("rows");
				var sumnums = rows.attr("sumnums");//用户总共参与该活动的次数
				var nickid = rows.attr("nickid");//用户名
				var remainnums = rows.attr("remainnums");
				var todaynums = rows.attr("todaynums");
				todaynums=todaynums?todaynums:"20";
				
				var peoplenum = rows.attr("peoplenum");
				var joinnum = rows.attr("joinnum");
				
				if(code=="0"){//登录,如果登录了显示：“竞猜记录”层
					
					$("#jcjlInfo").html('<p>'+nickid+ '<cite>(累计竞猜<em id="sum">'+sumnums+'</em>注)</cite></p><p>今日可免费选择<cite id="num">'+todaynums+'</cite>注双色球，剩余<em class="red" id="remain">'+remainnums+'</em>注</p>')
					$("#jcjl").show();
					g.fg=1
				}else if(code=="1200"){//未登录
					$("#jcjl").hide();
					
				}else if(code=="1001"){//彩种不明确
					D.alert(desc);
				}else if(code=="1003"){//活动未开始
					D.alert(desc);
				}else if(code=="1004"){//活动已结束
					D.alert(desc);
				}else{
					D.alert(desc);
				}
				$("#peolenum").html(joinnum);
				
			},
			error:function(){
				D.alert("期次和投注类型不正确");
			}
		});
	}
	
	
	var g={
			gid:"01",
			pid:"",
			codes:"",
			atime:"",
			fg:0//0:未登录,1登录
	};
	
	
	/*请求期号接口[[*/
	var getQihao=function(){
		$.ajax({
			url:'/trade/info.go?gid=01',
			dataType:'xml',
			cache:true,
//				async:callback?false:true,
			success: function(xml) {
				var data = {},issueInfo = [],miss_ = {};
				var R = $(xml).find('rows');
				g.pid = data.pid = R.attr('pid');
				data.atime = R.attr('atime');//开奖时间
				data.tn = R.attr('tn');//购买状态
				data.now = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
				renderQihao(data);
				jcjlInfo();
				
				//callback(issueInfo);
			}
		});
		
	};
	/*]]请求期号接口*/
	
	/***
	var getQihao=function(){
		var qc=""
		$.ajax({
			url:'/trade/info.go?gid='+g.gid,
			dataType:'xml',
			cache:true,
			success: function(xml) {
				var rows = $(xml).find("rows");
				var pid = rows.attr("pid");
				g.pid=pid;
				var atime = rows.attr("atime");
				g.atime=atime;//开奖时间
			}
		})
		return qc;
	}
	***/
	
	var gobuy=function(){
		var codes = getCode();
		//var pid=getQihao();
		var data = {
				gid : g.gid,//彩种编号
				pid : g.pid,//期号
				codes : codes//投注号码
		};
		$.ajax({
			url:"/activity/joinFreeGuess.go",
			dataType:'xml',
			data: data,
			cache:true,
			success: function(xml) {
				
			},
		});
	};
	
	//获取code值
	var getCode = function(){
		var code="";
		var codesArr=[];
		$("#ball span:lt(6)").each(function(){
			//code+=$(this).text()+",";
			codesArr.push($(this).text());
		});
		code=codesArr.join(",");
		code=code+"|"+$("#ball span:last").text();
		return code;
	}
	
	var bindEvent=function(){
		
		//换一注机选
		$("#ball cite").bind("click",function(){
			setJx();
		});
		
		//免费参与竞猜
		$(".btn").bind("click",function(){
			var remainValue = parseInt($("#remain").text());//剩余次数
			var sumValue = parseInt($("#sum").text());
			var pid=g.pid;
			var codes = getCode()+":1:1";
			
			var data = {
					gid : g.gid,//彩种编号
					pid : pid,//期号
					codes : codes//投注号码
			};

			D.alert("双色球免费竞猜活动已暂停，敬请期待其它精彩活动")
			
			
		});
		
		//自己选号
		$("#zg").bind("click",function(){
			$.ajax({
				url:"/activity/userFreeGuessCon.go?gid=01",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code=="0"){//登录,如果登录了去“自己选号页面”
						alert()
						window.loaction.href=""
					}else if(code=="1200"){//未登录
						//如果未登录,此时需要用户去登录，登录的时候要判断是去IOS/安卓,5
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
					}
				},
			});
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
		
	};
	
	
	
	//判断用户是否登录
	
	var tokenLogin=function(){
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
			alert('加载中..','load');
			setTimeout(function(){
				allcookies = allcookies.split('&');
				var token = '',appid = '';
				$.each(allcookies,function(index, val){
					if(val.indexOf('TOKEN=')>=0){
						token = val.split('TOKEN=')[1];
					}
					if(val.indexOf('APPID=')>=0){
						appid = val.split('APPID=')[1];
					}
				});
				$.ajax({
					url:'/user/swaplogin.go',
					data:{
						logintype:'1',
						accesstoken:token,
						appid:appid
					},
					cache:false,
					type:'POST',
					success:function(xml){
						$.ajax({
							url:'/user/query.go?flag=6',
							type:'POST',
							dataType:'xml',
							success: function(xml) {
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								if(c == '0'){//已登录
									remove_alert();
									//jcjlInfo();
									getQihao();
								}else{//未登录
									$("#jcjl").hide();
								}
								//o.against();
							}
						});
					},
				  error: function(xml) {
                        D.alert(JSON.stringify(xml));
                       },
				});
			},.3e3);
		}else{
			//jcjlInfo();
			getQihao()
		}
	};
	
	
	return {
		init:init
	};
})();
$(function(){
	CP.ZLK.init();
})