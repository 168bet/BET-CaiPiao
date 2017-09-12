var XHC={};
var D={};
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		
		confirm_login:function(fn, tag1, tag2, fn1){
			tag1 && $('#popup a:eq(0)').html(tag1) || $('#popup a:eq(0)').html('取消');
			tag2 && $('#popup a:eq(1)').html(tag2) || $('#popup a:eq(1)').html('确定');
			$('.zhezhao, #popup').show();
			$('#popup a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				
				$('.zhezhao, #popup').hide();
			});
			$('#popup a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				
				$('.zhezhao, #popup').hide();
			});
		}
};
var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
//公用弹出层和加载层

var win_alert = alert;
window['alert'] = function (msg, loading) {
	if (!loading) {
		clearTimeout(window.alert.time);
		var obj = $('<div class="alertBox">' + msg + '</div>');
		$('body').append(obj);
		window.alert.time = setTimeout(function () {
			$(".alertBox").remove();
		}, 2000);
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

var CP={}
CP.MobileVer = (function ($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false,
		wp:false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	obj.wp = u.indexOf("Windows Phone") > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();
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


var d = new Date();
var y = d.getFullYear();
var m1 = d.getMonth()+1;
m1=m1<10?"0"+m1:m1;
var day =d.getDate();
day=day<10?"0"+day:day;
var P1 = y+""+m1+""+day;

XHC.ZLK=(function(){
	
	//比赛状态
	var st={
		    '0': '开赛',
		    '13': '第一节',
		    '14': '第二节',
		    '15': '第三节',
		    '16': '第四节',
		    '20': '进行中',
		    '30': '暂停',
		    '31': '第一节结束',
		    '32': '中场',
		    '33': '第三节结束',
		    '34': '加时',
		    '40': '加时',
		    '60': '延期',
		    '90': '弃赛',
		    '100': '已完赛',
		    '110': '已完赛'
		};
	
	var obData = {
			
	}
	
	var people_num=function(){
		$.ajax({
			url:'/nbajc/data/app/'+P1+'/tzcs.xml',
			dataType:'xml',
			cache:true,
	        success:function (xml){
	     	    var R = $(xml).find("Resp");
	 			var code = R.attr("code");
	 			if (code == "0") {//已登录
	 				var row = R.find("row");
	 				row.each(function(){
	 					var mid = $(this).attr("mid");
	 					var tzcs = $(this).attr("tzcs")?$(this).attr("tzcs"):"0";
	 					obData[mid]=tzcs;
	 				})
	 				loadCont();
	 			}else{
	 				loadCont();
	 			}
	        }
		});
	}
	var init=function(){
		/***
		var cb = $.Callbacks();
		cb.add(people_num)
		cb.add(loadCont)
		cb.add(bindEvent)
		cb.fire();
		***/
		people_num();
		//loadCont();
		bindEvent();
		if(from &&  (from=="android" || from=="ANDROID")){
			$("#back").hide();
			tokenLogin();
		}else if(from &&  (from=="wp" || from=="WP")){
			$("#back").hide();
			tokenLogin();
		}else if(from && (from=="IOS" || from=="ios")){
			if(appversion){
				//alert(appversion)
				if(appversion>325){
					tokenLogin();
				}else{
					$.ajax({
				        url: "/user/mchklogin.go",
				        type: "POST", 
				        success:function (data){
				     	    var R = $(data).find("Resp");
				 			var code = R.attr("code");
				 			if (code == "10001") {//已登录
				 				//bind_input();
				 			}else{
				 				D.confirm_login(function(){
				 					WebViewJavascriptBridge.callHandler('clickIosRegister');
				 				},'登录','注册',function(){
				 					WebViewJavascriptBridge.callHandler('clickIosLogin');
				 				});
				 			}
				        }
					});
				}
			}
		}else{
			$.ajax({
		        url: "/user/mchklogin.go",
		        type: "POST", 
		        success:function (data){
		     	    var R = $(data).find("Resp");
		 			var code = R.attr("code");
		 			if (code == "10001") {//已登录
		 				//bind_input();
		 			}else{
		 				D.confirm_login(function(){
		 					var url='register.html';
		 					//4g
		 				    window.location.href = url;
		 					
		 				},'登录','注册',function(){
		 					var url='login.html';
		 					window.location.href = url;
		 				});
		 			}
		        }
			});
		}
		
	};
	
	var bindEvent=function(){
		//右侧下拉框
		$('.pullIco').bind('click', function(){
			$('.pullDown').toggleClass('pullHover');
			$('.pullText').toggle();
		});
	}
	
	var toLogin = function(){
		D.confirm_login(function(){
			var url='register.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(4, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('clickIosRegister');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"22"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		},'登录','注册',function(){
			var url='login.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(3, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('clickIosLogin');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"21"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		});
	}

	

	var from = location.search.getParam("from");
	var appversion = location.search.getParam("appversion");
	appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
	
	//判断用户是否登录

	var tokenLogin=function(){
		
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
			//alert('加载中..','load');
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
									//loadCont();
								}else{//未登录
									//location.href='login.html';
									toLogin()
								}
								o.against();
							}
						});
					}
				});
			},.3e3);
		}else{
			toLogin();
		}
	};
	
	var loadCont = function(){
		var html=$("#cont").html();
		var e_num = obData["20142015002"]?parseInt(obData["20142015002"]):0;
		var w_num = obData["20142015001"]?parseInt(obData["20142015001"]):0;
		var z_num = obData["20142015000"]?parseInt(obData["20142015000"]):0;
		
		$("#gj p.mid span.pater").html((e_num+w_num+z_num)+"人已参与");
		$.ajax({
			url:"/nbajc/matchs/"+P1+"/allmatches.json?"+Math.random(),
			dataType:'JSON',
			cache:true,
			success:function(data){
				if(!data){
					$(".hmHeader").html(noGame);
					return;
				}
				$("#gj").hide();
				if(data.length){
					for(var i=0;i<data.length;i++){
						
						var gid = data[i]["gid"];
						var hid = data[i]["hid"];
						var gjs = data[i]["gjs"];
						var hjs = data[i]["hjs"];
						var gn = data[i]["gn"];
						var hn = data[i]["hn"];
						var gr = data[i]["gr"];//客队排名
						var hr = data[i]["hr"];//主队排名
						var id = data[i]["id"];//资料库id
						var mid = data[i]["mid"];//主站赛事id
						var gid = data[i]["gid"];
						var gsc = data[i]["gsc"];//客队比分
						var hsc = data[i]["hsc"];//主队比分
						var time = data[i]["time"];//主队比分
						var statusCode = data[i]["statusCode"];
						var isRank = data[i]["isRank"];
						
						var mtime = data[i]["mtime"];//开赛时间
						mtime = mtime.replace(/-/g,"/");
						var t = new Date(mtime);
						var d = t.getDate();
						var H = t.getHours();
						var M = t.getMinutes();
						var month = t.getMonth()+1
						month=month<10?"0"+month:month
						M=M<10?"0"+M:M
						var timeStr = month+"月"+d+"日"+" "+H+":"+M;
						
						
						
						html += '<a href="/gq/?'+id+'" class="'+(isRank==1?"cur":"")+'" id="'+id+'">'
						html += '<p><cite><img src="nbalogo/t_'+gid+'.png"></cite><strong>'+gn+'</strong></p>'
						html += '<p class="mid">';
						if(statusCode==0){
							html +=	'<span>'+timeStr+ st[statusCode]+'</span><b>'+"VS"+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>';
						}else{
							html +=	'<span>'+st[statusCode]+'  '+(statusCode!=0?time:mtime)+'</span><b>'+(statusCode!=0?gsc+':'+hsc:"VS")+'</b><span class="pater">'+(obData[mid]?obData[mid]:"0")+'人已参与</span>'
						}
						
						
						html += '</p>';
						html += '<p><cite><img src="nbalogo/t_'+hid+'.png"></cite><strong>'+hn+'</strong></p>'
						html += '</a>';
						
					}
					$("#cont").html(html);
					$("#gj_url").show();
					gain();
				}else{
					$("#cont").html(noGame);
				}
				
			},
			error:function(){
				alert("网络异常");
			}
		});
	}
	var pt=0
	var gain = function(){
		var html = "";
		//html += '<p class="mid"><span>第四节  05:32</span><b>85:74</b></p>'
			
			
		//及时调用头部(5s)
		_timeId=setInterval(function(){
			$.ajax({
				url:"/nbajc/matchs/change.xml?"+Math.random(),
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Rows");
					var row = R.find("row");
					if(row.length){
						row.each(function(){
							var t = {};
							t.id = $(this).attr('id');
							t.mid = $(this).attr('mid');
							t.statusCode = $(this).attr('code');
							t.hs = $(this).attr('hs');//当前节主队比分
				    		t.gs = $(this).attr('gs');
				    		t.hsc = $(this).attr('hsc');
				    		t.gsc = $(this).attr('gsc');
				    		t.time = $(this).attr('time');//倒计时器
				    		
				    		
				    		//html =	'<span>'+st[t.statusCode]+'  '+(t.statusCode!=0?t.time:"")+'</span><b>'+(t.statusCode!=0?t.gsc+':'+t.hsc:"VS")+'</b>'
				    		
				    		if(t.statusCode==0){
								html =	'<span>'+timeStr+ st[t.statusCode]+'</span><b>'+"VS"+'</b><span class="pater">'+(obData[t.mid]?obData[t.mid]:"0")+'人已参与</span>'
							}else{
								html =	'<span>'+st[t.statusCode]+'  '+(t.statusCode!=0?t.time:mtime)+'</span><b>'+(t.statusCode!=0?t.gsc+':'+t.hsc:"VS")+'</b><span class="pater">'+(obData[t.mid]?obData[t.mid]:"0")+'人已参与</span>'
							}
				    		
				    		$("#cont a[id='"+t.id+"'] p:eq(1)").html(html)
				    		/**
				    		if(t.statusCode==0||t.statusCode==60||t.statusCode==90||t.statusCode==100||t.statusCode==110){
				    			$("#cont a[id='"+t.id+"']").removeClass("cur")
				    		}else{
				    			$("#cont a[id='"+t.id+"']").addClass("cur")
				    		}
				    		***/
				    		/***
							if(t.statusCode==100){
								clearInterval(_timeId);//清楚定时器
							}else{
								
							}
							***/
						})
						
					}else{
						clearInterval(_timeId);//清楚定时器
					}
				}
			});
		},5000);
		return html;
	}
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})



