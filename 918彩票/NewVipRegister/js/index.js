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
var Action={};
Action.Click_eyes=function(){
	$('.eye_a').click(function(e){
		e.stopPropagation();
		var $this=$(this);
		if($this.hasClass('close')){
			$this.siblings("input[type='password']").attr('type','text');
			$this.removeClass('close').addClass('open');
		}else{
			$this.siblings("input[type='text']").attr('type','password');
			$this.removeClass('open').addClass('close');
		}
	})
}
//验证手机有效性
Action.isPhoneOk=function(tel){
	var reg = 	/^((13[0-9])|(15[^4,\\d])|(18[0-9])|(14[0-9])|(17[0-9]))\d{8}$/;
	if(reg.test(tel)){
		return true;
	}
	return false;
}
var time=60;
var toggle=true;
var timer;
Action.ClickCode_a=function(){
	$('.pop_btn a').bind('click', function(){
		$('.Mask').hide();
		$('.pop').hide();
		
	})
	$('.code_a').click(function(e){
		e.stopPropagation();
		Action.seccode(true)
	})
	$('#yym').click(function(e){
		e.stopPropagation();
		Action.seccode(false);
	})
}
Action.seccode = function(bool){ //获取验证码
	var getPhoneNumber=$.trim($("#cellphone").val().replace(/['\t]/g,'').replace(/\s*/g, ''));
	if(Action.isPhoneOk(getPhoneNumber)){
		if(toggle){
			toggle=false;
			//获取验证码
			var getDate=new Date().getTime();
			var getSignmsg=md5('imNo='+getPhoneNumber+'&timestamp='+getDate+'&key='+'1.0^adhfjkas565a4sdf36a4s6df46^');
			//console.log(getSignmsg)
			var data={
				'mobileNo':getPhoneNumber,
				'imNo':getPhoneNumber,
				'newValue':0,
				'flag':2,
				'signtype': bool?'':'voice',
				'stime':getDate,
				'signmsg':getSignmsg
			}
			$.ajax({
	     	 type: 'POST',
	         data:data,
	         url: '/user/sendSms.go',
	         success:function (data){                 
	        	var R = $(data).find("Resp");
	   			var code = R.attr("code");
	   			var desc = R.attr("desc");
	   			   if (code == "0"){
	   			   		toggle=false;
	   					if(!bool){
	   						$('.Mask').show();
	   						$('.pop').show();
	   						$('#yym').addClass('yym')
	   					}
	   					$('#yym').css({'color':'#999'})
	   					// $('.icon_4').show(500)
	   					 timer=setInterval(function(){
							if(time!=0){
								$('.code_a').html(time+"'")
								time--;
							}else{
								$('.code_a').html(time+"'")
								clearInterval(timer);
								setTimeout(function(){
									$('.code_a').html('获取验证码')
								},500)
								toggle=true;
								time=60;
								if($('#yym').hasClass('yym')){
									$('#yym').removeClass('yym')
								}
								$('#yym').css({'color':'#00b4ff'})
							}
						},1000)
				   }else{
				   		toggle=true;
						alert(desc);
				   }
	          },
	          error:function(){
	          		toggle=true;
	        	  alert('网络异常');
	          }
	     	});
			
		}else{
			alert('短信正在路上，请稍后重试')
		}
	}else{
		alert('请输入正确的手机号')
	}
}
Action.share=function() {
	$.ajax({
		url : '/requestService.go',
		type : 'POST',
		data : {
			action : 'getShareParam',
			shareurl : location.href
		},
		success : function(xml) {
			var R = $(xml).find('Resp');
			var r = R.find('row');
			var appId = r.attr('appId');
			var timestamp = r.attr('timestamp');
			var nonceStr = r.attr('nonceStr');
			var signature = r.attr('signature');
			wx.config({
				debug : false,// 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
				appId : appId, // 必填，公众号的唯一标识
				timestamp : timestamp, // 必填，生成签名的时间戳
				nonceStr : nonceStr, // 必填，生成签名的随机串
				signature : signature,// 必填，签名，见附录1
				jsApiList : [ 'onMenuShareTimeline',
						'onMenuShareAppMessage',
						'onMenuShareQQ', 'onMenuShareWeibo' ]
			// 必填，需要使用的JS接口列表，所有JS接口列表见附录2

			});
			wx.ready(function() {
						var title = '免费注册9188彩票'; // 分享标题
						var desc = '专业好用的体育彩票、福利彩票预约购买App~彩种我最全，体彩、福彩全部彩种我都有；购彩我最快，支付宝、微信支付购彩，一键购买安全快捷；工具我最多，历史开奖、走势图、智能追号、专家推荐、奖金优化...'; // 分享描述
						var link = location.href; // 分享链接
						var imgUrl = 'http://5.9188.com/NewVipRegister/img/sharelogo.png'; // 分享图标
						var dataUrl = location.href;// 如果type是music或video，则要提供数据链接，默认为空
						// alert(imgUrl)
						// location.host+'/activity/NewVipRegister/img/sharelogo.png'
						wx.onMenuShareAppMessage({//分享给朋友
							title : title,
							desc : desc,
							link : link, // 分享链接
							imgUrl : imgUrl, // 分享图标
							type : 'link', // 分享类型,music、video或link，不填默认为link
							dataUrl : dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
							success : function() {
								// 用户确认分享后执行的回调函数
							},
							cancel : function() {
								// 用户取消分享后执行的回调函数
							}
						});
						wx.onMenuShareTimeline({//分享到朋友圈
							title : title, // 分享标题
							link : link, // 分享链接
							imgUrl : imgUrl, // 分享图标
							success : function() {
								// 用户确认分享后执行的回调函数
							},
							cancel : function() {
								// 用户取消分享后执行的回调函数
							}
						});

						wx.onMenuShareQQ({//分享到QQ
							title : title, // 分享标题
							desc : desc, // 分享描述
							link : link, // 分享链接
							imgUrl : imgUrl, // 分享图标
							success : function() {
								// 用户确认分享后执行的回调函数
							},
							cancel : function() {
								// 用户取消分享后执行的回调函数
							}
						});

						wx.onMenuShareWeibo({//分享到腾讯微博
							title : title, // 分享标题
							desc : desc, // 分享描述
							link : link, // 分享链接
							imgUrl : imgUrl, // 分享图标
							success : function() {
								// 用户确认分享后执行的回调函数
							},
							cancel : function() {
								// 用户取消分享后执行的回调函数
							}
						});
						// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready函数中。
					});
		}
	});
}
Action.GetQueryString=function(name) {
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
Action.CheckValue=function(){
	var iName = $.trim($("#uName").val());
	var iNamelen = iName.length;
	var iCode = $.trim($("#pWord").val());
	var phone = $("#cellphone").val();
	var Usermsg = $("#Usermsg").val();
	//phone = phone.replace(/\D/g, '');
	phone=phone.replace(/['\t]/g,'').replace(/\s*/g, '') 
	var re = /^[\da-zA-Z\u4E00-\u9FA5]{4,16}$/;
	var cs = /^[\d]{4,16}$/;
	var cat = /^[\x20-\x7f]+$/;
	var pw = /^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/g;
	//phone = phone.replaceAll(" ", "")
	var len = iCode.length;
	if(iName == "" && len == 0){
		alert('请输入用户名和密码');
		return false;
	}else if(iName == ""){
		alert('请输入用户名');
		return false;
	}else if (len == 0) {
		alert("请输入密码");
		return false;
	} else if(!(re.test(iName))){
		alert('用户名为4-16位汉字、数字、字母组合');
		return false;
	} else if(cs.test(iName)){
		alert('用户名不可以全为数字');
		return false;
	}else if (len < 6) {
		alert('您输入的密码不能低于6位');
		return false;
	} else if (len > 20) {
		alert('您输入的密码不能超过20位');
		return false;
	} else if (iCode == iName) {
		alert('密码不能够与用户名一致！请重新输入');
		return false;
	}else if (!(pw.test(iCode))) {
		alert('密码为6-20的字母、数字组合');
		return false;
	}else if(!(Action.isPhoneOk($.trim(phone)))){
    	 alert('对不起，请输入正确的手机号码');
    	 return false;
    }else if(Usermsg==''){
     	alert('验证码不能为空')
     	return false;
    }else{
    	//校验验证码
     remove_alert();
     $.ajax({
     	 type: 'POST',
         data:{
         	'mobileNo':phone,
         	'yzm':Usermsg,
         	'tid':2
         },
         url: '/user/verifySms.go',
         success:function (data){                 
        	var R = $(data).find("Resp");
   			var code = R.attr("code");
   			var desc = R.attr("desc");
   			   if (code == "0"){
   					var url = "/user/mregister.go";
   					var comeFrom=Action.GetQueryString('comeFrom')||Action.GetQueryString('comefrom');
					var data = 'uid='
					+ encodeURIComponent($.trim(iName))
					+'&comeFrom='
					+comeFrom
					+ "&pwd="
					+ encodeURIComponent($.trim(iCode))
					+ '&mobileNo='+phone;
					$.ajax({
				     	type: 'POST',
				         data: data,
				         url: url,
				         success:function (data){                 
				        	var R = $(data).find("Resp");
				   			var code = R.attr("code");
				   			var desc = R.attr("desc");
				   			   if (code == "0"){
				   				alert(desc);
				   				  
				   					try {
					   					localStorage.setItem("iCode",iCode);
					   				} catch(_) {
					   				    alert("本地储存写入错误，若为safari浏览器请关闭隐身模式浏览。");
					   				}
					   				$("#cellphone,#Usermsg").val('');
					   				window.location.href="./register_success.html";
							   }else{
								   alert(desc);
								   $("#Usermsg").val('');
								   clearInterval(timer);
									setTimeout(function(){
										$('.code_a').html('获取验证码')
									},500)
									toggle=true;
									time=60;
								   
							   }
				          },
				          error:function(){
				        	  alert('网络异常');
				          }
				     });
			   }else{
					alert(desc);
			   }
          },
          error:function(){
        	  alert('网络异常');
          }
     	});
	}
	// if(iName == "" && len == 0){
	// 	alert('请输入用户名');
	// 	return false;
	// }
	// if(iName == ""){
	// 	alert('请输入用户名');
	// 	return false;
	// }
	// if(iNamelen>16){
	// 	alert("您输入的用户名不能超过16位")
	// 	return false;
	// }
	// if(iNamelen<4){
	// 	alert("您输入的用户名不能低于4位")
	// 	return false;
	// }
	// if (len == 0) {
	// 	alert("请输入密码");
	// 	return false;
	// }
	// if (len < 6) {
	// 	alert('您输入的密码不能低于6位');
	// 	return false;
	// }
	// if (len > 20) {
	// 	alert('您输入的密码不能超过20位');
	// 	return false;
	// }
	// if (iCode == iName) {
	// 	alert('密码不能够与用户名一致！请重新输入');
	// 	return false;
	// }
	// if (!(cat.test(iCode))) {
	// 	alert('密码请勿包含中文');
	// 	return false;
	// }
	// if(!(Action.isPhoneOk($.trim(phone)))){
 //    	 alert('对不起，请输入正确的手机号码');
 //    	 return false;
 //     }
 //     if(Usermsg==''){
 //     	alert('验证码不能为空')
 //     	return false;
 //     }
     
    
}
$(document).ready(function(){
	Action.Click_eyes();
	Action.ClickCode_a();
	//微信分享
	Action.share();
	$(".register_box div:eq(0)").bind("click",function(e){
		e.stopPropagation();
		$("#uName").focus();
		moveEnd($("#uName").get(0))
	})
	
	$(".register_box div:eq(1)").bind("click",function(e){
		e.stopPropagation();
		$("#pWord").focus();
		moveEnd($("#pWord").get(0))

	})
	
	$(".register_box div:eq(2)").bind("click",function(e){
		e.stopPropagation();
		$("#cellphone").focus();
		moveEnd($("#cellphone").get(0))

	})

	$(".register_box div:eq(3)").bind("click",function(e){
		e.stopPropagation();
		$("#Usermsg").focus();
		moveEnd($("#Usermsg").get(0))
		
	})

	$('.register_btn').click(function(e){
		e.stopPropagation();
		$(this).hasClass('disabled_a')||Action.CheckValue();
	})

	$("#cellphone").keyup(function(){
		//this.value = this.value.replace(/\D/g, " ").replace(/(\d{3})(\d{4})(\d{4})/,'$1 $2 $3');
		dry();
	})
	function dry(){
		var uName = $("#uName").val()
		var pWord = $("#pWord").val()
		var cellphone = $("#cellphone").val()
		var Usermsg = $("#Usermsg").val();
		if(uName && pWord && cellphone && Usermsg){
			$(".register_btn").attr("disabled",false).removeClass('disabled_a');
		}else{
			$(".register_btn").attr("disabled",true).addClass('disabled_a');
		}
	}
	
	$("#uName").bind("input propertychange",function(){
		dry();
	});

	$("#Usermsg").bind("input propertychange",function(){
		dry();
	});
	
	$("#pWord").bind("input propertychange",function(){
		dry();
	});
	function moveEnd(obj){
        obj.focus(); 
        var len = obj.value.length; 
        // alert(len);
        if (document.selection) { 
            var sel = obj.createTextRange(); 
            sel.moveStart('character',len); //设置开头的位置
            sel.collapse(); 
            sel.select(); 
        } else if (typeof obj.selectionStart == 'number' && typeof obj.selectionEnd == 'number') { 
            obj.selectionStart = obj.selectionEnd = len; 
        } 
    } 
})