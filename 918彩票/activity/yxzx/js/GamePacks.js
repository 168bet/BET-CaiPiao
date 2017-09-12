var CP={};
// var API='http://192.168.2.165:8080';

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
CP.Checked = function(obj){
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
						// alert("LoginCheckCode "+c);
						var getNickid = R.find('row').attr('nickid');
						// var isBindMobile = R.find('row').attr('mobbind');
						//alert(isBindIdCard+"~~"+isBindMobile)
						if(c == '0'){
							sessionStorage.setItem("getNickid", getNickid); 
							CP.getgameCode(obj)
						}else{
							// alert("Checked "+c);
							CP.AppJiek.appLogin();
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
					// alert("LoginCheckCode "+c);
					var getNickid = R.find('row').attr('nickid');
					// var isBindMobile = R.find('row').attr('mobbind');
					//alert(isBindIdCard+"~~"+isBindMobile)
					if(c == '0'){
						sessionStorage.setItem("getNickid", getNickid); 
						CP.getgameCode(obj);
					}else{
						//alert("Checked "+c);
						CP.AppJiek.appLogin();
					}
				},error : function () {
					//remove_alert();
					alert('网络异常请刷新重试');
				}
			})
	}
}

CP.GetGamePackLis=function(username){
	$.ajax({
		url:'/activity/queryThirdGameGiftList.go',
		type:'post',
	    data: 'username=' + username,
	    dataType:'xml',
	    success:function(data){
			var R = $(data).find('Resp');
			var c = R.attr('code');
			var getList = R.find('row').attr('nickid');
			//var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				
			}else{

				//CP.AppJiek.appLogin();
			}
		},error : function () {
			//remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}
CP.CopyGmcode=function(obj){
	if($(obj).siblings("span").html()==null||$(obj).siblings("span").html()==''){
		var getThis=$(obj);
		var clipboard = new Clipboard(obj[0], {
        text: function(obj) {
        		//CP.Checked();
        		var getCdkey='';
        		if(getThis.siblings("span").eq(0).html()==null){
        			getCdkey=CP.getgameCode(obj);
        			return getCdkey;
        		}else{
        			getCdkey=getThis.siblings("span").eq(0).html();
        			return getCdkey;
        		}
            	// return getThis.siblings("span").eq(0).html()==''?:getThis.siblings("span").eq(0).html();
            	return getCdkey;
	        }
	    });
		clipboard.on('success', function(e) {
			if(getThis.siblings("span").eq(0).html()==null){
    			//CP.alertCopyOver('已复制到剪切板!')
    		}else{
    			 CP.alertCopyOver('已复制到剪切板!')
    		}
		    e.clearSelection();
		});
		clipboard.on('error', function(e) {
		    CP.alertCopyOver('请长按选中进行复制!<br/>'+getThis.siblings("span").eq(0).html())
		});
	}else{
		console.log(obj)
		var getThis=$(obj)
		var clipboard = new Clipboard(obj[0], {
        text: function(obj) {
            	return getThis.siblings("span").eq(0).html();
	        }
	    });
		clipboard.on('success', function(e) {
		    CP.alertCopyOver('已复制到剪切板!')
		    e.clearSelection();
		});
		clipboard.on('error', function(e) {
		    CP.alertCopyOver('请长按选中进行复制!<br/>'+getThis.siblings("span").eq(0).html())
		});
		// obj[0].one();
	}
}

CP.alertCopyOver=function(msg){
    $('body').append('<div class="alertBox">'+
            '<div class="box_loading">'+
                '<div class="loading_mask">'+
                    '<h1>温馨提示</h1><h3>'+msg+'</h3>'+
                    '<a href="javascript:;" class="Iknow" onclick=CP.remove_alert() >知道了</a>'+
                '</div>'+
            '</div> '+
        '</div><div class="mengban"></div>');
}
CP.remove_alert=function(){
    $(".alertBox").fadeOut("easing",function(){
        $(".alertBox").remove();
        $(".mengban").remove();
    });
    $(".mengban").fadeOut("easing",function(){
        $(".mengban").remove();
    });
}
/**
 * [getgameCode 获取对应的礼包码
 * @param  {[type]} obj [description]
 * @return {[type]}     [description]
 */
CP.getgameCode=function(obj){
	var getCdkey='';
	if(sessionStorage.getItem('getNickid')==null){
		CP.Checked(obj);
	}else if(sessionStorage.getItem('getNickid')!=null){
		$.ajax({
			url:'/activity/exchangeThirdGameCdkey.go',
			data:{
				'username':sessionStorage.getItem('getNickid'),
				'gameid':$(obj).attr('data-gameid'),
				'flag':$(obj).attr('data-flag')
			},
			type:'POST',
			success:function(xml){
				var R = $(xml).find('Resp');
				var c = R.attr('code');
				var getccdkey = R.find('row').attr('ccdkey');
				if(c == '0'){
					//重点测试
					$(obj).unbind('click')
					$(obj).after("<span>"+getccdkey+"</span>");
					$(obj).html("复制兑换码");
					CP.alertCopyOver('领取成功!')
					// 使其可复制
					getCdkey=getccdkey;
					
				}else{
					CP.alertCopyOver(R.attr('desc'))
					//alert("getgameCode "+c);
					//CP.AppJiek.appLogin();
				}
			},error : function (e) {
				//alert(JSON.stringify(e));
				//remove_alert();
				alert('网络异常请刷新重试');
			}
		})
		return getCdkey;
	}
	return getCdkey;
}

CP.pageContentGet=function(ios){
	if(sessionStorage.getItem('getNickid')==null){
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
					async:false,
					success:function(){
					$.ajax({
						url:'/user/getuserbasicinfo.go',
						type:'POST',
						dataType:'xml',
						success:function(xml){

							var R = $(xml).find('Resp');
							var c = R.attr('code');
							// alert("LoginCheckCode "+c);
							var getNickid = R.find('row').attr('nickid');
							// var isBindMobile = R.find('row').attr('mobbind');
							//alert(isBindIdCard+"~~"+isBindMobile)
							if(c == '0'){
								sessionStorage.setItem("getNickid", getNickid); 
								CP.getContent(ios);
							}else{
								CP.getContent(ios);
							}
						},error : function () {
							// alert(e)
							// alert(JSON.stringify(e));
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
					async:false,
					success:function(xml){
						var R = $(xml).find('Resp');
						var c = R.attr('code');
						// alert("LoginCheckCode "+c);
						var getNickid = R.find('row').attr('nickid');
						// var isBindMobile = R.find('row').attr('mobbind');
						//alert(isBindIdCard+"~~"+isBindMobile)
						if(c == '0'){
							sessionStorage.setItem("getNickid", getNickid); 
							CP.getContent(ios);
						}else{
							CP.getContent(ios);
						}
					},error : function (e) {
						// alert(e)
						// alert(JSON.stringify(e));
						//remove_alert();
						alert('网络异常请刷新重试');
					}
				})
		}
	}else{
		CP.getContent(ios);
	}
}
CP.getContent=function(ios){
	$.ajax({
		url:'/activity/queryThirdGameGiftList.go',
		data:{'username':sessionStorage.getItem('getNickid'),
				'gameid':''},
		type:'POST',
		dataType:'xml',
		success:function(xml){
			var R = $(xml).find('Resp');
			var c = R.attr('code');
			//var getNickid = R.find('row').attr('nickid');
			var getList=R.find('row');
			//var isBindMobile = R.find('row').attr('mobbind');
			if(c == '0'){
				console.log(xml);
				var list='';
				if(ios==''||ios==null){
					$(getList).each(function(i){
				        if($(this).attr('ccdkey')!=''){
				        	list+='<li>'+
					            '<div class="game_list-img">'+
					            	'<img src="'+$(this).attr('curl')+'" />'+
					            '</div>'+
					            '<div class="game_list-txt">'+
						            '<a href="javascript:;" data-packaCode='+$(this).attr('ccdkey')+' data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' class="package_detail">'+
						                '<h3>'+$(this).attr('cgifttype')+'</h3>'+
						                '<p>'+$(this).attr('cdescribe')+'</p>'+
						            '</a>'+
					            '</div>'+
					            '<div class="game_list-btn">'+
					                '<a class="getCode" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' href="javascript:;">复制兑换码</a>'+
					            	'<span>'+$(this).attr('ccdkey')+'</span>'+
					            '</div>'+
					        '</li>';
				        }else{
				        	list+='<li>'+
					            '<div class="game_list-img">'+
					            	'<img src="'+$(this).attr('curl')+'" />'+
					            '</div>'+
					            '<div class="game_list-txt">'+
						            '<a href="javascript:;" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' class="package_detail">'+
						                '<h3>'+$(this).attr('cgifttype')+'</h3>'+
						                '<p>'+$(this).attr('cdescribe')+'</p>'+
					            	'</a>'+
					            '</div>'+
					            '<div class="game_list-btn">'+
					                '<a class="getCode" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' href="javascript:;">立即领取</a>'+
					            '</div>'+
					        '</li>';
				        }
					})
				}else if(ios=='ios'){
					$(getList).each(function(i){
						if($(this).attr('cgameid')=='ls-h5-001'||$(this).attr('cgameid')=='ls-h5-002'||$(this).attr('cgameid')=='ls-h5-003'){
							if($(this).attr('ccdkey')!=''){
					        	list+='<li>'+
						            '<div class="game_list-img">'+
						            	'<img src="'+$(this).attr('curl')+'" />'+
						            '</div>'+
						            '<div class="game_list-txt">'+
							            '<a href="javascript:;" data-packaCode='+$(this).attr('ccdkey')+' data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' class="package_detail">'+
							                '<h3>'+$(this).attr('cgifttype')+'</h3>'+
							                '<p>'+$(this).attr('cdescribe')+'</p>'+
							            '</a>'+
						            '</div>'+
						            '<div class="game_list-btn">'+
						                '<a class="getCode" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' href="javascript:;">复制兑换码</a>'+
						            	'<span>'+$(this).attr('ccdkey')+'</span>'+
						            '</div>'+
						        '</li>';
					        }else{
					        	list+='<li>'+
						            '<div class="game_list-img">'+
						            	'<img src="'+$(this).attr('curl')+'" />'+
						            '</div>'+
						            '<div class="game_list-txt">'+
							            '<a href="javascript:;" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' class="package_detail">'+
							                '<h3>'+$(this).attr('cgifttype')+'</h3>'+
							                '<p>'+$(this).attr('cdescribe')+'</p>'+
						            	'</a>'+
						            '</div>'+
						            '<div class="game_list-btn">'+
						                '<a class="getCode" data-flag='+$(this).attr('cgifttype')+' data-gameid='+$(this).attr('cgameid')+' href="javascript:;">立即领取</a>'+
						            '</div>'+
						        '</li>';
					        }
						}
				        
					})
				}
				
				$('.game_list-li').html(list);
				//等待隐藏
				$(".loadpop").fadeOut(function(){
			        $('.index_cont').show();
			    })

				$.each($(".getCode"),function(i){
					CP.CopyGmcode($(this));
				})
			}else{
				// alert("pageContentGet "+c);
				// CP.AppJiek.appLogin();
				CP.alertCopyOver(R.attr('desc'))
				
			}
		},error:function (e) {
			// alert("getConte")
			// alert(e)
			// alert(JSON.stringify(e));
			//remove_alert();
			alert('网络异常请刷新重试');
		}
	})
}
//页面初始化的时候进行登录校验
$(document).ready(function(){
	if(!browser.versions.android){
		CP.pageContentGet('ios');
	}else{
		CP.pageContentGet();
	}
	// CP.getContent();
})

$("article.game_list").on('click',".package_detail",function(e){
	e.stopPropagation();
	var getGameid=$(this).attr('data-gameid');
	var getflag=$(this).attr('data-flag');
	var getPackcode=$(this).parent().siblings('.game_list-btn').find('span').html();
	var getCode=getPackcode!=null?getPackcode:'';

	switch (getGameid){
        case 'yz-client-001':
          window.location.href='packageDetail_sy1.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;
        case 'yz-client-002':
          window.location.href='packageDetail_sy2.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;
         case 'ls-h5-001':
          window.location.href='packageDetail_h5_01.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;
        case 'ls-h5-002':
          window.location.href='packageDetail_h5_02.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;
        case 'ls-h5-003':
          window.location.href='packageDetail_h5_03.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;
        case 'ls-h5-004':
          window.location.href='packageDetail_h5_04.html?gameid='+getGameid+'&&flag='+getflag+'&&packaCode='+getCode;
          break;    
        default:
          alert('未获取游戏Id，请刷新重试')
    }
})
