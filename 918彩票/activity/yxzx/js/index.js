
var CP={};
// var API='http://t209.gs.9188.com  /';
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
    },
    DownLoadApk:function(){
    	if(browser.versions.android){
    		//下载斗地主
			window.caiyiandroid.clickAndroid(12, 'http://mobile.9188.com  /app/android/market/doudizhu.apk');
		}
    }
}
CP.Checked = function(successfn,failurefn){
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
							successfn
						}else{
							failurefn
							//CP.AppJiek.appLogin();
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
					successfn
				}else{
					failurefn
					//CP.AppJiek.appLogin();
				}
			},error : function () {
				//remove_alert();
				alert('网络异常请刷新重试');
			}
		})
	}
}
CP.gotoMyGame=function(){
	if(sessionStorage.getItem("getNickid")!=null){
		window.location.href='mygame.html';
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
						logintype:'1',
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
								window.location.href='mygame.html';
							}else{
								// try{
									CP.AppJiek.appLogin();
								// }
								// catch(err){
								// 	alert(1)	
								// }
							}
						},error : function () {
							//remove_alert();
							alert('网络异常请刷新重试');
						}
					})
				},error:function(e){
					alert('网络异常请刷新重试');
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
						window.location.href='mygame.html';
					}else{
						CP.AppJiek.appLogin();
					}
				},error : function () {
					//remove_alert();
					alert('网络异常请刷新重试');
				}
			})
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
					logintype:'1',
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
						// alert(JSON.stringify(xml));
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
				//alert(JSON.stringify(xml));
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
				window.location.href=href;
			}
		},error : function (e) {
			// alert(JSON.stringify(e));
			//remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}

CP.TongJi=function(){
	var TongJi={
		'Banner位置':$(".banner_top"),
		'游戏礼包':$(".Game_pack"),
		'我的游戏':$(".My_game"),
		'游戏详情':$(".Game_detail"),
		'H5游戏进入':$(".Game_into"),
		'游戏-少年三国志-下载':$(".Game_down_snsgz"),
		'游戏-斗地主-下载':$(".Game_down_ddz")
	}
	$.each(TongJi,function(i,val){
		val.click(function(){
			ClickCont(i)
		})
	})
}


//游戏进入
$(".Game_into").click(function(e){
	e.stopPropagation();
	var getLoaction=$(this).attr('data-href');
	var getGameId=$(this).attr('data-gameid');
	CP.GameInto(getLoaction,getGameId)
})
//我的游戏
$('.My_game').click(function(e){
	e.stopPropagation();
	CP.gotoMyGame();
})
//游戏下载
$(".Game_down").click(function(e){
	e.stopPropagation();
	var getThis=$(this);
	if(browser.versions.android&&getThis.attr("data-name")=='ddz'){
		CP.AppJiek.DownLoadApk();
	}
	// else if(browser.versions.ios){
	// 	var geturl=getThis.attr('data-ios-href');
	// 	window.location.href=geturl;
	// }
})
//h5游戏详情
$('.Game_detail').click(function(e){
	e.stopPropagation();
	var gameid=$(this).attr('data-gameid')||'';
	switch (gameid){
        case 'ls-h5-001':
          window.location.href='gameDetail_0.html?gameid='+gameid;
        break;
        case 'ls-h5-002':
          window.location.href='gameDetail_1.html?gameid='+gameid;
          break;
        case 'ls-h5-003':
          window.location.href='gameDetail_2.html?gameid='+gameid;
          break;     
     	case 'ls-h5-004':
          window.location.href='gameDetail_3.html?gameid='+gameid;
          break;
    }
	// window.location.href='gameDetail_'+$(this).parent().parent().index()+'.html?gameid='+gameid;
})

//sy游戏详情
$('.Game_detail_sy').click(function(e){
	e.stopPropagation();
	var gameid=$(this).attr('data-gameid')||'';
	window.location.href='gameDown_'+$(this).parent().parent().index()+'.html?gameid='+gameid;
})

$(document).ready(function(){
	CP.TongJi();	
	if(browser.versions.android){
		var Banner='<div class="swiper-slide" class="banner_top">'+
                '<a href="gameDetail_0.html?gameid=ls-h5-001">'+
                    '<img src="img/index_banner03.jpg" />'+
                '</a>'+
            '</div>'+ 
            '<div class="swiper-slide" class="banner_top">'+
                '<a href="gameDetail_3.html?gameid=ls-h5-004">'+
                    '<img src="img/cqsj_banner.jpg" />'+
                '</a>'+
            '</div>'+
            '<div class="swiper-slide" class="banner_top">'+
                '<a href="gameDetail_2.html?gameid=ls-h5-003">'+
                    '<img src="img/lcby_banner.jpg" />'+
                '</a>'+
            '</div>'+
            '<div class="swiper-slide" class="banner_top">'+
                '<a href="gameDetail_1.html?gameid=yz-client-002">'+
                    '<img src="img/jzsc_banner.jpg" />'+
                '</a>'+
            '</div>'+
			'<div class="swiper-slide" >'+
                '<a href="gameDown_1.html?gameid=yz-client-002" class="banner_top">'+
                    '<img src="img/index_banner01.jpg" />'+
                '</a>'+
            '</div>'+
            '<div class="swiper-slide" class="banner_top">'+
                '<a href="gameDown_0.html?gameid=yz-client-001">'+
                    '<img src="img/index_banner02.jpg" />'+
                '</a>'+
            '</div>'
            
        $(".swiper-wrapper").html(Banner);
		$(".sy_game_list").show();
	}else{
        // var mySwiper = new Swiper ('.swiper-container', {
								//     direction: 'horizontal',
								//     loop: true,
								//     autoplay:3000,
								//     // 如果需要分页器
								//     pagination: '.swiper-pagination'
								    
								//     // 如果需要前进后退按钮
								//   })  
	}
})
