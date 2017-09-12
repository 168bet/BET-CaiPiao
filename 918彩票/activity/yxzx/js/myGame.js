var CP={};
/**
 * @description 获取手机系统
 * @return {object}
 * @example browser.versions.android;
 * @memberOf CP
 */
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
}

/**
 * [AppJiek description]App接口调用
 * @type {Object}
 */
CP.AppJiek = {
    appLogin:function(){//原生登录接口
    	if(browser.versions.android){//登录调用原生接口
			window.caiyiandroid.clickAndroid(3, '');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('clickIosLogin');
		}
    },
    moBind:function(){
    	if(browser.versions.android){//绑定手机号调用原生接口
			window.caiyiandroid.clickAndroid(5,'');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','1');
		}
    },
    cardBind:function(){
    	if(browser.versions.android){//绑定身份证调用原生接口
			window.caiyiandroid.clickAndroid(6,'');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','2');
		}
    },
    ChargeMoney:function(){
    	if(browser.versions.android){
			window.caiyiandroid.clickAndroid(7, '');
		}
		if(browser.versions.ios){
			WebViewJavascriptBridge.callHandler('callBackIOS','3');
		}
    }
}
CP.GameInto=function(href,gameid){
	if(sessionStorage.getItem("getNickid")!=null){
		CP.HavePlayGm(href,gameid);
	}else{
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
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
	//		alert(token+" "+appid);
			setTimeout(function(){
				$.ajax({
					url:'/user/swaplogin.go',
					data:{
						logintype:'2',
						accesstoken:token,
						appid:appid
					}, 
					type:'POST',
					success:function(){
					$.ajax({
						url:'/user/getuserbasicinfo.go',
						type:'POST',
						dataType:'xml',
						success:function(xml){
							var R = $(xml).find('Resp');
							var c = R.attr('code');
							var getNickid = R.find('row').attr('nickid');
							var isBindMobile = R.find('row').attr('mobbind');
							//alert(isBindIdCard+"~~"+isBindMobile)
							if(c == '0'){
								sessionStorage.setItem("getNickid", getNickid); 
								CP.HavePlayGm(href,gameid);
							}else{
								window.location.href=href;
							}
						},error : function () {
							//remove_alert();
							alert('网络异常请刷新重试');
						}
					})
				}
			})
		},300);
		}else{
			$.ajax({
				url:'/user/getuserbasicinfo.go',
				type:'POST',
				dataType:'xml',
				success:function(xml){
					var R = $(xml).find('Resp');
					var c = R.attr('code');
					var getNickid = R.find('row').attr('nickid');
					var isBindMobile = R.find('row').attr('mobbind');
					//alert(isBindIdCard+"~~"+isBindMobile)
					if(c == '0'){
						sessionStorage.setItem("getNickid", getNickid); 
						CP.HavePlayGm(href,gameid);
					}else{
						window.location.href=href;
					}
				},error : function () {
					//remove_alert();
					alert('网络异常请刷新重试');
				}
			})
		}
	}
}
CP.HavePlayGm=function(href,gameid){
	$.ajax({
		url:'/activity/recordLoginGame.go',
		type:'POST',
		data:{
			'username':sessionStorage.getItem('getNickid'),
			'gameid':gameid
		},
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			var getNickid = R.find('row').attr('nickid');
			//var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				window.location.href=href;
			}else{
				CP.AppJiek.appLogin();
			}
		},error : function () {
			//remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}
CP.getGameLi=function(){
	if (sessionStorage.getItem('getNickid')!=null) {
		$.ajax({
			url:'/activity/queryHistoryGames.go',
			type:'POST',
			data:{'username':sessionStorage.getItem('getNickid')},
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var getNickid = R.find('row').attr('nickid');
				var getList=R.find('row');

				//var isBindMobile = R.find('row').attr('mobbind');
				if(c == '0'){
					var list='';
					$(getList).each(function(i){
						if($(this).attr('cgameid')!='ls-h5-001'){
							list+='<li>'+
					            '<div class="game_list-img">'+
					            	'<img src="'+$(this).attr('curl')+'" />'+
					            '</div>'+
					            '<div class="game_list-txt">'+
					            	'<a class="gameDetail" href="javascript:;" data-gameid='+$(this).attr('cgameid')+'>'+
						                '<h3>'+$(this).attr('cgamename')+'</h3>'+
						                '<p>'+$(this).attr('cdescribe')+'</p>'+
					            	'</a>'+
					            '</div>'+
					            '<div class="game_list-btn">'+
					                '<a class="gameInto" data-href='+$(this).attr('cthridurl')+' data-gameid='+$(this).attr('cgameid')+' href="javascript:;">进入</a>'+
					            '</div>'+
					        '</li>';
						}else{
							list+='<li>'+
					            '<div class="game_list-img">'+
					            	'<img src="'+$(this).attr('curl')+'" />'+
					            '</div>'+
					            '<div class="game_list-txt">'+
					            	'<a class="gameDetail" href="javascript:;" data-gameid='+$(this).attr('cgameid')+'>'+
						                '<h3>'+$(this).attr('cgamename')+'</h3>'+
						                '<p>'+$(this).attr('cdescribe')+'</p>'+
					            	'</a>'+
					            '</div>'+
					            '<div class="game_list-btn">'+
					                '<a class="gameInto" data-href="http://game.cc52.com/sdk.php/Game/game/?appid=100005&agent=0&channel=147" data-gameid='+$(this).attr('cgameid')+' href="javascript:;">进入</a>'+
					            '</div>'+
					        '</li>';
						}
						 
					})
					$('.game_list_cont').html(list);
					CP.TongJi();
					console.log(xml);
				}else{
					CP.AppJiek.appLogin();
				}
			},error : function (e) {
				alert(JSON.stringify(e))
				//remove_alert();
				alert('网络异常请刷新重试');
			}
		})
	}else{
		CP.AppJiek.appLogin();
	}
}
CP.TongJi=function(){
	var TongJi={
		'gameInto':$(".gameInto")
	}
	$.each(TongJi,function(i,val){
		val.click(function(){
			ClickCont(i)
		})
	})
}

//游戏进入
$(".game_list_cont").on('click','.gameInto',function(e){
	e.stopPropagation();
	var getLoaction=$(this).attr('data-href');
	var getGameId=$(this).attr('data-gameid');
	CP.GameInto(getLoaction,getGameId);
})
//游戏详情
$('.game_list_cont').on('click','.gameDetail',function(e){
	e.stopPropagation();
	var gameid=$(this).attr('data-gameid');
	switch (gameid){
        case 'yz-client-001':
          window.location='gameDown_0.html?gameid='+gameid;
          break;
        case 'yz-client-002':
          window.location='gameDown_1.html?gameid='+gameid;
          break;
        case 'ls-h5-001':
          window.location='gameDetail_0.html?gameid='+gameid;
          break;
        case 'ls-h5-002':
          window.location='gameDetail_1.html?gameid='+gameid;
          break;
        case 'ls-h5-003':
          window.location='gameDetail_2.html?gameid='+gameid;
          break;
        case 'ls-h5-004':
          window.location='gameDetail_3.html?gameid='+gameid;
          break;       
        default:
          alert('未获取游戏Id，请刷新重试')
    }
    // alert(window.location)
	// window.location.href='gameDetail.html?gameid='+gameid;
})

$(document).ready(function(){ 
　　CP.getGameLi();
}); 