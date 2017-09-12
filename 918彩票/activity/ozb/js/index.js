//FastClick.attach(document.body);
/*
http://iphone.9188.com  /data/gyj/16001/gyj.xml
http://iphone.9188.com  /data/gyj/16001/gj.xml
GJ|14002=1/2/3/4/5/6/7/9/10/11/13/15/16
GYJ|14001=1/3/4/5
 */
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

var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
var end_ev = ('ontouchend' in window ) ? 'touchend' : 'mouseup';
var move_ev = ('ontouchend' in window ) ? 'touchmove' : 'mousemove';

var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};
var OZB = (function(){
	var myScroll = false;//猜冠军
	var myScroll2 = false;//冠亚军
	var PlayType="GJ";
	var len,codeStr;
	var util = {
			getParam: function (name) {  
		        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");  
		        var r = window.location.search.substr(1).match(reg);  
		        if (r != null) return unescape(r[2]);  
		        return null;  
		    }
	}
	var g = {
			select : util.getParam('sel') || false,//专题页 带着支持的队伍进来的
			source : util.getParam('source') || '1000',
			appversion : util.getParam('appversion') ||''
	}
	if(!!sessionStorage.getItem('appversion')){
		g.appversion = sessionStorage.getItem('appversion')
	}else{
		sessionStorage.setItem('appversion', g.appversion)
	}
	var payParam={
			gid:"98",//彩种id   98   99
			pid:"",//期号id
			play:1,//玩法 复式1  单式0
			codes:"",//投注内容
			muli:1,//方案倍数
			fflag:0,// 是否文件上传  no  0  非文件上传  1 文件上传 
			type:0 ,//方案类型  no  0 代购   1合买 
			name:"",// 方案宣传标题  yes 
			desc:"",// 方案宣传内容  yes   
			money:2,// 方案金额  no   
			tnum:1,// 方案总份数  no  代购为1  
			bnum:1,// 购买份数  no 
			pnum:0,// 保底份数  no  保底份数 
			oflag:0,// 方案查权限  no  0 公开  1 截止后公开 2对参与者公开  3对参与者截止后公开 
			wrate:0,// 提成比例  no  代购为0   合买为自己设置的比例数字 
			comeFrom:"",// 用户来源  yes   
			source:g.source,// 方案来源  no  取定义好的值 非代理商的为1000代理商从1001开始（android）  2000 代理商从2001开始 （ios）  
			endTime:"",// 方案截止时间  yes   
			upay:"", //是否订单支付  yes 
			cupacketid:"",// cupacketid  红包id  yes    
			redpacket_money:"",// redpacket_money  使用红包金额  yes 
			appversion:g.appversion || '432'
	};
	var o = {
			
			select: function(){
				o.count_()
				var c_top = $('#gj_list .cur').offset().top,//当前元素距离顶部高度
				c_height = $('#gj_list .cur').height(),//当前元素高度
				s_top = $('#footer>div').offset().top;//屏幕可视高度
				if(c_top+c_height>s_top){
					myScroll.scrollTo(0, '-'+c_top-(s_top/2), 10);
				}
			},
			//猜冠军(获取冠军对阵)
			cgj:function(){
				var html="";
				$.ajax({
					url:"/data/gyj/16001/gj.xml",
					dataType : "xml",
					success : function(xml){
						var R = $(xml).find("Resp");
						var desc = R.attr("desc");
						var code = R.attr("code");

						if(code==0){
							var r = R.find("row");
							if(r.length){
								
								var _out = [], html = [];
								r.each(function(){
									var matchid=payParam.pid=$(this).attr("matchid");
									var state=$(this).attr("state");
									var isale=$(this).attr("isale");
									var result=$(this).attr("result");
									var cindex=$(this).attr("cindex");
									var name=$(this).attr("name");
									var sp=parseFloat($(this).attr("sp"));
									sp=sp.toFixed(2)
									var cur = '';
									
									if(!!g.select){
										if(cindex == g.select){
											cur = 'cur'
										}
									}
									var c = "";
									if(state=="0" && isale=="0"){
										c=""
									}else{
										if(result=="0"){//出局
											c="no"
										}else if(result=="3"){//胜出
											c="win"
										}else{//停售
											c="no"
										}
									}
									
									var h ='<li matchid="'+matchid+'" sp="'+sp+'" cindex="'+cindex+'" class="'+c+' '+cur+'"><span>'+cindex+"&nbsp"+name+'</span><cite>'+sp+'</cite></li>';
									
									if (isale != 0 || state != 0) {
										if (result != "") {
											if (result == 0) {
												_out.push(h)
											} else if (result == 3) {
												html.push(h)
											} else {
												_out.push(h)
											}
										} else {
											_out.push(h)
										}
									}else{
										html.push(h)
									}
								}) 
							}
							$("#gj_list").html(html.join('')+_out.join(''));
							$('#cgj').show()
							myScroll.refresh()
							if(!!g.select){
								o.select()
							}
							$("#gj_list li").not(".no").click(function(){
								$(this).toggleClass("cur");
								o.count_();
							});
						}
					},
					error:function(){

					}
				});
			},
			//猜冠亚军
			cgyj:function(){
				var html="";
				$.ajax({
					url:"/data/gyj/16001/gyj.xml",
					dataType : "xml",
					success : function(xml){
						var R = $(xml).find("Resp");
						var desc = R.attr("desc");
						var code = R.attr("code");

						if(code==0){
							var r = R.find("row");
							if(r.length){
								var _out = [], html = [];
								r.each(function(){
									var matchid=payParam.pid=$(this).attr("matchid");
									var state=$(this).attr("state");
									var isale=$(this).attr("isale");
									var cindex=$(this).attr("cindex");
									var name=$(this).attr("name");
									var result=$(this).attr("result");
									var sp=parseFloat($(this).attr("sp"));
									sp=sp.toFixed(2);
									
									var c = "";
									
									if(state=="0" && isale=="0"){
										c=""
									}else{
										if(result=="0"){//出局
											c="no"
										}else if(result=="3"){//胜出
											c="win"
										}else{//停售
											c="no"
										}
									}
									var h = '<li class="'+c+'" matchid="'+matchid+'" sp="'+sp+'" cindex="'+cindex+'"><span>'+cindex+"&nbsp;"+name+'</span><cite>'+sp+'</cite></li>';
									
									if (isale != 0 || state != 0) {
										if (result != "") {
											if (result == 0) {
												_out.push(h)
											} else if (result == 3) {
												html.push(h)
											} else {
												_out.push(h)
											}
										} else {
											_out.push(h)
										}
									}else{
										html.push(h)
									}
								}) 
							}
							$("#gyj_list").html(html.join('')+_out.join(''));
							$('#gyj').show();
							myScroll2.refresh();
							$("#gyj_list li").not(".no").click(function(){
								$(this).toggleClass("cur");
								o.count_();
							});
						}
					},
					error:function(){

					}
				});
			},

			/*购买验证[[*/
			dobuy : function(t){
				var info = '';
				var v= $("#pay_money").val();
				if(v%2==1 || !v){
					alert("请输入2的整数倍")
					return;
				}
				
				/***
				if(parseInt(v)<10){
					alert("至少请输入10RMB")
					return;
				}
				***/
				//首选判断用户是否登录
				$.ajax({
					url:'/user/query.go?flag=6',
					type:'GET',
					success:function(xml){
						var R = $(xml).find('Resp');
						var c = R.attr('code');
						if(c == '0'){//说明用户登录，可以查询出信息
							var r = R.find('row');
							var ipacketmoney = r.attr('ipacketmoney');//红包余额.
							var usermoeny = r.attr('usermoeny');//账户余额

							$("#buy_box p").eq(0).find("cite").html(payParam.money+"元");//投注金额
							$("#buy_box p").eq(1).find("cite").html(usermoeny+"元");//账户余额

							$("#buy_box").show();//显示购买弹窗
							$("#mask2").show();//遮罩层
							if(payParam.money>usermoeny){//投注金额大于账户余额的时候，去充值
								$("#buy_box .zfTrue a").eq(1).show();
								$("#buy_box .zfTrue a").eq(2).hide();
							}else{//否则隐藏
								$("#buy_box .zfTrue a").eq(1).hide();
								$("#buy_box .zfTrue a").eq(2).show();
							}
							//弹出购买窗
							//this.buybox();

							//取消
							$("#buy_box .zfTrue a").eq(0).click(function(){
								$("#buy_box, #mask2").hide();

							});

							//去充值
							$("#buy_box .zfTrue a").eq(1).click(function(){
								var UA = navigator.userAgent;
								if(/iphone/i.test(UA)){
									try {
										WebViewJavascriptBridge.callHandler('callBackIOS','3');
									} catch (e){
										window.location.href = '/#type=url&p=user/charge.html';
									}

								}else if(/android/i.test(UA)){
									try {
										window.caiyiandroid.clickAndroid(7, '');
									} catch (e){
										window.location.href = '/#type=url&p=user/charge.html';
									}

								}else{
									window.location.href = '/#type=url&p=user/charge.html';
								}
							});

							//去投注
							$("#buy_box .zfTrue a").eq(2).click(function(){
								//获取总金额
								var money = payParam.money = parseInt($("#pay_money").val())*len;
								payParam.codes=o.code_();//获取投注内容
								
								o.buybox();
							});

						}else{//登录
							//alert(navigator.userAgent);
							if(navigator.userAgent.indexOf('UCBrowser') > -1) {
								
								window.location.href = 'login.html';
							}else{
								var UA = navigator.userAgent;
								if(/i(phone|os|pad)/i.test(UA)){
									try {
										WebViewJavascriptBridge.callHandler('clickIosLogin');
									} catch (e){
										window.location.href = 'login.html';
									}
								}else if(/android/i.test(UA)){
									try {
										window.caiyiandroid.clickAndroid(3, '');
									} catch (e){
										window.location.href = 'login.html';
									}
								}else{
									window.location.href="login.html";
								}
							}
						}
					},error : function () {
						remove_alert();
						alert('网络异常请刷新重试');
					}
				});

			},

			//投注方法
			buybox:function(){
				$.ajax({
					url:'/trade/jcast.go',
					type:'GET',
					data:payParam,
					success:function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");

						if(code==0){//投注成功
							r = R.find('result');
							projid = r.attr('projid');//方案编号
							localStorage.removeItem('record')
							$("#buy_box").hide();
							$("#mask").hide();
							location.href='success.html?projid='+projid;
						}else{
							alert(desc);
						}
					}
				})
			},
			//计算选值对阵数
			count_:function(){
				len = $("article.bg article:not(.gyj-hidden) ul li.cur").length;
				if(len){
					$("#cs").html("已选择"+len+"个选项");
				}else{
					$("#cs").html("至少选择1个选项");
				}
			},
			//清空
			clear_:function(){
				$("#gj_list li").removeClass("cur");
				$("#gyj_list li").removeClass("cur");
				$("#cs").html("至少选择1个选项");
				len=0;
			},
			//拼凑code值
			code_:function(){
				var code_str
				var $ob = $("article.bg article:not(.gyj-hidden) ul li.cur");
				var t=[];
				var tmp=""
					$ob.each(function(){
						var cindex=$(this).attr("cindex");
						var matchid=tmp=$(this).attr("matchid");
						t.push(cindex);
					})
					var t_ = t.join("/");
				code_str = PlayType+"|"+tmp+"="+t_;
				return code_str
			},
			//计算投注金额，奖金范围
			count_money:function(){
				var $ob = $("article.bg article:not(.gyj-hidden) ul li.cur");
				var num = $ob.length;
				var t_=[];
				$ob.each(function(){
					var sp=$(this).attr("sp");
					var matchid=tmp=$(this).attr("matchid")
					t_.push(sp);
				});
				var max=Math.max.apply({},t_);
				var min=Math.min.apply({},t_);

				var v = parseInt($("#pay_money").val())||0;
				var total = v*num||0;

				$("#description").html("共"+num+"注"+total+"元");
				$("#scope").html((v*min).toFixed(2)+"~"+(v*max).toFixed(2));
			},
			
			autologin: function(){
				var allcookies = document.cookie;
				if(allcookies.indexOf('TOKEN')!='-1'){
					sessionStorage.setItem('hideHeader', 'true')
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
							type:'POST',
							success:function(){
							},
							error:function(){
								alert('网络异常，请重新打开页面');
							}
						});
					},300);
				}
			},
			
			grade_: function(fnc,fnc1){
				$.ajax({
					url:'/trade/getyourgrade.go?mtype=4&appversion=',
					dataType:'xml',
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code=="0"){//查询成功
							var row = R.find("row");
							var grade = parseInt(row.attr("grade"));//0      未开通白名单，用户未登录时默认返回   1      已开通但是不能投注  2  已开通      可以投注
							//alert(grade)
							//this.white_list_grade = grade;
							localStorage.setItem("grade", grade);
							//登录用户是否开通白名单，白名单等级判断
							if(grade>0){
								typeof fnc == "function" && fnc();
							}else{
								typeof fnc1 == "function" && fnc1();
							}
							localStorage.setItem('grade',grade);//白名单等级存储起来
						}else{
							typeof fnc1 == "function" && fnc1();
						}
					}
				})
			},
		  //投注参数
			bind: function(){
				$('#next').click(function(){
					if(len){
						console.log(len);
						$($('#footer .dete')[0]).addClass('dete-hidden');
						$($('#footer .dete')[1]).removeClass('dete-hidden');
						$('#mask').show();
						
						o.grade_(function(){
							$('#buy_box .zfTrue a').eq(2).html("预约彩票");
							
							$("#buy_box h4").html("预约确认");
							
							$("#ljyy").html("立即预约")
						},function(){
							$('#buy_box .zfTrue a').eq(2).html("确认");
							
							$("#buy_box h4").html("投注确认");
							
							$("#ljyy").html("确认投注")
							
						});
						
						o.count_money();
					}else{
						alert("至少选择一个选项")
					}
					//o.code_()
				});

				$('#mask').click(function(){
					if(!($("#buy_box")[0].style.display=="none")){
						return;
					}
					$($('#footer .dete')[0]).removeClass('dete-hidden')
					$($('#footer .dete')[1]).addClass('dete-hidden')
					$('#mask').hide()

				});
				//导航切换
				$('#tab li').on('touchend', function(){
					if($(this).hasClass('cur'))return;
					$(this).addClass('cur').siblings().removeClass('cur')
					o.clear_()
					if(!$(this).index()){
						payParam.gid="98"
							$('.gyj').addClass('gyj-hidden')
							$('.cgj').removeClass('cgj-hidden')
							PlayType="GJ";
						myScroll.refresh()
						myScroll.scrollTo(0, 0, 500);
					}else{
						payParam.gid="99"
							$('.gyj').removeClass('gyj-hidden')
							$('.cgj').addClass('cgj-hidden')
							PlayType="GYJ";
						myScroll.refresh()
						myScroll2.scrollTo(0, 0, 500);
					}

					$($('#footer .dete')[0]).removeClass('dete-hidden')
					$($('#footer .dete')[1]).addClass('dete-hidden')
					$('#mask').hide()
				});

				//清空
				$("#cl").bind(start_ev,function(){
					len=0;
					o.clear_();
				});

				//
				$("#pay_money").keyup(function(){
					o.count_money();
				});

				$("#pl em").bind(start_ev,function(){
					var tmp = $("#pay_money")[0];
					if(!$(this).index()){//减
						tmp.value = tmp.value-2<=0?'2':tmp.value-2;
					}else{//加
						tmp.value = +tmp.value+2
					}
					o.count_money()
				});
				$('#pay_money').keyup(function(){
					this.value = this.value.replace(/\D/, '')
				});


				
				$("#ljyy").click(function(){
					//获取总金额
					var money = payParam.money = parseInt($("#pay_money").val())*len;
					payParam.codes=o.code_();//获取投注内容
					payParam.muli=parseInt($("#pay_money").val())/2;
					if(money<=0){
						alert("请输入合理的金额")
						return;
					}
					//localStorage.setItem('record', payParam.codes)
					o.dobuy(); 
				})

			},
			init: function(){
				o.autologin()
				o.bind()
				o.cgj()
				o.cgyj();
				var top = $('#footer>div').offset().top - $('#tab').height();
				$('#cgj, #gyj').css('height', top+'px')
				myScroll = new IScroll('#cgj', { mouseWheel: true, click: true });
				myScroll2 = new IScroll('#gyj', { mouseWheel: true, click: true });
				
				
			}
	}
	return {
		init:o.init,
		g:g,
		param:payParam
	};
})()
OZB.init()

