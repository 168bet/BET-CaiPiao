var XHC={};

var noGame  = '<div style="text-align: center; padding: 50px;">暂无数据</div>';
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



var D={};
var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		
		confirm:function(msg, fn, tag){
			$('#popup1 p').html(msg);
			tag && $('#popup1 div.jpTrue a:eq(0)').html("取消") || $('#dConfirm div.jpTrue a:eq(1)').html(tag);
			$('#popup1').show();
			$(".zhezhao").show();
			$('#popup1 a:eq(0)').one('click',function(){//取消
				//if(typeof(fn) == "function"){fn();}
				$('#popup1').hide();
				$(".zhezhao").hide();
			});
			$('#popup1 a:eq(1)').one('click',function(){//确定
				if(typeof(fn) == "function"){fn();}
				$('#popup1').hide();
				$(".zhezhao").hide();
			});
		},

		confirm_login:function(fn1, tag1, tag2, fn2,tag){
			tag1 && $('#popup1 div a:eq(0)').html(tag1) || $('#popup1 div a:eq(0)').html('取消');
			tag2 && $('#popup1 div a:eq(1)').html(tag2) || $('#popup1 div a:eq(1)').html('确定');
			tag && $("#popup1 p").html(tag);
			$('.zhezhao, #popup1').show();
			$('#popup1 div a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn1) == "function"){fn1();}
				
				$('.zhezhao, #popup2').hide();
			});
			$('#popup1 div a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn2) == "function"){fn2();}
				
				$('.zhezhao, #popup2').hide();
			});
		}
		
};


var remove_alert = function () {
	$('.alertBox').remove();
	$('#mask').hide();
};
var CP={}
CP.MobileVer = (function ($) {
	var u = navigator.userAgent;
	var obj = {
		android: false,
		ios: false,
		ios7: false,
		ipad: false,
		wp:false
	};
	obj.android = (u.indexOf('Android') > -1 || u.indexOf('Linux') > -1);
	obj.ios = (!!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/));
	obj.ipad = u.indexOf('iPad') > -1;
	obj.wp = u.indexOf("Windows Phone") > -1;
	if (obj.ios) {
		if (u.indexOf('7_') > -1) {
			obj.ios7 = true;
		}
	}
	return obj;
})();
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

