/*function getParam(name)
{
     var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
     var r = window.location.search.substr(1).match(reg);
     if(r!=null)return  unescape(r[2]); return null;
}*/

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
var showDownload=function(){
    if(!$("#downloadDiv").length){	
    	var ua = navigator.userAgent;
        var _d = document;
        var _b = _d.body;
        
        var downloadDiv = _d.createElement("div");
        downloadDiv.setAttribute("id","downloadDiv");
        _b.appendChild(downloadDiv);
        
        $(downloadDiv).addClass("download_android");
        
       if(ua.indexOf('Android') > -1 || ua.indexOf('Linux') > -1){ //android
    	   $(downloadDiv).addClass("download_android");
        } else if(ua.indexOf('iPhone') > -1 || ua.indexOf('iPad') > -1 || ua.indexOf('iPod') > -1){ // ios
        	 $(downloadDiv).addClass("download_iphone");
        }
        
    }
    $("#downloadDiv").fadeIn(function(){
        $(this).bind("click touchstart",function(){
            $(this).fadeOut();
        });
    });
}

var appRet = function(scheme,pageid,extend){
	var config = {
            scheme_IOS: 'caiyi9188Lotterynomal',
            scheme_Adr: 'lotterystartapp',
            download_url: 'http://t.9188.com',
            timeout: 1000
        };
	var now = Date.now();
    var ifr = $('.head_btn');
    var typefrom = location.search.getParam("type_from");
    if(browser.versions.android && typefrom == 'android'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios && typefrom == 'ios'){
    	ifr.attr('href',scheme+'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'android' && browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(typefrom == 'ios' && browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.android){
    	ifr.attr('href',config.scheme_Adr +'://shareProject?pageid='+pageid+'&extend='+extend)
    }else if(browser.versions.ios){
    	ifr.attr('href',config.scheme_IOS +'://shareProject?pageid='+pageid+'&extend='+extend)
    }
    var t = setTimeout(function() {
        var endTime = Date.now();
        if (Date.now() - now < config.timeout+800){
        		window.location.href= config.download_url; 
        }
    }, config.timeout);
}

$('.jcds_head_back').click(function(){
	history.go(-1)
})

//	下载头部
		if(!(location.search.getParam("source"))){
		$('#heah_h').addClass('height_h');
		$('.head_load').show();
	}
	$('.head_close').bind('click' ,function(){
		$('#heah_h').removeClass('height_h');
		$('.head_load').hide();
		$('.jcds_head').css({'top':0})
	})
	$('.head_btn').bind('click' , function(){
		try{
			var page = location.search.getParam("page");
			if(navigator.userAgent.toLowerCase().indexOf("micromessenger") != -1 ){//微信
    			showDownload();
            }else{
            	appRet(page,34,hid);
            }
		}catch(e){}
	})

var goBack = function(data){
	if(data.fflag){
		if(data.name){
			if(data.page && data.type){
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+lo.getParam("page")+'&type_from='+data.type+"&agentFrom="+data.agentFrom+'&shareUserId='+data.name+'&fflag='+data.fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+lo.getParam("page")+'&type_from='+data.type+'&shareUserId='+data.name+'&fflag='+data.fflag;
				}
			}else{
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+data.ftype+"&agentFrom="+agentFrom+'&shareUserId='+locname+'&fflag='+fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+data.ftype+'&shareUserId='+locname+'&fflag='+fflag;
				}
			}
		}else{
			if(data.page && data.type){
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+data.page+'&type_from='+data.type+"&agentFrom="+data.agentFrom+'&fflag='+data.fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+data.page+'&type_from='+data.type+'&fflag='+data.fflag;
				}
			}else{
				if(agentFrom){
					location.href="/sdjc/buy.html?hid="+data.ftype+"&agentFrom="+agentFrom+'&fflag='+fflag;
				}else{
					location.href="/sdjc/buy.html?hid="+data.ftype+'&fflag='+fflag;
				}
			}
		}
	}else if(data.page && data.type){
			if(agentFrom){
				location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+data.page+'&type_from='+data.type+"&agentFrom="+data.agentFrom
			}else{
				location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+data.page+'&type_from='+data.type
			}
	}else{
		if(data.page && data.type){
			if(agentFrom){
				location.href="/sdjc/buy.html?hid="+data.ftype+"&agentFrom="+agentFrom+'&page='+data.page+'&type_from='+data.type;
			}else{
				location.href="/sdjc/buy.html?hid="+data.ftype+'&page='+data.page+'&type_from='+data.type;
			}
		}else{
			if(agentFrom){
				location.href="/sdjc/buy.html?hid="+data.ftype+"&agentFrom="+data.agentFrom
			}else{
				location.href="/sdjc/buy.html?hid="+data.ftype
			}
		}
	}
}