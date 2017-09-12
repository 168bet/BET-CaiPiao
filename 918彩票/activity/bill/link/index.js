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

var Bill = {};//账单类

//页面初始化
Bill.Init = (function(){
	var pageColor = [];//颜色
	var anchors = [];//瞄
	var start_ev = ('ontouchstart' in window ) ? 'touchstart' : 'mousedown';
	var from = location.search.getParam('from');
	var date_ = '';
	var o = {
		pad: function (source, length) {
			var pre = "",
				negative = (source < 0),
				string = String(Math.abs(source));
			if (string.length < length) {
				pre = (new Array(length - string.length + 1)).join('0');
			}
			return (negative ? "-" : "") + pre + string;
		},
		/**
		 * @description 根据彩种id 获取信息
		 * @param {number} n 彩种id 不可空
		 * @param {number} m 为空默认0( 0-彩种名 1-彩种位置 2-彩种对应合买里面的索引)
		 * @example o.lot(1);return 双色球
		 * @return {str} 返回需要的信息
		 */
		lot: function (n, m){
			m = m || '0';
			n = parseInt(n);
			var lot = {
					'1': ['双色球'],
					'3': ['福彩3D'],
					'4': ['时时彩'],
					'5': ['新快3'],
					'6': ['快3'],
					'7': ['七乐彩'],
					'8': ['福彩快3'],
					'9': ['江苏快3'],
					'20':['新时时彩'],
					'50':['大乐透'],
					'51':['七星彩'],
					'52':['排列五'],
					'53':['排列三'],
					'54':['11选5'],
					'55':['广东11选5'],
					'56':['11运夺金'],
					'57':['上海11选5'],
					'58':['快乐扑克3'],
					'80':['胜负彩'],
					'81':['任选九'],
					'82':['进球彩'],
					'83':['半全场'],
					'84':['单场-胜负过关'],
					'85':['单场-胜平负'],
					'86':['单场-比分'],
					'87':['单场-半全场'],
					'88':['单场-上下单双'],
					'89':['单场-总进球'],
					'90':['竞彩-让球'],
					'91':['竞彩-比分'],
					'92':['竞彩-半全场'],
					'93':['竞彩-总进球'],
					'70':['竞彩-混投'],
					'72':['竞彩-胜平负'],
					'94':['篮彩-胜负'],
					'95':['篮彩-让分'],
					'96':['篮彩-胜分差'],
					'97':['篮彩-大小分'],
					'71':['篮彩-混投']
			};
			return lot[n][m];
		},
		init : function(){
			function main(){
				$.ajax({
					type:"get",
					url:"/user/queryaccoutway.go",
					async:true,
					dataType:'xml',
					success:function(xml){
						var date_ = new Date(arguments[2].getResponseHeader("Date"));//服务器时间
						date_ = (date_.getMonth()+1)+''+o.pad(date_.getDate(),2);
						if(parseInt(date_)>224){//初七之后隐藏
							$('#endbtn').hide();
						}
						var R = $(xml).find('Resp');
						var code = R.attr('code');
						var desc = R.attr('desc');
						if(code == 0){
							var t = {};
							var r = R.find('row');
							t.days = r.attr('days');//page1 注册天数
							t.cregister = r.attr('cregister');//page2 注册时间
							t.cattach = r.attr('cattach');//page3 首次购买 时间 金额 彩种
							t.cjc = r.attr('cjc');//page3 首次购买竞技彩 时间 金额 彩种
							t.cssq = r.attr('cssq');//page3 首次购买 时间双色球 金额 彩种
							t.caward = r.attr('caward');//page4 首次中奖 时间 金额 彩种
							t.ccash = r.attr('ccash');//page5 首次提款 时间 金额
							t.chm = r.attr('chm');//page6 首次参加合买 时间 金额
							t.caward_most = r.attr('caward_most');//page7 最高奖 时间 金额 彩种
							t.cthousand = r.attr('cthousand');//page8 累计中奖超过1000元的时间
							t.ctmoney = r.attr('ctmoney');//page9 累计中奖总金额
							t.percent = r.attr('percent');//page9 打败了百分之多少的用户
							t.jccost_per = r.attr('jccost_per');//page9 竞技场购买比例
							t.kpcost_per = r.attr('kpcost_per');//page9 快频购买比例
							t.mpcost_per = r.attr('mpcost_per');//page9 慢频购买比例
							t.jcaward_per = r.attr('jcaward_per');//page9 竞技场中奖比例
							t.kpaward_per = r.attr('kpaward_per');//page9 快频中奖比例
							t.mpaward_per = r.attr('mpaward_per');//page9 慢频中奖比例
							t.order = r.attr('order');//按时间排序
							
							o.render(t);
							o.fullpage();
						}else{
							if(desc == '用户未登录'){
								var url = 'login.html';
								if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
									try {
										WebViewJavascriptBridge.callHandler('clickIosLogin');
									} catch (e){
										location.href = url;
									}
								} else {
									$('.popup2,.mask').show();
									$('#islogin').bind('click',function(){
										location.href = url;
									});
								}
							}else if(desc.indexOf('信息不存在')>=0){
								$('#page_1,#page_2,#page_3_1,#page_3_2,#page_4,#page_5,#page_6,#page_7,#page_8,#page_9,#page_10_1').remove();
								pageColor.push('#0a6cbb');
								anchors.push('page1');
								o.fullpage();
							}else{
								alert(desc);							
							}
						}
					},
					error:function(){
						alert('网络异常，请重新打开页面');
					}
				});
			}
			if(from == 'android'){
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
								logintype:'1',
								accesstoken:token,
								appid:appid
							},
							type:'POST',
							success:function(){
								$.ajax({
									url:'/user/query.go?flag=6',
									type:'POST',
									dataType:'xml',
									success: function(xml) {
										var R = $(xml).find('Resp');
										var c = R.attr('code');
										if(c == '0'){//已登录
											main();
										}else{//未登录
											location.href='login.html';
										}
									},
									error:function(){
										alert('网络异常，请重新打开页面');
									}
								});
							},
							error:function(){
								alert('网络异常，请重新打开页面');
							}
						});
					},200);
				}else{
					$('.popup2,.mask').show();
					$('#islogin').bind('click',function(){
						window.caiyiandroid.clickAndroid(3, '');
					});
					window.caiyiandroid.clickAndroid(3, '');
				}
			}else{
				main();
			}
		},
		//渲染数据
		render : function(t){
			function per(x){
				var per_obj = {
					'数字彩' : t.mpaward_per,
					'竞技彩' : t.jcaward_per,
					'高频彩' : t.kpaward_per
				}
				for(var i in per_obj){
					if(per_obj[i] == x){
						return i;
					}
				}
			}
			
			//page1
			pageColor.push('#2b5488');
			setTimeout(function(){
				var i = 0;
				var n = parseInt(t.days)+1;//使用天数
				var x,tt;
				if(n<10){//10代表累加2秒
					x = 1;
					tt = setInterval(function(){
						if((i+x)<=n){
							$('#day').text(i += x);
						}else{
							$('#day').text(n);
							clearInterval(tt);
						}
					}, 200);
				}else{
					x = parseInt(n/10);
					tt = setInterval(function(){
						if((i+x)<=n){
							$('#day').text(i += x);
						}else{
							$('#day').text(n);
							clearInterval(tt);
						}
					}, 200);
				}
			},2e3);
			
			//page2
			pageColor.push('#6b2596');
			$('#page2_sj').html(t.cregister.substr(0,10));//注册时间
			
			//page3
			if(t.cattach != ''){
				pageColor.push('#047905');
				var cattach = t.cattach.split('|');
				if(cattach[2] == '01'){
					$('#page_3_1').remove();
					$('#title3_2').html('首次购买双色球<cite>'+cattach[1]+'</cite>元');
				}else{
					$('#page_3_2').remove();
					$('#title3_1').html('购买'+o.lot(cattach[2])+'首次中奖<cite>'+cattach[1]+'</cite>元');
				}
				$('#page3_1_sj,#page3_2_sj').html(cattach[0].substr(0,10));
			}else{
				$('#page_3_1,#page_3_2').remove();
			}
			
			//page4
			if(t.caward != ''){
				pageColor.push('#c71b1b');
				var caward = t.caward.split('|');//第一次中奖
				$('#page4_sj').text(caward[0].substr(0,10));
				$('#title4').html('购买'+o.lot(caward[2])+'首次中奖<cite>'+caward[1]+'</cite>元');
			}else{
				$('#page_4').remove();
			}
			
			//page5
			if(t.ccash != ''){
				pageColor.push('#0a6cbb');
				var ccash = t.ccash.split('|');//第一次提款
				$('#page5_sj').text(ccash[0].substr(0,10));
				$('#title5 cite').html(ccash[1]);
			}else{
				$('#page_5').remove();
			}
			
			//page6
			if(t.chm != ''){
				pageColor.push('#0a6cbb');
				var chm = t.chm.split('|');
				$('#page6_sj').text(chm[0].substr(0,10));
				$('#title6 cite').html(chm[1]);
			}else{
				$('#page_6').remove();
			}
			
			//page7
			if(t.caward_most != ''){
				pageColor.push('#c71b1b');
				var caward_most = t.caward_most.split('|');//最高中奖
				$('#page7_sj').text(caward_most[0].substr(0,10));
				$('#title7 cite').text(caward_most[1]);
			}else{
				$('#page_7').remove();
			}
			
			//page8
			if(t.cthousand != ''){
				pageColor.push('#0a6cbb');
				$('#page8_sj').text(t.cthousand.substr(0,10));
			}else{
				$('#page_8').remove();
			}
			
			//page9
			if(t.ctmoney != 0){
				pageColor.push('#6b2596');
				$('#title9 cite:eq(0)').text(t.ctmoney);
				var all = '865426';
				var zj = '185677';
				var percent = ((1-(1-t.percent)*all/zj)*100).toFixed(1);
				$('#title9 cite:eq(1)').text(percent+'%');
				
				var per_arr = [t.mpaward_per, t.jcaward_per, t.kpaward_per];
				per_arr = per_arr.sort();
				
				var min = (per_arr[0]*100).toFixed(1);
				var mid = (per_arr[1]*100).toFixed(1);
				var max = (100-parseFloat(min)-parseFloat(mid)).toFixed(1);
				$('#page9_min').html(per(per_arr[0])+'<cite>'+min+'%</cite>');
				$('#page9_mid').html(per(per_arr[1])+'<cite>'+mid+'%</cite>');
				$('#page9_max').html(per(per_arr[2])+'<cite>'+max+'%</cite>');
			}else{
				$('#page_9').remove();
			}
			
			//page10
			if(pageColor.length >2){
				pageColor.push('#c71b1b');
				$('#page_10_2').remove();
			}else{
				$('#page_10_1').remove();
				$('#page_1').remove();
				$('#page_2').remove();
				pageColor = [];
				pageColor.push('#0a6cbb');
			}
			
			for(var i=1,j=pageColor.length; i<=j; i++){
				anchors.push('page'+i);
			}
		},
		fullpage : function(){
			$('#fullpage').show();
			$('#load').hide();
			$('#fullpage').fullpage({
				'verticalCentered': false,
				'css3': true,
				'sectionsColor': pageColor,
				anchors: anchors,
				'navigation': true,
				'navigationPosition': 'right'
			})
		}
	};
	var init = function () {
		o.init();
		bind();
	};
	var bind = function(){
		$('#lottery').bind(start_ev,function(){
			if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
				WebViewJavascriptBridge.callHandler('clickIosLottery','01');
			} else if (from == 'android') {
				window.caiyiandroid.clickAndroid(0, '01');
			} else {
			    window.location.href ="/#type=url&p=list/ssq.html";
			};
		});
