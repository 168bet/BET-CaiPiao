var PersonData={};
var RedPacket={};
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
    RedPacket.AppJiek = {
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
            //调用充值 默认20充值金额
            if(browser.versions.android){
                window.caiyiandroid.callback_02(20);
            }
            if(browser.versions.ios){
                WebViewJavascriptBridge.callHandler('callback_02','20');
            }
        },
        DownLoadApk:function(){
            if(browser.versions.android){
                // 调用外部下载
                window.caiyiandroid.clickAndroid(12, '');
            }
        }
    }
    RedPacket.Checked = function(){
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
                                PersonData.userNickid=getNickid;
                                PersonData.checkLogin=true;
                                sessionStorage.setItem("PersonData",JSON.stringify(PersonData)); 
                                // successfn
                            }else{
                                PersonData.checkLogin=false;

                                sessionStorage.setItem("PersonData",JSON.stringify(PersonData)); 
                                CP.AppJiek.appLogin();
                            }
                        },error : function () {
                            // alert('网络异常请刷新重试');
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
                    if(c == '0'){
                        PersonData.userNickid=getNickid;
                        PersonData.checkLogin=true;
                        sessionStorage.setItem("PersonData",JSON.stringify(PersonData)); 
                    }else{
                        PersonData.checkLogin=false;
                        sessionStorage.setItem("PersonData",JSON.stringify(PersonData)); 
                        RedPacket.AppJiek.appLogin();
                    }
                },error : function () {
                    //remove_alert();
                    // alert('网络异常请刷新重试');
                }
            })
        }
    }
    //获取已领取 滚动的数据 实现滚动
    RedPacket.Iscroll=function(){
        var box=document.getElementById("iscroll"),can=true;
        var h=box.clientHeight;
        
        box.innerHTML+=box.innerHTML;
        box.onmouseover=function(){can=false};
        box.onmouseout=function(){can=true};
        new function (){
            var stop=box.scrollTop%h==0&&!can;
            if(!stop)box.scrollTop==parseInt(box.scrollHeight/2)?box.scrollTop=0:box.scrollTop++;
            setTimeout(arguments.callee,box.scrollTop%h?10:1500);
        };
        //
    }
    RedPacket.ActionRule=function(){
        var rulesBox=document.getElementById("rules_box");
        var popBox=document.getElementById("pop_box");
        var closeBox=document.getElementById("close_box");
        function Stop(e) {
                e.preventDefault();
                // $(window).scrollTop('0')
            }
        rulesBox.addEventListener('touchend',function(){
            popBox.style.display="block";
            var pop=document.getElementById("pop_info");
            var h1=pop.offsetHeight;
            pop.style.marginTop=-(h1/2)+"px";
            document.getElementsByTagName("body")[0].setAttribute("style","height:100%;position:fixed;overflow:hidden;overflow-y:hidden;")
            document.getElementsByTagName('body')[0].addEventListener('touchmove', Stop(e), false)

        })
        
        closeBox.addEventListener('touchend',function(){
            popBox.style.display="none";
            document.getElementsByTagName("body")[0].setAttribute("style","height:auto;overflow:auto;")
            document.getElementsByTagName('body')[0].removeEventListener('touchmove',Stop(e), false)

        })
    }
    RedPacket.GetIscrolldata=function(){
       $.ajax({
            url:'/activity/queryRollCode.go',
            type:'POST',
            dataType:'xml',
            success:function(xml){
                var R = $(xml).find('Resp');
                var c = R.attr('code');
                var getList = R.find('row')
                
                if(c == '0'){
                    var list = '';
                    $(getList).each(function(i){
                        list+='<p>用户：'+$(this).attr('cnickid')+'领取了88元礼包</p>';
                    })

                    $("#iscroll div").html(list);
                    $('#iscroll').height(document.getElementById("iscroll").clientHeight+'px');
                    $('#iscroll div p').height(document.getElementById("iscroll").clientHeight+'px');
                    RedPacket.Iscroll();
                }else{
                  
                }
            },error:function () {
                //remove_alert();
                alert('获取已领信息异常请刷新重试');
            }
        })
    }
    RedPacket.PageStatus=function(status){
        //页面状态
        switch (status){
            case 'noLogin':
                $("#iscroll").show().siblings().hide();
                $(".btn_Nromal").show().siblings('a').hide();
                RedPacket.BtnNromalAdNoLogin('noLogin')
                RedPacket.GetIscrolldata();
            break;
            case 'normal':
                //正常情况
                $("#iscroll").show().siblings().hide();
                $(".btn_Nromal").show().siblings('a').hide();
                RedPacket.BtnNromalAdNoLogin('normal')
                RedPacket.GetIscrolldata()
            break;
            case 'deficiency':
                //充值金额不足
                $('.deficiency').show().siblings().hide();
                $('.btn_deficiency').show().siblings('a').hide();
                RedPacket.BtnDeficiency();         
            break;
            case 'haveGet':
                //已经领取
                $('.haveGet').show().siblings().hide();
                $('.btn_haveGet').show().siblings('a').hide();
                
            break;
            case 'unconformity':
                //不符合领取条件
                $('.unconformity').show().siblings().hide();
                $('.btn_unconformity').show().siblings('a').hide();
                
            break;
            case 'unbindPhone':
                RedPacket.GetIscrolldata();
                $(".btn_Nromal").click(function(e){
                    e.stopPropagation();
                    RedPacket.alertCopyOver("参加活动前，请先去「我的」-「账户安全」绑定手机号。",'')
                   
                    // window.location.href='./bindUserIfm.html';
                })
            break;
            case 'bindUserID':
                RedPacket.GetIscrolldata();
                $(".btn_Nromal").click(function(e){
                    e.stopPropagation();
                    RedPacket.alertCopyOver('参与新人充20得88活动前，需先绑定身份信息','AppBindeIDcard')
                })
            break;
            default:
             break;
        }
    }
    RedPacket.BtnNromalAdNoLogin=function(status){
       $(".btn_Nromal").click(function(e){
            e.stopPropagation();
            if(status=='noLogin'){
                try
                    {
                       RedPacket.AppJiek.appLogin();
                    }
                catch(err)
                    {
                       alert('未登录，且不在App环境')
                    }
            }else if(status=='normal'){
                RedPacket.AppJiek.ChargeMoney();
            }
        })
        
    }
    RedPacket.BtnDeficiency=function(){
        $(".btn_deficiency").click(function(e){
            e.stopPropagation();
            //身份证
            RedPacket.AppJiek.ChargeMoney(); 
        })
    }
    //弹出框效果
    // RedPacket.alertCopyOver=function(msg,href){
    // $('body').append('<div class="alertBox">'+
    //         '<div class="box_loading">'+
    //             '<div class="loading_mask">'+
    //                 '<h3>'+msg+'</h3>'+
    //                 '<a href="javascript:;" class="Iknow" onclick=RedPacket.remove_alert('+href+') >知道了</a>'+
    //             '</div>'+
    //         '</div> '+
    //     '</div><div class="mengban"></div>');
    // }
    // RedPacket.remove_alert=function(href){
    //     $(".alertBox").fadeOut("easing",function(){
    //         $(".alertBox").remove();
    //         $(".mengban").remove();
    //     });
    //     $(".mengban").fadeOut("easing",function(){
    //         $(".mengban").remove();
    //         window.location=href;
    //     });
    // }
    function StopScroll(e) {
        e.preventDefault();
        // $(window).scrollTop('0')
    }
    RedPacket.alertCopyOver=function(msg,fun){
    $('body').append('<div class="mask"></div>'+
                        '<div class="pop">'+
                            '<div class="Alert_pop_body">'+
                                '<p>'+
                                    msg+
                                '</p>'+
                            '</div>'+
                            '<div class="pop_btn">'+
                                '<a href="javascript:;" onclick=RedPacket.remove_alert("'+fun+'")>知道了</a>'+
                            '</div>'+
                        '</div>');
        document.getElementsByTagName("body")[0].setAttribute("style","height:100%;position:fixed;overflow:hidden;overflow-y:hidden;")
        document.getElementsByTagName('body')[0].addEventListener('touchmove', StopScroll(e), false)
    }


    RedPacket.remove_alert=function(fun){
        $(".mask").fadeOut("easing",function(){
            $(".mask").remove();
        });
        $(".pop").fadeOut("easing",function(){
            $(".pop").remove();
            // window.history.replaceState('','','./index.html');
            // window.location=href;
            switch (fun){
                case "AppBindeIDcard":
                    RedPacket.AppJiek.cardBind();
                break;
                default:
                break;
            }
        });
        document.getElementsByTagName("body")[0].setAttribute("style","height:auto;overflow:auto;")
        document.getElementsByTagName('body')[0].removeEventListener('touchmove',StopScroll(e), false)
    }
    //获取用户信息状态 
    RedPacket.GetState=function(){
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
                    RedPacket.GetNowState();    
                }
            })},300);
        }else{
            RedPacket.GetNowState();
        }     
    }
    RedPacket.GetNowState=function(){
        $.ajax({
            url : "/activity/getEightyRedPacketCheck.go",
            type : "POST",
            dataType : "xml",
            success : function(xml) {
                var R = $(xml).find("Resp");
                var code = R.attr("code");
                var desc = R.attr('desc');
                // alert(code)
                switch(code){
                    case '0':
                        console.log('成功领取 ')
                        RedPacket.PageStatus('haveGet');
                    break;
                    case '1001':
                        console.log('非新用户')
                        RedPacket.PageStatus('unconformity');       
                    break;
                    case '1002':
                        console.log('未绑定手机号')
                        // sessionStorage.setItem('UserType',1002)
                        RedPacket.PageStatus('unbindPhone');
                    break;
                    case '1003':
                        console.log('未绑定身份证')
                        // sessionStorage.setItem('UserType',1003)
                        RedPacket.PageStatus('bindUserID');
                    break;
                    case '1004':
                        console.log('手机或身份证检测不是新用户')
                        RedPacket.PageStatus('unconformity');  
                    break;
                    case '1005':
                        console.log('有充值，金额小于20')
                        RedPacket.PageStatus('deficiency');
                    break;
                    case '1006':
                        console.log('未充值或者充值未到账');
                        RedPacket.PageStatus('normal');
                    break;
                    case '1007':
                        console.log('非新用户')
                        RedPacket.PageStatus('unconformity');  
                    break;
                    case '1':
                        console.log('用户未登录');
                        RedPacket.PageStatus('noLogin');
                    break;
                    case '9999':
                        console.log('系统异常')
                    break;
                }
            },error:function(){
              
            }
        });
    }
$(document).ready(function(){
    RedPacket.ActionRule();
    RedPacket.GetState();
})