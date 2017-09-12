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

define(function (){
	var phone = location.search.getParam("phone");
	var id = location.search.getParam("id");
	
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
	
	//发送验证码
	var render = function(){
		$.ajax({
			url:"/activity/registerActivityCheck.go?id="+id,
			datatype:"XML",
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){//符合条件
					$("#descrp").removeClass("darkred")
				
					$("#descrp").html('购彩红包已发至账户<br/><span>'+phone+'</span>');
					$("#imgLogo").attr("src","img/state1.png");
					
					//window.location.href = 'index.html?id='+id+"&comeFrom="+comeFrom;
				}else if(code==1){//没有该类活动
					$("#descrp").html('没有该类活动');
					$("#imgLogo").attr("src","img/state1.png");
				}else if(code==2){//活动还未开始
					$("#descrp").html('活动还未开始');
					$("#imgLogo").attr("src","img/state1.png");
				}else if(code==3){//该活动已截止
					$("#descrp").html('该活动已截止');
					$("#imgLogo").attr("src","img/state3.png");
				}else if(code==4){//晚来一步，红包已经被抢完
					$("#descrp").html('晚来一步，红包已被抢完');
					$("#imgLogo").attr("src","img/state2.png");
				}
				//$("#descrp").html(desc);
			}
		})
	};
	
	var browser={
		    versions:function(){
		        var u = navigator.userAgent, app = navigator.appVersion;
		        return {
		        	trident: u.indexOf('Trident') > -1, //IE内核
		            presto: u.indexOf('Presto') > -1, //opera内核
		            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
		            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1,//火狐内核
		            mobile: !!u.match(/AppleWebKit.*Mobile.*/), //是否为移动终端
		            ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
		            android: u.indexOf('Android') > -1 || u.indexOf('Adr') > -1 || u.indexOf('Linux') > -1, //android终端
		        };
		    }(),
	};
	
	var appRet = function(){
		var config = {
				 /*scheme:必须*/
	            scheme_IOS: 'caiyi9188Lotterynomal',
	            scheme_Adr: 'lotterystartapp',
	            download_url: 'http://t.9188.com  /',
	            timeout: 1000
	        };
		var now = Date.now();
	    var ifr = $('.mflhb_btn');
	    //var typefrom = location.search.getParam("type_from");
//	    alert(typefrom +' '+ browser.versions.ios + " "+(location.search.getParam("page")));
	    if(browser.versions.android){
	    	ifr.attr('href',config.scheme_Adr+'://shareProject')
	    }else if(browser.versions.ios){
	    	ifr.attr('href',config.scheme_IOS +'://shareProject')
	    }
	    var t = setTimeout(function() {
	        var endTime = Date.now();
	        if (Date.now() - now < config.timeout+800){
	        		window.location.href= config.download_url; 
	        }
	    }, config.timeout);
	}
	
	var bindEvent = function(){
		$("#openUrl").bind("click",function(){
			appRet();
		})
	}
	
	var init = function(){
		bindEvent();
		render();
		};
　　　
	return {
       init:init
　　　};
　　});