//		var ua = navigator.userAgent.toLowerCase();
//		if(ua.match(/MicroMessenger/i)=="micromessenger") {  
//			$('#endbtn').text('分享');
//	    }
		$('#endbtn').bind('click', function(){
//		    if(ua.match(/MicroMessenger/i)=="micromessenger") {  
//		        $('.mask,.show').show();
//		        $('.mask,.show').bind('click', function(){
//		        	$('.mask,.show').hide();
//		        });
//		    }else{
		    	location.href='/activity/newyear/';
//		    }
		});
	};
	init();
})();

//	function shareCont(){
//		var imgUrl = 'http://5.9188.com /activity/bill/img/shareinc.jpg';
//		var lineLink = 'http://5.9188.com /activity/bill/index.html';
//		var shareTitle = '我在9188中奖总额***元,来跟土豪做朋友吧！';
//		var descContent = "来到9188**天，我就打败了**%的用户，牛逼的人生不需要解释";  
//
//		WeixinJSBridge.invoke('sendAppMessage',{  
//			"img_url": imgUrl,  
//			"img_width": "400",  
//			"img_height": "400",  
//			"link": lineLink,  
//			"desc": descContent,  
//			"title": shareTitle  
//		}, function(res) {
//		  
//		})
//	}
//
//	function shareTimtline(){
//		var imgUrl = 'http://5.9188.com /activity/bill/img/shareinc.jpg'; 
//		var lineLink = 'http://5.9188.com /activity/bill/index.html';
//		var shareTitle = '我在9188中奖总额***元,来跟土豪做朋友吧！';  
//		var descContent = "来到9188**天，我就打败了**%的用户，牛逼的人生不需要解释";  
//
//		WeixinJSBridge.invoke('shareTimeline',{
//			"img_url": imgUrl,
//			"img_width": "400",
//			"img_height": "400",
//			"link": lineLink,
//			"desc": descContent,
//			"title": shareTitle  
//		}, function(res) {
//		  
//		})
//	}
//
//	// 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。  
//	document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
//      	// 发送给好友  
//	    WeixinJSBridge.on('menu:share:appmessage', function(argv){
//		    shareCont();
//		});
//		// 分享到朋友圈  
//	    WeixinJSBridge.on('menu:share:timeline', function(argv){
//        	shareTimtline();
//        });
//    }, false);