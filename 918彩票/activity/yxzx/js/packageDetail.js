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

CP.Checked = function(){
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
//      alert(token+" "+appid);
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
                            
                        }else{
                            // alert('getUserNickid_code_'+c) 
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
                var getNickid = R.find('row').attr('nickid');
                var isBindMobile = R.find('row').attr('mobbind');
                //alert(isBindIdCard+"~~"+isBindMobile)
                if(c == '0'){
                    sessionStorage.setItem("getNickid", getNickid);   
                }else{  
                    // alert('getUserNickid_code_'+c) 
                    CP.AppJiek.appLogin();
                }
            },error : function () {
                //remove_alert();
                alert('网络异常请刷新重试');
            }
        })
    }
}
CP.getUerscod=function(){
    if(CP.GetQueryString("packaCode")!=null&&CP.GetQueryString("packaCode")!=''){
        var code=CP.GetQueryString("packaCode");
        $(".getCode").parent().html('<a class="getCode">复制</a><span>'+code+'</span>')
        CP.CopyGmcode($(".getCode"))
    }else{
        CP.CopyGmcode($(".getCode"))
    }
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
            // alert('请选择“拷贝”进行复制!')
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

CP.getgameCode=function(obj){
    var getCdkey='';
    if(sessionStorage.getItem('getNickid')==null){
        CP.Checked(obj)
        // CP.AppJiek.appLogin();
    }else if(sessionStorage.getItem('getNickid')!=null){
        $.ajax({
            url:'/activity/exchangeThirdGameCdkey.go',
            data:{
                'username':sessionStorage.getItem('getNickid'),
                'gameid':CP.GetQueryString('gameid'),
                'flag':CP.GetQueryString('flag')
            },
            type:'POST',
            success:function(xml){
                var R = $(xml).find('Resp');
                var c = R.attr('code');
                var getNickid = R.find('row').attr('nickid');
                var getccdkey = R.find('row').attr('ccdkey');
                //var isBindMobile = R.find('row').attr('mobbind');
                if(c == '0'){
                    //重点测试
                    $(obj).unbind('click')
                    $(obj).after("<span>"+getccdkey+"</span>");
                    $(obj).html("复制兑换码");
                    CP.alertCopyOver('领取成功!')
                    CopyGmcode(obj);  
                }else{
                    CP.alertCopyOver(R.attr('desc'))
                    // CP.AppJiek.appLogin();
                }
            },error : function () {
                //remove_alert();
                alert('网络异常请刷新重试');
            }
        })
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
CP.GetQueryString=function(name) {  
       var url = window.location.search; //获取url中"?"符后的字串
       var theRequest = new Object();   
       if (url.indexOf("?") != -1) {   
          var str = url.substr(1);   
          strs = str.split("&");   
          for(var i = 0; i < strs.length; i ++) {   
              //就是这句的问题
             theRequest[strs[i].split("=")[0]]=decodeURI(strs[i].split("=")[1]); 
             //之前用了unescape()
             //才会出现乱码
          }   
       }   
       return theRequest[name];   
}

$(document).ready(function(){
    CP.getUerscod()
})