XHC.ZLK=(function(){
	var from = location.search.getParam("from");
	var appversion = location.search.getParam("appversion");
	appversion=appversion?parseInt(appversion.replace(/\./g,'')):"";
	
	var name = localStorage.getItem("username")||"";
	var conct="";
	var init = function(){
		/***
		var callbacks = $.Callbacks()
		
		callbacks.add(news_cont);
		callbacks.add(init_for_time);
		callbacks.add(bindEvent);
		callbacks.add(query_award_list);
		callbacks.fire();
		***/
		
		if(from &&  (from=="android" || from=="ANDROID")){
			tokenLogin();
		}else if(from &&  (from=="wp" || from=="WP")){
			tokenLogin();
		}else if(from && (from=="IOS" || from=="ios")){
				//alert(appversion)
				tokenLogin();
		}else{
			$.ajax({
		        url: "/user/mchklogin.go",
		        type: "POST", 
		        success:function (data){
		     	    var R = $(data).find("Resp");
		 			var code = R.attr("code");
		 			if (code == "10001") {//已登录
		 				//bind_input();
		 				//read_num();
		 				query_award_list()
		 			}else{
		 				D.confirm_login(function(){
		 					var url='register.html';
		 					//4g
		 				    window.location.href = url;
		 					
		 				},'注册','登录',function(){
		 					var url='login.html';
		 					window.location.href = url;
		 				},"参与抢购前，请先登录");
		 			}
		        }
			});
		}
		
		
		news_cont()
		
		init_for_time()
		bindEvent()
		
	}
	
	$(function(){
		$.ajax({
			url: "/user/querybind.go",
	        type: "POST",
	        dataType:"xml",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var code = R.attr("code");
	        	if(code==0){
	        		var r = R.find("row");
	        		conct = r.attr("mobile");
	        	}
	        }
		})
	})
	
	//查询所需参数
	var Queryparam={
			"mtype":"4",//终端类型    不能为空    安卓 1，iOS 2，WP 3，触屏 4
			"appversion":"",//客户端版本号   只有触屏可以为空
			"flag":"0",//操作类型标识  0-查询类标识   1-增删改类标识
			"qtype":"0",//查询类操作 标识   flag=0时不可为空
			"phtype":"",//排行榜类型  qtype=4时不可为空
			"utype":"",//增删改类操作标识 flag=1时不可为空
			"usepoint":"",//utype=1时不可为空
			"psize":"10",//每页显示记录数,可为空
			"pnum":"1",//当前页数,可为空
			"date1":"",//查询开始日期,可为空
			"date2":"",//查询截止日期,可为空
			"mid":"",//场次id  phtype=s时不可为空
			"ddstatus":"",//竞猜记录类型 可为空  1-有效竞猜   2-无效竞猜    空-全部竞猜
			"cgameid":""//彩种类型 可为空   1-足球  2-篮球   空-不区分彩种
	};
	
	var toLogin = function(){
		D.confirm_login(function(){
			var url='register.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(4, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('clickIosRegister');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"22"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		},'注册','登录',function(){
			var url='login.html';
			if(CP.MobileVer.android){//android
				try {
					window.caiyiandroid.clickAndroid(3, '');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
				try {
					WebViewJavascriptBridge.callHandler('clickIosLogin');
				} catch (e){
					window.location.href = url;
				}
			}else if(CP.MobileVer.wp){
				try {
					window.external.notify('{"code":"21"}');
				} catch (e){
					window.location.href = url;
				}
			}else{//4g
				window.location.href = url;
			}
		},"参与兑奖前需先登录");
	}
	
	//判断用户是否登录
	var tokenLogin=function(){
		var allcookies = document.cookie;
		if(allcookies.indexOf('TOKEN')!='-1'){
			//alert('加载中..','load');
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
					cache:false,
					type:'POST',
					success:function(xml){
						$.ajax({
							url:'/user/query.go?flag=6',
							type:'POST',
							dataType:'xml',
							success: function(xml) {
								var R = $(xml).find('Resp');
								var c = R.attr('code');
								if(c == '0'){//已登录 
									query_award_list()
									remove_alert();
								}else{//未登录
									//location.href='login.html';
									toLogin()
								}
								o.against();
							}
						});
					}
				});
			},.3e3);
		}else{
			toLogin();
		}
	};
	
	//查询奖品列表
	var query_award_list=function(){
		//alert(2)
		var html="";
		$.ajax({
	        url: "/activity/ticket.go?flag=2&visit=3000",
	        type: "POST",
	        dataType:"xml",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var time = R.attr("time");
	        	var desc = R.attr("desc");
	        	var code = R.attr("code");
	        	var balance = R.attr("balance")||"0";
	        	$("#jq_value").html(balance);
	        	
	        	var newb = parseInt(balance.replace(/,/g,""));
	        	if(code==200){//处理成功
	        		var rows = R.find("rows");
		        	
		        	var row = rows.find("row");
		        	
		        	
		        	if(row.length){
	        			$(".jpzwsj").hide();
		        		row.each(function(){
		        			var itemRemark = $(this).attr("itemRemark");//奖券描述
				        	var cashMaxnum = $(this).attr("cashMaxnum");//当日可兑换最大次数
				        	var cashRemainum = $(this).attr("cashRemainum");//当日可兑换剩余次数
				        	
				        	var itemCash = parseInt($(this).attr("itemCash"));
				        	var id = $(this).attr("id");
				        	
				        	var surenum = parseInt(cashMaxnum)-parseInt(cashRemainum);//已确认兑换次数
				        	var surepercent = parseInt(((surenum/parseInt(cashMaxnum)).toFixed(2)*100))+"%"
				        	
				        	var cgtype = $(this).attr("cgtype");
				        	var pictureMB = $(this).attr("pictureMB");//移动端奖品图片地址
				        	var picturePC = $(this).attr("picturePC");//移动端奖品图片地址
				        	var consticket = $(this).attr("consticket");
				        	var valid = $(this).attr("valid");
				        	
				        	var c="ljdh"//jplink
				        	
				        	if(valid=="false"){
				        		c="ydw"
				        	}else if(cashRemainum==0){
				        		c="ydw"
				        	}else if(newb<consticket){
				        		c="ydw"
				        	}
				        	
				        	var d = new Date()
				        	if(d.getHours()<10){
				        		c="ydw";
				        	}
				        	
		        			html += '<article class="jplink" consticket="'+consticket+'" cashRemainum="'+cashRemainum+'" tid="'+id+'" valid="'+valid+'" consticket="'+consticket+'" lid="'+id+'" cgtype="'+cgtype+'" itemRemark="'+itemRemark+'" itemCash="'+itemCash+'">'
				        	html += '<figure><img src="'+pictureMB+'" width="100%"/></figure>'
				        	html += '<div>'
				        	html += '<p><strong>'+consticket+'</strong>奖券</p>'
				        	html += '<p><em>已抢购'+surepercent+'</em><cite><b style="width: '+surepercent+';"></b></cite></p>'
				        	html += '</div>'
				        	html += '<span><a href="#" class="'+c+'">立即兑换</a>剩余'+cashRemainum+'件</span>'
				        	html += '</article>'
		        		})
		        	}else{
		        			$(".jpzwsj").show();
		        	}
		        	$("#prize_list").html(html)
	        	}else if(code==1002){
	        		$(".jpzwsj").show();	        		
	        	}else{
	        		if(code!=1){//未登陆不弹框
		        		alert(desc);
	        		}
	        	}
	        }
		})
	};
	
	var case_prize_data={
			id:"",
			flag:"4",
			cnickid:name,//用户名
			cgtype:"",//兑换分类（1-话费 2-Q币 3-红包）'
			itemCash:"",//兑换物品金额，如果是红包则表示红包ID
			itemRemark:"",//物品描述
			consticket:"",//消费奖券
			contact:"",//联系方式
			visit:3000,
			
	}
	
	//奖品兑换
	var cash_prize = function(){
		$("#popup2").hide();
		$("#zhezhao").hide();
		$.ajax({
	        url: "/activity/ticket.go",
	        type: "POST",
	        data:case_prize_data,
	        dataType:"xml",
	        success:function (xml){
	        	var R = $(xml).find("Resp");
	        	var code = R.attr("code");
	        	var desc = R.attr("desc");
	        	
	        	if(code==200){//兑换成功
	        		alert("恭喜您,兑换成功!");
	        		query_award_list()
	        	}else if(code==213){//未绑定身份证
	        		D.confirm_login("参与活动前,需先完善实名认证!",function(){
						window.location.href="./idcard.html";
					},"去认证");
	        	}else if(code==214){//未绑定手机号
	        		D.confirm_login("参与活动前,需先绑定手机号!",function(){
						window.location.href="./phone.html";
					},"去绑定");
	        	}else if(code==212){//身份证手机号都没有绑定
	        		D.confirm_login("参与活动前,需先绑定手机号!",function(){
						window.location.href="./phone.html";
					},"去绑定");
	        	}else{
	        		alert(desc);
	        	}
	        }
		})
	}
	
	
	
	var news_cont=function(){
		//alert(1)
		var html="";
		$.ajax({
			url:"/activity/ticket.go?flag=5",
			dataType:'xml',
			cache:true,
			success:function(xml){
				var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
				
				var R = $(xml).find("Resp");
				var desc = R.attr("desc");
				var code = R.attr("code");
				var rows = R.find("rows");
				if(code==200){
					var row = rows.find("row");
					if(row.length){
						if(row.length>1){
							$("#demo").show();						
						}
						row.each(function(a){
							var operor = $(this).attr("operor");//操作人
							var cnickid = $(this).attr("cnickid");//操作人
							var createTime = Date.parse(new Date($(this).attr("createTime")));//操作时间
							var itemRemark = $(this).attr("itemRemark");//奖品描述
							
							//var temp=""
							var strtime = (parseInt((parseInt(n_)-parseInt(createTime))/(60*1000)))
							if(strtime>10){
								var D = new Date(createTime);
								var H = D.getHours();
								H=H<10?"0"+H:H;
								
								var M = D.getMinutes();
								M=M<10?"0"+M:M;
								
								strtime=H+":"+M
							}else{
								strtime=strtime+"分钟前&nbsp;"
							}
							
							a<10 && (html+='<li style="color:white">'+strtime+'&nbsp;<cite style="color:yellow">'+cnickid+'</cite>兑换了<em style="color:yellow">'+itemRemark+'</em></li>')
							
						})						
						
					}else{
						$("#demo").hide();

					}

					
					$("#scroll_Cont").html(html);
					
					var speed=50
					   var demo = document.getElementById("demo");
					   var scroll_Cont = document.getElementById("scroll_Cont");
					   var demo2 = document.getElementById("demo2");
					   demo2.innerHTML=scroll_Cont.innerHTML
					   function Marquee(){
						   if(demo.scrollLeft-demo2.offsetWidth>=0){
						    demo.scrollLeft-=scroll_Cont.offsetWidth;
						   }
						   else{
						    demo.scrollLeft++;
						   }
					   }
						  
					   var MyMar=setInterval(Marquee,speed)
					   /*demo.onmouseover=function() {clearInterval(MyMar)}
					   demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}*/
				}
			}
		})
	}
	
	//事件
	var bindEvent = function(){
		$("#prize_list").delegate("article span","click",function(){
			case_prize_data.cgtype=$(this).parent().attr("cgtype");
			case_prize_data.itemRemark=$(this).parent().attr("itemRemark");
			case_prize_data.itemCash = $(this).parent().attr("itemCash");
			case_prize_data.consticket = $(this).parent().attr("consticket");
			case_prize_data.id = $(this).parent().attr("tid");
			
			var jq_value = $("#jq_value").html();
			var bl = parseInt(jq_value.replace(/,/g, ''))
			var cashRemainum = $(this).parent().attr("cashRemainum");
			var valid = $(this).parent().attr("valid");
			
			

		
			
        	var d = new Date()
        	if(d.getHours()<10){
        		alert("每天10点开始抢购哦~");
        		return ;
        	}else{
    			if(valid=="false"){
    				alert("您今日已兑换过该奖品,请明天再来");
    				return ;
            	}else if(cashRemainum==0){
            		alert("该奖品已兑完,请明天再来");
            		return ;
            	}else if(bl<case_prize_data.consticket){
            		alert("您奖券不足，快去冲榜赢奖券吧");
            		return ;
            	}   		     		
        	}
			
			
			
			/**
			var hf = '<h4>确认兑换</h4>';
				hf += '<p>您将花费<em class="red">280,000</em>奖券兑换<em class="red">20元话费</em>，该话费将于明日12点前充至您账户定的手机号码<em class="red">132****536</em></p>';
				
			var qb = '<h4>确认兑换</h4>'
				qb +='<p>您将花费<em class="red">280,000</em>奖券兑换<em class="red">10Q币</em>，请填写QQ号，该Q币将于明日12点前充至该QQ号账户中</p>'
				qb +='<input type="tel" placeholder="请输入您将充值的QQ号" />'
				qb +='<input type="tel" placeholder="请重复输入您将充值的QQ号" />'	
			
			var hb = '<h4>确认兑换</h4>'
				hb += '<p>您将花费<em class="red">280,000</em>奖券兑换<em class="red">10元红包</em>。</p>'
				***/
			if(case_prize_data.cgtype==1){//话费
				var hf = '<h4>确认兑换</h4>';
				hf += '<p>您将花费<em class="red">'+case_prize_data.consticket+'奖券</em>兑换<em class="red">'+case_prize_data.itemCash+'元话费</em>，该话费将于明日12点前充至您账户定的手机号码<em class="red">'+conct+'</em></p>';
				$("#popup2 article").html(hf)
			}else if(case_prize_data.cgtype==2){//Q币
				var QQ = localStorage.getItem("QQ");
				var qb = '<h4>确认兑换</h4>'
				qb +='<p>您将花费<em class="red">'+case_prize_data.consticket+'奖券</em>兑换<em class="red">'+case_prize_data.itemCash+'Q币</em>，请填写QQ号，该Q币将于明日12点前充至该QQ号账户中</p>'
				qb +='<input type="tel" placeholder="请输入您将充值的QQ号" />'
				qb +='<input type="tel" placeholder="请重复输入您将充值的QQ号" />'	
				$("#popup2 article").html(qb)
				if(QQ){
					$("#popup2 article input").val(QQ);
				}
			}else if(case_prize_data.cgtype==3){//红包
				//case_prize_data.itemCash = $(this).parent().attr("lid");
				var hb = '<h4>确认兑换</h4>'
				hb += '<p>您将花费<em class="red">'+case_prize_data.consticket+'奖券</em>兑换<em class="red">'+case_prize_data.itemRemark+'</em>。</p>'
				$("#popup2 article").html(hb)
			}else if(case_prize_data.cgtype==4){//实物
				//case_prize_data.itemCash = $(this).parent().attr("lid");
				var hb = '<h4>确认兑换</h4>'
				hb += '<p>您将花费<em class="red">'+case_prize_data.consticket+'奖券</em>兑换<em class="red">'+case_prize_data.itemCash+'</em>。</p>'
				$("#popup2 article").html(hb)
			}else if(case_prize_data.cgtype==5){//现金
				//case_prize_data.itemCash = $(this).parent().attr("lid");
				var hb = '<h4>确认兑换</h4>'
				hb += '<p>您将花费<em class="red">'+case_prize_data.consticket+'奖券</em>兑换<em class="red">'+case_prize_data.itemRemark+'</em>。现金将充入您的彩票账户,到账后可直接提现到您的银行卡。</p>'
				$("#popup2 article").html(hb)
			}
			
			$("#popup2").show();
			$("#zhezhao").show();
		})
		
		$("#popup2 div.jpTrue a:eq(1)").bind("click",function(){
			if(case_prize_data.cgtype==1){//话费
				case_prize_data.contact=conct;
			
			}else if(case_prize_data.cgtype==2){//Q币
				var v1 = $("#popup2 input:eq(0)").val();
				var v2 = $("#popup2 input:eq(1)").val();
				

				if(!(/^[1-9]\d{4,8}$/.test(v1))) {
										
					alert("请输入5~10位有效QQ号码")
					return;								
				}
				if(v1!=v2){
					alert("您两次输入的号码不一致，请重新输入")
					return;
				}
				case_prize_data.contact=v1;
				localStorage.setItem("QQ", case_prize_data.contact);
				
			}else{
				case_prize_data
			}
			cash_prize();
		})
		
		$("#popup2 div.jpTrue a:eq(0)").bind("click",function(){
			$("#popup2").hide();
			$(".zhezhao").hide();
		})
	};
	
	var yj_global={
			time:""
	}
	
	var init_for_time=function(){
		//alert(3)
		 $.ajax({
             url:'/activity/getservertime.go',
             type : 'post',
             dataType : "xml",
             async : false,
             success : function(xml) 
             {
                 var time_start1 = 0
                 var R = $(xml).find("Resp");
                 if(R.attr("code") == "200"){
                     var time = R.attr("time")
                     yj_global.time = time
                     time_start = new Date(time).getTime();
                     setInterval(function(){
                         time_start = 1000 + time_start
                         var tmp = new Date(time_start).getHours();
                         if(parseInt(tmp)<10){
                        	 $("#qg_time").show();
                        	 $("#qg_title").html("每日10点开抢");
                        	 $("#time").show();
                         }else{
                        	 $("#qg_title").html("疯狂抢购中&nbsp;(每日10点开抢)");//疯狂抢购中...
                        	 $("#qg_time").hide();
                        	 $("#time").hide();
                         }
                         TimeControler(time_start)
                     },1000)
                 }else{
                     console.log(R.attr("desc"))
                 }
             }
         })
	}
	
	
	//时间计时器组件
	var TimeControler = function(data){
	    var time_start = data;
	    var time_end =  new Date("2015-07-13T10:00:00.080+08:00").getTime(); //设定目标时间

	    // 计算时间差 
	    var time_distance = time_end - time_start;
	    // 天
	    var int_day = Math.floor(time_distance/86400000) 
	    time_distance -= int_day * 86400000; 
	    // 时
	    var int_hour = Math.floor(time_distance/3600000) 
	    time_distance -= int_hour * 3600000; 
	    // 分
	    var int_minute = Math.floor(time_distance/60000) 
	    time_distance -= int_minute * 60000; 
	    // 秒 
	    var int_second = Math.floor(time_distance/1000) 
	    // 时分秒为单数时、前面加零
	    if(int_day < 10){ 
	        int_day = "0" + int_day; 
	    } 
	    if(int_hour < 10){
	        int_hour = "0" + int_hour; 
	    } 
	    if(int_minute < 10){ 
	        int_minute = "0" + int_minute;  
	    } 
	    if(int_second < 10){
	        int_second = "0" + int_second; 
	    } 
	    // 显示时间 
	    $(".yj_time_Hour").text(int_hour)
	    $(".yj_time_Minu").text(int_minute)
	    $(".yj_time_Sec").text(int_second)
	    // setTimeout("TimeControler()",1000)
	}
	
	return {
		init:init
	}
})();

$(function(){
	XHC.ZLK.init();
})

	var from = location.search.getParam("from");
	
	if(from){
		localStorage.setItem("from", from);
	}

var remove_header=function(){
	var arg = localStorage.getItem("from");
	if(arg){
		$(".tzHeader").hide();
	}else{
		$(".tzHeader").show();
	}
}
remove_header();
