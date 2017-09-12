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
	var g={
			phone:"",
			time:60,
			yzm:""
	}
	
	var id=location.search.getParam("id");
	var comeFrom = location.search.getParam("comeFrom")||"";
	var D = {
			/*
			 * @param msg 弹窗内容
			 * @param fn 回调方法
			 * @param tag 需要改版按钮的文字
			 */
			confirm:function(msg,fn,c){
				$('#setCont').html(msg);
				$('.mflhb_mask').show();
				$("#setC").show();
				$('body').addClass('noscroll')
				$('#btn').click(function(){
					if(typeof(fn) == "function"){fn();}
					$('#setC').hide();
					$(".mflhb_mask").hide();
					$('body').removeClass('noscroll')
				});
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
	var timeout;
	//倒计时
	var count=function(t){
		if (t == 0) {
			$('#hyzm').html('重新发送');
			$('#hyzm').addClass('hqyzmcur');
        } else {
        	$(this).removeClass('hqyzmcur')
        	$('#hyzm').html(t--);
        	timeout=setTimeout(function () {
                count(t);
            }, 1000);
        }
	}
	
	//验证手机有效性
	var isPhoneOk = function (tel){
		var reg = 	/^((13[0-9])|(15[^4,\\d])|(18[0-9])|(14[0-9])|(17[0-9]))\d{8}$/;
		if(reg.test(tel)){
			return true;
		}
		return false;
	};
	
	//发送验证码
	var sendYZM = function(number){
		var data={
				mobileNo:number,
				newValue:"0",
				flag:"2",
		}
		$.ajax({
			url:"/user/sendSms.go",
			datatype:"XML",
			data:data,
			success:function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){//符合条件
					g.phone=number
					$("#bPhone").html(number)
					$("#firstStep").hide();
					$("#secondStep").show();
					window.clearTimeout(timeout)
					count(g.time);//进入下个页面倒计时开始
				}else{
					alert(desc)
				}
			}
		})
	}
	
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
					/**
					$("#descrp").html('20元购彩红包已发至账户<br/><span>'+phone+'</span>');
					$("#imgLogo").attr("src","img/state1.png");
					***/
					//window.location.href = 'index.html?id='+id+"&comeFrom="+comeFrom;
					$("#hdChk").hide();
					$("#hdPro").show();
					
					$("#firstStep").show();
					$("#secondStep").hide();
					$("#thirdStep").hide();
					
				}else if(code==3){//该活动已截止
					$("#hdChk").show();
					$("#hdPro").hidee();
					$("#descrp").html('该活动已截止');
					$("#imgLogo").attr("src","img/state3.png");
				}else if(code==4){//晚来一步，红包已经被抢完
					$("#hdChk").show();
					$("#hdPro").hide();
					$("#descrp").html('晚来一步，红包已被抢完');
					$("#imgLogo").attr("src","img/state2.png");
				}else{
					$("#descrp").html(desc);
				}
				//$("#descrp").html(desc);
			}
		})
	};
	  
	var bindEvent=function(){
		
		//输入框输入手机号码
		$("#cellphone").bind("input propertychange",function(){
			this.value = this.value.replace(/\D/g, " ").replace(/(\d{3})(\d{4})(\d{4})/,'$1 $2 $3');
			//alert(1)
		});
		
		//第一步
		var toggle=true;
		$("#firstNext").bind("click",function(){
			if(toggle){	
				var phone = $("#cellphone").val();
				var len = phone.length;
				phone=phone.replace(/['\t]/g,'').replace(/\s*/g, '');
				
				if(len>15){
					alert("手机号长度不能超过15位");
					return;
				}
				
				if(!(isPhoneOk($.trim(phone)))){
			    	 alert('对不起，请输入正确的手机号码');
			    	 return;
			     }
				var data={
						"id":id,
						"mobileno":phone
				}
				toggle=false;
				$.ajax({
					url:"/activity/activityMobileCheck.go",//检测手机号
					datatype:"XML",
					data:data,
					success:function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code==0){//符合条件
							g.phone = $.trim(phone);
							sendYZM($.trim(phone))
							
						}else if(code=="-1"){
							alert(desc)
						}else{
							D.confirm(desc)
						}
						toggle=true
					},error:function(){
						toggle=true;
					}
				})
			}
			
		});
		
		//重新获取验证码
		$('#hyzm').on('click',function(){
			if($(this).hasClass('hqyzmcur')){
				console.log(111222)
				sendYZM(g.phone);//发送验证码
			}
		});
		
		
		//获取到验证码之后的下一步 verifySms
		$("#yzmNext").bind("click",function(){
			var t = $("#secondStep input").val();
			
			var len = t.length;
			if(len>8){
				alert("验证码长度不能超过8位");
				return;
			}
			
			if(!$.trim(t)){
				alert("请您输入验证码")
				return;
			};
			var data={
					mobileNo:g.phone,
					yzm:$.trim($("#secondStep input").val()),//验证码
					tid:"2"
			};
			$.ajax({
				url:"/user/verifySms.go",//检测验证码
				datatype:"XML",
				data:data,
				success:function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code=="0"){//符合条件
						clearTimeout(timeout);
						$("#thirdStep").show();
						$("#firstStep").hide();
						$("#secondStep").hide();
					}else{
						alert(desc)
					}
				}
			})
		});
		
		$("#thirdStep span").bind("click",function(){
			var t = $(this).prev().attr("type");
			if(t=="text"){
				$(this).prev().attr("type","password");
			}else{
				$(this).prev().attr("type","text");
			}
		});
		
		$("#getRedPacket").bind("click",function(){
			var pw = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/;
			var pwd = $("#thirdStep input").val();
			var len = pwd.length;
			
			if(!pw.test(pwd)){
				alert("密码为6-20位数字和字母组合");
				return;
			}
			
			if(len<6||len>20){
				alert("密码为6-20位数字和字母组合");
				return;
			}
			
			if(!$.trim(pwd)){
				alert("请设置您的密码")
				return;
			}
			var source = "3002"
				console.log(comeFrom)
			if(comeFrom == "qzkj"){
				source = "3047"
			}else if(comeFrom == "qzkj1"){
				source = "3048"
			}else if(comeFrom == "qzkj2"){
				source = "3049"
			}else if(comeFrom == "kuwo2017"){
				source = "3046"
			}
			
			var data={
					"newValue":"2",//1=微信方式 2=普通h5方式
					"code":"",//微信授权后获得的code   当flag=1是，传此参数
					"rid":"",// 微信公众号的appid  当flag=1是，传此参数
					"secret":"", //微信授权使用  当flag=1是，传此参数
					"aid":id, //参与的活动id
					"pwd":pwd,//用户密码
					"source":source,//用户来源
					"mobileNo":g.phone,//手机号码
					"imei":"",//手机IMEI码
					"logintype":"0",//0=session登录  1=token登录
					"comeFrom":comeFrom
			};
			
			$.ajax({
				url:"/activity/registerActivityCheck.go?id="+id,
				datatype:"XML",
				success:function(xml){
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					if(code==0){//符合条件
						$.ajax({
							url:"/user/activityRegister.go",//检测手机号
							datatype:"XML",
							data:data,
							success:function(xml){
								var R = $(xml).find("Resp");
								var code = R.attr("code");
								var desc = R.attr("desc");
								if(code==0){//符合条件
									window.location.href="state.html?id="+id+"&phone="+g.phone;
									//location.reload();
								}else{
									alert(desc)
								}
							}
						})
					}else{
						alert(desc);
					}
				}
			})
		});
		
		$("#openUrl").bind("click",function(){
			appRet();
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
	            download_url: 'http://t.9188.com/',
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

	var init = function(){
		$("input").val("");
		if(timeout){
			clearTimeout(timeout);
		}
		
		render();
		bindEvent();
	};
　　　
	return {
       init:init
　　　};
　　});