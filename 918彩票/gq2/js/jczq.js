var XHC={};
var CP={};
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


var D = {
		/*
		 * @param msg 弹窗内容
		 * @param fn 回调方法
		 * @param tag 需要改版按钮的文字
		 */
		
		sendConfirm:function(fn,fn1){
			$('.zhezhao, #popup2').show();
			$('#popup2 div a:eq(0)').off().bind('click',function(){//取消
				if(typeof(fn) == "function"){fn();}
				$('.zhezhao, #popup2').hide();
			});
			$('#popup2 div a:eq(1)').off().bind('click',function(){//确定
				if(typeof(fn1) == "function"){fn1();}
				$('.zhezhao, #popup2').hide();
			});
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
var cur_match={};
var matchList=[];//比赛列表
var cyrs={};
var socket;
var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="200" heigth="200"></figure><p>暂无数据</p></article>';
XHC.JCZQ=(function(){
	var today="";
	var date = new Date();
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	m = m<10?"0"+m:m;
	var d = date.getDate();
	d = d<10?"0"+d:d;
	today=y+m+d;
	
	
	
	var url = window.location.href;
	if(url.indexOf("?")!=-1){
		var it = url.split("?")[1];
		if(it){
			
		}
	}
	
	
	var stMap={'17':'未开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'}
	
	
	//获取当前比赛
	
	$(function(){
		
		var url = window.location.href;
		if(url.indexOf("?")!=-1){
			var tempid = url.split("?")[1];
			
			$.ajax({
				async:false,
				url:'/zqjc/matchs/mobile/matchs.xml?' + new Date().getTime(),
				//url:'/zqjc/matchs/matchs.xml?' + new Date().getTime(),
				type: 'GET',
				dataType: 'xml',
				timeout: 1000,
				success: function(data){
					if(!data){
						//$(".zbj").html("暂无数据");
						return;
					}
					//serverTime = new moment(arguments[2].getResponseHeader("Date")).utc();
					$(data).find('row').each(function(i,u){
			    		if(tempid==$(this).attr('id')){
			    			cur_match.id = $(u).attr('id');
			    			cur_match.sid = $(u).attr('sid');
			    			cur_match.mid = $(u).attr('mid');
			    			cur_match.itemId = $(u).attr('itemId');
			    			cur_match.sort = $(u).attr('sort');
			    			cur_match.seasonId = $(u).attr('seasonId');
			    			cur_match.ln = $(u).attr('ln');
			    			cur_match.mtime = $(u).attr('mtime');
			    			cur_match.code = $(u).attr('code');
			    			cur_match.htime = $(u).attr('htime');
			    			cur_match.hn = $(u).attr('hn');
			    			cur_match.gn = $(u).attr('gn');
			    			cur_match.hid = $(u).attr('hid');
			    			cur_match.gid = $(u).attr('gid');
			    			cur_match.hr = $(u).attr('hr');
			    			cur_match.gr = $(u).attr('gr');
			    			cur_match.hsc = $(u).attr('hsc');
			    			cur_match.gsc = $(u).attr('gsc');
			    			cur_match.hrd = $(u).attr('hrd');
			    			cur_match.grd = $(u).attr('grd');
			    			cur_match.halfScore = $(u).attr('halfScore');
			    			cur_match.hscInfo = $(u).attr('hscInfo');
			    			cur_match.gscInfo = $(u).attr('gscInfo');
			    			cur_match.isRank = $(u).attr('isRank');
			    			// 加载聊天室选项
			    			$('body').bind('initChat', function(){
			    				
			    				/***
			    				chat.room && chat.room.leave();
			    				chat.rt && chat.rt.close();
			    				***/
			    				var t = cur_match.itemId
			    				if(t==0){
			    					t="ZC"+cur_match.sid
			    				}
			    				$.ajax({
			    					type: 'post',
			    					async: false,
//			    					url: 'http://mobile.9188.com  /trade/chathomepage.go',
			    					url: '/trade/chathomepage.go',
			    					dataType: 'xml',
			    					data:{itemid: t, bdStage: null,sort: null},
			    					success : function(xml) {
			    						var row = $(xml).find('row');
			    						
			    						chat.rid = row.attr('rid');
			    						chat.roomId = row.attr('convid');
			    						
			    						
			    					}
			    				});
			    			});
			    			$('body').trigger('initChat');
			    			socket = io.connect('192.168.1.240:8186');//210.14.67.5:8185  192.168.1.240:8185
			    			socket.emit('changeMid',cur_match.sid);//建立网络连接
			    		}
					});
				},
				error:function(){
					$(".zwbs").show();
					return;
				}
			});
		}
		
		//get_people();
	})
	
	
	
	
	//更新头部比分
	var update_header=function(obj){
		$("#update li:eq(0)").html('<span>'+obj.hn.substring(0,5)+'</span><cite>'+(obj.hr?'['+obj.hr+']':"")+'</cite>')
		$("#update li:eq(1)").html('<strong>'+(obj.hsc?obj.hsc:"0")+':'+(obj.gsc?obj.gsc:"0")+'</strong><cite>'+stMap[obj.code]+'</cite>')
		$("#update li:eq(2)").html('<span>'+obj.gn.substring(0,5)+'</span><cite>'+(obj.gr?'['+obj.gr+']':"")+'</cite>')
		//getServerTime(obj);
		window.ud=window.setInterval(function(){
			$.ajax({
				async:false,
				url:'/zqjc/change/change.xml',
				type: 'GET',
				dataType: 'xml',
				timeout: 1000,
				success: function(xml,xhr){
					var n_ = Date.parse(new Date(arguments[2].getResponseHeader("Date")));//服务器时间
					var R = $(xml).find("Rows");
					var row = R.find("row");
					row.each(function(){
						var sid = $(this).attr("sid");
						if(obj.sid==sid){
							var code = $(this).attr("code");
							var htime = $(this).attr("htime");
							htime=Date.parse(new Date($(this).attr("htime").replace(/-/g,"/")));
							st = parseInt((n_-htime)/60000);
							var hsc = $(this).attr("hsc");
							var gsc = $(this).attr("gsc");
							var hrd = $(this).attr("hrd");
							var grd = $(this).attr("grd");
							var halfScore = $(this).attr("halfScore");//半场比分
							
							
							if(code==17 ||code==5 ||code==13 ||code==14 ||code==15||code==4){
								clearInterval(window.ud)
								$("#update li:eq(1)").html('<strong>'+(obj.hsc?obj.hsc:"0")+':'+(obj.gsc?obj.gsc:"0")+'</strong><cite>'+stMap[obj.code]+'</cite>')
							}else{
								
								st = parseInt((n_-htime)/60000);
								if(code==1){//上
									st=st<=45?st:45+"+";
									st+='<em class="fen">\'</em>'
								}else if(code==2){//中
									st="";
								}else if(code==3){//下
									st=st<=45?(45+st):(90+"+")
									st+='<em class="fen">\'</em>'
								}
								$("#update li:eq(1)").html('<strong>'+hsc+':'+gsc+'</strong><cite>'+stMap[code]+"&nbsp;"+st+'</cite>')
							}
							
							//$("#update li:eq(1)").html('<strong>'+hsc+':'+gsc+'</strong><cite>'+stMap[code]+"&nbsp"+((stMap[code]==17||stMap[code]==13||stMap[code]==14||stMap[code]==15)?"":st)+'</cite>')
						}
					})
				}
			})
		},1000)
	}
	
	
	
	var o = {//公用的对象
		node : function(){
			
			
			socket.on('loadMatch', function(data){
				quiz.render(data)
			});
			
			//有变化的赔率(被动推送) 	进球或让球对象
			socket.on('changeNode', function(data){
				if(data['mid'] == cur_match.sid){
					option.showChangeOdds(data);
				}
			});
			
			socket.on('stopNode', function(data){
				if(data.rq && data.rq.mid == cur_match.sid || data.jqs && data.jqs.mid == cur_match.sid || data.single_jqs && data.single_jqs.mid == cur_match.sid){
					option.stopNode(data);	
				}
			});
			
			//比赛开停售(比赛页面是否显示)
			socket.on('matchNode', function(data){
				quiz.render(data)
			});
			
			socket.on('resultNode', function(data){
				quiz.render(data)
			});//赛果
		}
	};
	
	var option={
			getPanStr: function(pan, type) {
				var temp = '';
				
				if (pan == 0 && type == 1) {
					temp = '平手';
				} else {
					if (type == 1) {
						if (pan > 0) {
							temp = '主受让';
						} else {
							temp = '主让';
						}
					}
					pan = Math.abs(pan);
					if ((pan/0.25)%4 == 1) {//.25
						temp += Math.floor(pan) + '/' + (pan+0.25);
					} else if ((pan/0.25)%4 == 3) {//.75
						temp += (pan-0.25) + '/' + Math.ceil(pan);
					} else {
						temp += pan;
					}
					temp += '球';
				}
				return temp;
			},
			showChangeOdds: function(data){
				var codeStr = '';
				var single_codeStr='';
				if (('instantPan' in data)) {//让球
					if (data.status == 0) {//初盘
						codeStr = this.getPanStr(data.startPan, 1);
					} else {//及时盘
						codeStr = this.getPanStr(data.instantPan, 1);
					}
					$('#ks ul[type="1"]').attr('oddsid', data.id);
					$('#ks ul[type="1"] li[opt="3"] cite').text(data.htPOdds);
					$('#ks ul[type="1"] li[opt="0"] cite').text(data.vtPOdds);
					$('#ks ul[type="1"] li.mid').text(codeStr);
				} else {//大小球
					if(data.curCode==0){//全场
						if (data.status == 0) {
							codeStr = this.getPanStr(data.startDxf, 2);
						} else {
							codeStr = this.getPanStr(data.instantDxf, 2);
						}
						$('#ks ul[type="2"][curCode="0"]').attr('oddsid', data.id);
						$('#ks ul[type="2"][curCode="0"] li[opt="3"] cite').text(data.htDOdds);
						$('#ks ul[type="2"][curCode="0"] li[opt="0"] cite').text(data.vtDOdds);
						$('#ks ul[type="2"][curCode="0"] li.mid').text(codeStr);
					}else{//半场
						if (data.status == 0) {
							single_codeStr = this.getPanStr(data.startDxf, 2);
						} else {
							single_codeStr = this.getPanStr(data.instantDxf, 2);
						}
						$('#ks ul[type="2"][curCode="1"]').attr('oddsid', data.id);
						$('#ks ul[type="2"][curCode="1"] li[opt="3"] cite').text(data.htDOdds);
						$('#ks ul[type="2"][curCode="1"] li[opt="0"] cite').text(data.vtDOdds);
						$('#ks ul[type="2"][curCode="1"] li.mid').text(single_codeStr);
					}
					
				}
			},
			
			stopNode: function(data){
				/**
				option.load(data);
				option.odds = data;
				**/
				
				quiz.render(data);
			},
			
			resultNode: function(data){
				if (data.mid == cur_match.sid) {
					//总进球(半场)
					$("#jz ul[type=2][curCode=1] li").html('<span>猜上半场总进球大小</span><cite class="red">'+(parseInt(data.single_htScore)+parseInt(data.single_gtScore))+'</cite>')
					
					//总进球
					$("#jz ul[type=2][curCode=0] li").html('<span>猜全场总进球大小</span><cite class="red">'+(parseInt(data.htScore)+parseInt(data.vtScore))+'</cite>')
					
					//让球
					$("#jz ul[type=1][curCode=0] li").html('<span>'+cur_match.hn+' VS '+cur_match.gn+'</span><cite class="red">'+data.htScore+'-'+data.vtScore+'</cite>');
				}
			}
	}
	
	
	//投注参数对象
	var dodata={
			mtype:"4",//终端类型
			appversion:"",//客户端版本号
			itmoney:"",//投注金额
			opt:"",//投注选项  0-主负   3-主胜
			oddsid:"",//赔率id
			type:"",
			cperiodid:"",
			curCode:""
			
	}
	
	
	//竞猜对象
	var quiz={
			start:$("#ks"),
			stop:$("#jz"),
			//初始化渲染，jqs,rq都存在的时候
			render:function(data){
				var html="";
				var js = [],rs=[];
				var data = data;
				
				if(data){
					var htScore = data.htScore;//全场比分(主队)
					var vtScore = data.vtScore;//客队全场比分
					
					var single_htScore = data.single_htScore;//半场比分(主队)
					var single_vtScore = data.single_vtScore;//
					
					var jqs = data.jqs;
					var rq = data.rq;
					var single_jqs = data.singleJqs;
					
					
					var rqpan = rq.startPan;
					var dxpan = jqs.startDxf;
					var single_dxpan = single_jqs.startDxf;
					
					//让球及时盘
					if (rq.status == 1) {
						rqpan = rq.instantPan;
					}
					//大小球及时盘(全场)
					if (jqs.status == 1) {
						dxpan = jqs.instantDxf;
					}
					
					//大小球及时盘(半场)
					if (single_dxpan.status == 1) {
						single_dxpan = single_dxpan.instantDxf;
					}
					
					
					//开售让球
					var rqCodeStr = '<p>猜<cite class="red">全场</cite>让球胜负</p>';
						rqCodeStr += '<ul  oddsid="'+rq.id+'" type="1" cperiodid="'+rq.mid+'" curCode="'+rq.curCode+'">';
						rqCodeStr += '<li opt="3"><span>主胜</span><cite>'+rq.htPOdds+'</cite></li>';
						rqCodeStr += '<li class="mid">'
						if(rq.status==0){//出盘
							rqCodeStr +=option.getPanStr(rq.startPan, 1);
						}else{
							rqCodeStr +=option.getPanStr(rq.instantPan, 1);
						}
						rqCodeStr += '</li>';
						rqCodeStr += '<li opt="0"><span>主负</span><cite>'+rq.vtPOdds+'</cite></li>';
						rqCodeStr += '</ul>';
					
					//大小球(半场)
					var single_jqCodeStr ='<p>猜<cite class="red">上半场</cite>总进球大小<a href="wfgz.html">玩法规则</a></p>';
						single_jqCodeStr +='<ul oddsid="'+single_jqs.id+'" type="2" cperiodid="'+single_jqs.mid+'" curCode="'+single_jqs.curCode+'">';
						single_jqCodeStr +='<li opt="3"><span>大球</span><cite>'+single_jqs.htDOdds+'</cite></li>';
						single_jqCodeStr +='<li class="mid">';
						if(single_jqs.status==0){
							single_jqCodeStr +=option.getPanStr(single_jqs.startDxf, 2);
						}else{
							single_jqCodeStr +=option.getPanStr(single_jqs.instantDxf, 2);
						}
						single_jqCodeStr += '</li>';
						single_jqCodeStr +='<li opt="0"><span>小球</span><cite>'+single_jqs.vtDOdds+'</cite></li>';
						single_jqCodeStr +='</ul>';
						
					//大小球(全场)
					var jqCodeStr ='<p>猜<cite class="red">全场</cite>总进球大小</p>';
						jqCodeStr +='<ul oddsid="'+jqs.id+'" type="2" cperiodid="'+jqs.mid+'" curCode="'+rq.curCode+'">';
						jqCodeStr +='<li opt="3"><span>大球</span><cite>'+jqs.htDOdds+'</cite></li>';
						jqCodeStr +='<li class="mid">';
						if(jqs.status==0){
							jqCodeStr +=option.getPanStr(jqs.startDxf, 2);
						}else{
							jqCodeStr +=option.getPanStr(jqs.instantDxf, 2);
						}
						jqCodeStr += '</li>';
						jqCodeStr +='<li opt="0"><span>小球</span><cite>'+jqs.vtDOdds+'</cite></li>';
						jqCodeStr +='</ul>';
						
					//停售大小球(半场)
					var single_jqjzCodeStr='<p>猜上半场总进球（已截止）</p><ul type="2" curCode="1"><li><span>上半场总进球</span><cite class="red">等待开奖</cite></li></ul>';
					
					//停售大小球
					var jqjzCodeStr='<p>猜全场总进球（已截止）</p><ul type="2" curCode="0"><li><span>全场总进球</span><cite class="red">等待开奖</cite></li></ul>';
					
					//停售让球
					var rqjzCodeStr='<p>猜全场让球（已截止）</p><ul type="1" curCode="0"><li><span>'+jqs.hTName+' VS '+jqs.vTName+'</span><cite class="red">等待开奖</cite></li></ul>'
					
					$("#ks").html("");
					$("#jz").html("");
					
					if(single_jqs.position==1){
						$("#ks").append(single_jqCodeStr);
					}else{
						$("#jz").append(single_jqjzCodeStr);
					}
					
					if(jqs.position==1){
						$("#ks").append(jqCodeStr);
					}else{
						$("#jz").append(jqjzCodeStr);
					}
					
					if(rq.position==1){
						$("#ks").append(rqCodeStr);
					}else{
						$("#jz").append(rqjzCodeStr);
					}
					
					
					
					//总进球(半场)
					data.single_htScore && $("#jz ul[type=2][curCode=1] li").html('<span>猜上半场总进球大小</span><cite class="red">'+(parseInt(data.single_htScore)+parseInt(data.single_vtScore))+'</cite><i></i>')
					
					
					//总进球(全场)
					data.htScore && $("#jz ul[type=2][curCode=0] li").html('<span>猜全场总进球大小</span><cite class="red">'+(parseInt(data.htScore)+parseInt(data.vtScore))+'</cite><i></i>');
					
					//让球
					(data.htScore || data.htScore==0) && $("#jz ul[type=1][curCode=0] li").html('<span>'+cur_match.hn+' VS '+cur_match.gn+'</span><cite class="red">'+data.htScore+'-'+data.vtScore+'</cite><i></i>');
					
					P.betting_fn()
				}
				
				update_header(cur_match);
			},
			
			//获取金豆余额信息
			getGolden : function(){
				$.ajax({
					async:false,
					url:'/grounder/fgoldenbeanaccount.go?flag=0&qtype=5',
					type: 'GET',
					dataType: 'xml',
					timeout: 1000,
					success: function(xml){
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						//userinfo code="0" desc="查询成功" source="null" total="1" tpage="1" balance="6101407.0"
						if(code==0){//查询成功
							var userinfo  = R.find("userinfo ");
							var balance = userinfo.attr("balance");
							balance=parseInt(balance);
							$("#jdyue").html(balance?balance:0);
						}else if(code==1){
							window.location.href="login.html";
						}
					}
				})
			}
	}
	
	//公用方法
	var P={
		//百分比宽度
		setPercentWidth:function(statics1,statics2,obj1,obj2){
			var percentStatics1,percentStatics2;
			var shotsongoalWidth1 = '0';
			var shotsongoalWidth2 = '0';
			 if(statics1 == null || statics1 == ''){
				 	percentStatics1 = '0';
			    }else {
			    	$(obj1).parent().addClass("cur");
			    	percentStatics1 = parseInt((parseInt(statics1) / (parseInt(statics1) + parseInt(statics2)) * 100));
			 }
			 
			 if(statics2 == null || statics2 == ''){
				 	percentStatics2 = '0';
			    }else {
			    	$(obj2).parent().addClass("cur");
			    	percentStatics2 = parseInt((parseInt(statics2) / (parseInt(statics1) + parseInt(statics2)) * 100));
			 }
			 shotsongoalWidth1=percentStatics1+"%";
			 shotsongoalWidth2=percentStatics2+"%";
			 $(obj1).attr('style', 'width:'+shotsongoalWidth1);
		     $(obj2).attr('style', 'width:'+shotsongoalWidth2);
		},
		
		
		//投注方法
		betting_fn:function(){
			$("#ks").delegate("ul li:not(.mid)","click",function(){
				//判断登录，绑定等
				dodata.opt = $(this).attr("opt");
				dodata.oddsid = $(this).parent().attr("oddsid");
				dodata.type = $(this).parent().attr("type");
				dodata.cperiodid = $(this).parent().attr("cperiodid");
				
				dodata.curCode = $(this).parent().attr("curCode");
				
				
				$("#tzCont").attr("type",dodata.type);
				$("#tzCont").attr("opt",dodata.opt);
				$("#tzCont").attr("curCode",dodata.curCode);
				//$("#tzCont").attr("node",dodata.section);
				
				var li_html = $(this).html();
				var mid_html = $(this).siblings(".mid").html();
				var mix = li_html+mid_html;
				
				var que=$(this).find("span").html();
				var sp=$(this).find("cite").html();
				var all="<span>"+que+"</span>&nbsp;&nbsp;"+mid_html+"&nbsp;&nbsp;<cite style='color:grey'>"+sp+"</cite>";
								
				
				$("#pkCont").html(all);
				$("#tzCont").toggle();
				$(".mask").toggle();
				
				var newnum = parseInt($("#in_golden").val())||0;
				
				var pl = $("#pkCont cite").text();
				pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
				pl=parseFloat(pl);
				$("#fh").html(Math.ceil(newnum*pl));
			});
		}
	};
	
	//聊天模块
	var chat={
			rid: 686660,
			room: null,
			today: null,
			cnickid: '_test_',
			lastTime: 0,
			msgCount: 0,
			isListen: true,
			rooms: [],
			roomId: '5575f1cde4b06a320970e7f2',
			app_id: 'zttp1hzf8hcu7ghofbyckz9npj8btalfbyq5e1rf4v1ulmp6',
			
			//初始化
			init: function() {
				this.today = new Date();
				this.today.setHours(0);
				this.today.setMinutes(0);
				this.today.setSeconds(0);
				var mtime = new Date(cur_match.mtime.replace(/-/g, '/'));//当前比赛开始时间
				if (mtime.getTime() - new Date().getTime() < 1000 * 60 * 10) {//比赛开始十分钟内，开启聊天室
					$.ajax({
						url:'/user/query.go?flag=63',
						type : 'post',
						dataType : "xml",
						success : function(xml){
							chat.cnickid = $(xml).find('row').attr('cnickid');//获取用户名
							chat.initCore();
							//$('.zq-lq-o').children(':not(p,.zq-dlq)').show();
						}
					});
					
				} else {
					$('#talk').hide();
					$(".csy").hide();
					$(".lqend").show();
				}
				
			},
			initCore: function() {
				if (this.rt) {
					this.rt.open();
				} else {
					
					//创建一个聊天对象
					var rt = this.rt = AV.realtime({
						appId: this.app_id,
						clientId: this.cnickid,
						encodeHTML: true
					});
					
					// 实时通信服务连接成功
					rt.on('open', function() {
						rt.room(chat.roomId, function(room) {
							chat.room = room;
							if(chat.room){
								room.join(function() {
									// 获取t这个时间之前的历史消息
									room.log({t: new Date().getTime()}, function(data) {
										$('#talk').empty();
										//chat.lastTime = data[0].timestamp;//获取更多用
										$.each(data, function() {
											chat.addMsg(this);
										});
										$("#talk").append('<div style="height:3.8rem">&nbsp;</div>')
									});
									
									if ($.inArray(chat.roomId, chat.rooms) == -1) {
										// 接收消息
										room.receive(chat.addMsg);
										chat.rooms.push(chat.roomId);
									}
								});
							}else{
								console.log('服务器不存在这个 room。');
								$("#talk_cont").html(nodata);
							}
							
						});
					});
				}
			},
			//添加信息
			addMsg: function(data) {
				var time = chat.makeDate(data.timestamp, '')
				$("#talk").prepend('<dl><dt>'+data.fromPeerId+'</dt><dd>'+data.msg+'</dd><dd><cite>'+time+'</cite></dd></dl>')
			},
			sendMsg: function() {
				$.ajax({
					type: 'post',
					async: false,
					//url: 'http://t2015.9188.com /trade/sendnocheckmessage.go',
					url: '/trade/sendmessage.go',
					dataType: 'xml',
					data: {
						rid: chat.rid,
						convid: chat.roomId,
						uid: chat.cnickid,
						message: $('#popup2 .nr').val()
					},
					success : function(xml) {
						var R = $(xml).find("Resp")
						var code = R.attr("code");
						var desc = R.attr("desc");
						if(code == 0){
							$('#popup2 .nr').val('');
						}else{
							alert(desc)
						}
					}
				});
			},
			formatDate: function(date,format){
				var paddNum = function(num){
					num += "";
					return num.replace(/^(\d)$/,"0$1");
				};
				//指定格式字符
				var cfg = {
					yyyy : date.getFullYear(), //年 : 4位
					yy : date.getFullYear().toString().substring(2),//年 : 2位
					M  : date.getMonth() + 1,  //月 : 如果1位的时候不补0
					MM : paddNum(date.getMonth() + 1), //月 : 如果1位的时候补0
					d  : date.getDate(),   //日 : 如果1位的时候不补0
					dd : paddNum(date.getDate()),//日 : 如果1位的时候补0
					hh : paddNum(date.getHours()),  //时
					mm : paddNum(date.getMinutes()), //分
					ss : paddNum(date.getSeconds()) //秒
				};
				format || (format = "yyyy-MM-dd hh:mm:ss");
				return format.replace(/([a-z])(\1)*/ig,function(m){return cfg[m];});
			},
			makeDate: function(time, temp){
				if(time >= chat.today.getTime()){
					temp = chat.formatDate(new Date(time), 'hh:mm:ss');
				}else{//1000 * 60 * 60 * 24
					temp = '昨天';
				}
				return temp;
			},
			countChar: function(){
				var content = $('#talk_info').val();
				var num = chat.getStrLen(content);
				if (num > 140) {
					$('.csy article p').empty().append('还可以输入<cite class="red">0</cite>个字');
					$('#popup2 .nr').val(chat.lastContent);
				} else {
					$('.csy article p').empty().append('还可以输入<cite class="red">'+(100-num)+'</cite>个字');
					this.lastContent = $('#popup2 .nr').val();
				}
			},
			getStrLen:function(str) {// 含中文的字符串长度
				var len = 0;
				var cnstrCount = 0;
				for ( var i = 0; i < str.length; i++) {
					if (str.charCodeAt(i) > 255)
						cnstrCount = cnstrCount + 1;
				}
				len = str.length + cnstrCount;
				return len;
			}
	}
	
	//模块
	var Model={
			//数据
			loadData:function(){
				$.ajax({
					url:"/zqjc/tech/tech_"+cur_match.sid+".json?"+Math.random(),
					dataType:'JSON',
					cache:true,
					success:function(data){
						if(data){
							var events = data["events"];//时间数据
							var statics = data["statics"];//技术统计
							if(statics){
								var possessionTime_A = statics["possessionTime_A"];//主队控球时间
								var possessionTime_B = statics["possessionTime_B"];
								possessionTime_A=possessionTime_A?possessionTime_A:"0";
								possessionTime_B=possessionTime_B?possessionTime_B:"0"
								var shoot_A = statics["shoot_A"];//射门次数
								var shoot_B = statics["shoot_B"];
								
								var shotsonGoal_A = statics["shotsonGoal_A"];//射正球门次数
								var shotsonGoal_B = statics["shotsonGoal_B"];
								
								var foul_A = statics["foul_A"];//主队犯规次数
								var foul_B = statics["foul_B"];
								
								var cornerkick_A = statics["cornerkick_A"];//主队角球次数
								var cornerkick_B = statics["cornerkick_B"];
								
								var offside_A = statics["offside_A"];//主队越位次数
								var offside_B = statics["offside_B"];
								
								var yellowCard_A = statics["yellowCard_A"];//黄牌次数
								var yellowCard_B = statics["yellowCard_B"];
								
								var redCard_A = statics["redCard_A"];//主队红牌数
								var redCard_B = statics["redCard_B"];
								
								var saves_A = statics["saves_A"];
								var saves_B = statics["saves_B"];
								
								var change_A = statics["change_A"];//主队换人
								var change_B = statics["change_B"];
								
								//控球率
								var c1_1 = $(".jstjList li:eq(0) span:eq(0) cite");
								var c1_2 = $(".jstjList li:eq(0) span:eq(1) cite");
								$(c1_1).html(possessionTime_A)
								$(c1_2).html(possessionTime_B)
								
								if(possessionTime_A=="0" && possessionTime_B=="0"){
									$(c1_1).html(possessionTime_A)
									$(c1_2).html(possessionTime_B)
								}else{
									$(c1_1).css({width:possessionTime_A});
									$(c1_2).css({width:possessionTime_B})
									$(c1_1).parent().addClass("cur");
									$(c1_2).parent().addClass("cur");
								}
								//$(c1_1).css({width:possessionTime_A});
								//$(c1_2).css({width:possessionTime_B})
								//$(c1_1).parent().addClass("cur");
								//$(c1_2).parent().addClass("cur");
								
								var c2_1 = $(".jstjList li:eq(1) span:eq(0) cite");
								var c2_2 = $(".jstjList li:eq(1) span:eq(1) cite");
								$(c2_1).html(shoot_A)
								$(c2_2).html(shoot_B)
								P.setPercentWidth(shoot_A, shoot_B, c2_1, c2_2)
								
								var c3_1 = $(".jstjList li:eq(2) span:eq(0) cite");
								var c3_2 = $(".jstjList li:eq(2) span:eq(1) cite");
								$(c3_1).html(shotsonGoal_A)
								$(c3_2).html(shotsonGoal_B)
								P.setPercentWidth(shotsonGoal_A, shotsonGoal_B, c3_1, c3_2)
								
								var c4_1 = $(".jstjList li:eq(3) span:eq(0) cite");
								var c4_2 = $(".jstjList li:eq(3) span:eq(1) cite");
								$(c4_1).html(foul_A)
								$(c4_2).html(foul_B)
								P.setPercentWidth(foul_A, foul_B, c4_1, c4_2)
								
								
								var c5_1 = $(".jstjList li:eq(4) span:eq(0) cite");
								var c5_2 = $(".jstjList li:eq(4) span:eq(1) cite");
								$(c5_1).html(cornerkick_A)
								$(c5_2).html(cornerkick_B)
								P.setPercentWidth(cornerkick_A, cornerkick_B, c5_1, c5_2)
								
								var c6_1 = $(".jstjList li:eq(5) span:eq(0) cite");
								var c6_2 = $(".jstjList li:eq(5) span:eq(1) cite");
								$(c6_1).html(offside_A)
								$(c6_2).html(offside_B)
								P.setPercentWidth(offside_A, offside_B, c6_1, c6_2)
								
								var c7_1 = $(".jstjList li:eq(6) span:eq(0) cite");
								var c7_2 = $(".jstjList li:eq(6) span:eq(1) cite");
								$(c7_1).html(yellowCard_A)
								$(c7_2).html(yellowCard_B)
								P.setPercentWidth(yellowCard_A, yellowCard_B, c7_1, c7_2)
								
								var c8_1 = $(".jstjList li:eq(7) span:eq(0) cite");
								var c8_2 = $(".jstjList li:eq(7) span:eq(1) cite");
								$(c8_1).html(redCard_A)
								$(c8_2).html(redCard_B)
								P.setPercentWidth(redCard_A, redCard_B, c8_1, c8_2)
								
								var c9_1 = $(".jstjList li:eq(8) span:eq(0) cite");
								var c9_2 = $(".jstjList li:eq(8) span:eq(1) cite");
								$(c9_1).html(saves_A);
								$(c9_2).html(saves_B);
								P.setPercentWidth(saves_A, saves_B, c9_1, c9_2)
								
							}else{
								$(".jstjList").html(nodata);
								$(".jstjList").hide()
								$(".jstjList").prev().find("em").addClass("down")
							}
							
							
							var html = "";
							if(events && events.length>0){
								html+='<p class="top">0&prime;</p>';
								for(var i=0;i<events.length;i++){
									//if(events[i].roundChangePlayerCommand){//换人
									/***
										var players = events[i].roundChangePlayerCommand;//换人
										var teamType = players.teamType;//主队or客队
										var time = players.time;//时间
										var downpn = players.downpn;//换下
										var uppn = players.uppn;//换上
										var downside = players.downside
										var upsid = players.upsid
										
										if(teamType==0){//主队换人
											html+='<div class="timeleft timetwo"><span><strong>'+downpn+'<i>&darr;</i></strong><strong>'+uppn+'<i>&uarr;</i></strong></span><b>'+time+'&prime;</b></div>';
										}else{
											html+='<div class="timeright timetwo timetwo2"><b>'+time+'&prime;</b><span><strong><i>&darr;</i>'+downpn+'</strong><strong><i>&uarr;</i>'+uppn+'</strong></span></div>'
										}
										***/
									//}else{
										var statics = events[i];//事件
										var eventType = statics.eventType;//事件类型
										var name = statics.name;//球员
										if(name.indexOf(",")!=-1){
											var nameArr = name.split(",")
										}
										var sc = statics.sc;//进球时比分
										var sid = statics.sid;
										var teamType = statics.teamType;//主队or客队
										var time = statics.time;//时间
										
										if(teamType==0){//主队
											if(eventType==0){//进球
												html +='<div class="timeleft"><span><em>'+name+'</em><cite class="jqico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==1){//点球
												html+='<div class="timeleft"><span><em>'+name+'</em><cite class="dqico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==2){//乌龙
												html+='<div class="timeleft"><span><em>'+name+'</em><cite class="wlico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==3){//黄牌
												html+='<div class="timeleft"><span><em>'+name+'</em><cite class="hpico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==4){//红牌
												html+='<div class="timeleft"><span><em>'+name+'</em><cite class="redpico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==5){//两黄变红牌
												html+='<div class="timeleft"><span><em>'+name+'</em><cite class="lhbhico"></cite></span><b>'+time+'′</b></div>';
											}else if(eventType==6){
												html+='<div class="timeleft timetwo"><span><strong>'+nameArr[0]+'<i>&darr;</i></strong><strong>'+nameArr[1]+'<i>&uarr;</i></strong></span><b>'+time+'&prime;</b></div>';
											}
										}else{
											if(eventType==0){//进球
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="jqico"></cite>'+name+'</span></div>';
											}else if(eventType==1){//点球
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="dqico"></cite>'+name+'</span></div>';
											}else if(eventType==2){//乌龙球
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="wlico"></cite>'+name+'</span></div>';
											}else if(eventType==3){//黄牌
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="hpico"></cite>'+name+'</span></div>';
											}else if(eventType==4){//红牌
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="redpico"></cite>'+name+'</span></div>';
											}else if(eventType==5){//两黄变红
												html+='<div class="timeright"><b>'+time+'&prime;</b><span><cite class="lhbhico"></cite>'+name+'</span></div>';
											}else if(eventType==6){
												html+='<div class="timeright timetwo timetwo2"><b>'+time+'&prime;</b><span><strong><i>&darr;</i>'+nameArr[0]+'</strong><strong><i>&uarr;</i>'+nameArr[1]+'</strong></span></div>'
											}
										}
									//}
								}
								if(cur_match.code==1||cur_match.code==2||cur_match.code==3){
									html+='<p class="timeIco">进行中</p>';
								}else if(cur_match.code==4){
									html+='<p class="timeIco">完赛</p>';
								}else{
									html+='<p class="timeIco">'+stMap[cur_match.code]+'</p>';
								}
								
								$("#bssj").html(html);
							}else{
								$("#bssj").html(nodata);
								$("#shijian").hide();
								$(".jstjList").hide()
								$(".jstjList").prev().find("em").addClass("down")
							}
						}
					},
					error:function(){
						$(".jstjList").html(nodata);
						$(".jstjList").hide()
						$(".jstjList").prev().find("em").addClass("down")
						$("#bssj").html(nodata);
					}
				})
			},
			
			//加载文字直播内容
			load_live_wzzb:function(){
				if(cur_match.code!="17" && cur_match.code!="15" && cur_match.code!="13"){
					window.zb = setInterval(function(){
						Model.live_zb();
					},1000)
				}else{
					$(".zbj2").html(nodata);
				}
			},
			
			//文字直播
			live_zb:function(){
				/***
				if(cur_match.code===17){//未开赛
					$(".zbj2").html("未开赛");
				}else{//开赛，完场
				***/
					$.ajax({
						async:false,
						url:'/zqjc/live/'+today+'/'+cur_match.sid+'.json?' + new Date().getTime(),
						type: 'GET',
						dataType: 'json',
						timeout: 1000,
						success: function(data){
							if(!data){
								$(".zbj2").html(nodata);
								return;
							}
							
							if(data.phrase && data.phrase.length>0){//存在文字直播
								var wzzb="";
								var phrases = data.phrase;
								var phrase ={};
								for(var i=0;i<phrases.length;i++){
									//phrase.color = i % 2 == 0? "" : "line_back";
									var time = phrases[i].time;
									var text = phrases[i].text;
									//段落加载
									//wzzb+='<li><cite>'+time+'</cite><span>'+text+'</span></li>'
									wzzb+='<li><cite>'+time+'′</cite><p>'+text+'</p></li>'
								}
								
								$(".zbj2").html(wzzb);
							}else{
								clearInterval(window.zb);
								$(".zbj2").html(nodata);
							}
						},
						error:function(){
							clearInterval(window.zb);
							$(".zbj2").html(nodata);
						}
					})
				//}
			},
			
			//段落加载
			load_phrase:function(obj){
				var type = obj["type"];
				var text = obj["text"];
				var time = obj["time"];
				var html = "";
					
				html='<li><cite>'+time+'</cite><span>'+text+'</span></li>';
				return html;
			},
			
			phb:function(){
				//var html=$("#dc_list").html();
				var html="";
				//单场排行
				var yzArr=[];
				var tempstr="";
				$.ajax({
					url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=4&phtype=s&mid="+cur_match.sid,
					dataType:'xml',
					//data:data,
					cache:true,
					success: function(xml) {
						var R = $(xml).find("Resp");
						var code = R.attr("code");
						var desc = R.attr("desc");
						
						var phrecords = R.find("phrecords");
						var total = phrecords.attr("total");//总条数
						var tpage = phrecords.attr("tpage");//总页数
						
						var row = phrecords.find("row");
						
						var dcphinfo = R.find("dcphinfo");
						var d_code=dcphinfo.attr("code");
						var d_desc=dcphinfo.attr("desc");

						if(d_code==0){
							var d_jdyl=dcphinfo.attr("jdyl");
							if(d_jdyl>0){
								$(".red").html(d_jdyl);
							}else{
								$(".red").html(0);
							}
						}else{
							$("#ly").hide();
						}
						
						if(code==0){
							if(row.length){
								row.each(function(i){
									var c = i%2==0?"graybg":"";
									var uname = $(this).attr("uname");
									var rank = $(this).attr("rank");
									var jdtr = $(this).attr("jdtr");
									var jdjl = $(this).attr("jdjl");
									var jdyl = $(this).attr("jdyl");
									var jccs = $(this).attr("jccs");
									var mzcs = $(this).attr("mzcs");
									var hbjl = parseInt($(this).attr("hbjl"));
									var ispj = $(this).attr("ispj");
									
									
									if(ispj==1){
										yzArr.push(ispj);
									}
									html+='<ul class="'+c+'">';
									if(rank==1 || rank==2 || rank==3){
										html+='<li><em>'+rank+'</em></li>';
									}else{
										html+='<li>'+rank+'</li>';
									}
									
									html+='<li>'+uname+'</li>';
									html+='<li>'+jdyl+'</li>';
									html+='<li>'+hbjl+'</li>';
									html+='</ul>';
								})
								
								$("#dc_list_cont").html(html)
								if(yzArr.length>=10){
									$("#yz").show();
								}else{
									$("#yz").hide();
								}
								
								if(cur_match.isRank==1){
									$("#ul_header li:last").show();
									$("#dc_list_cont ul li:last").show();
								}else{
									$("#dc_list_cont ul").find("li:last").hide();
									$("#ul_header li:last").hide();
									$("#dc_list").addClass("list2");
								}
								
								$(".lastts").show();
								$("#dc_list ul:first").show();
							}else{
								var tmpHTML=""
									tmpHTML+='<ul class="graybg">'
									tmpHTML+='<li><em>1</em></li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>288</li>'
									tmpHTML+='</ul>'
									tmpHTML+='<ul>'
									tmpHTML+='<li><em>2</em></li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>188</li>'
									tmpHTML+='</ul>'
									tmpHTML+='<ul class="graybg">'
									tmpHTML+='<li><em>3</em></li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>&nbsp;</li>'
									tmpHTML+='<li>88</li>'
									tmpHTML+='</ul>'
								var tmpHTML2="";
									for(var i=0;i<7;i++){
										tmpHTML2+='<ul class="'+(i%2==0?"":"graybg")+'"><li>'+(i+4)+'</li><li>&nbsp;</li><li>&nbsp;</li><li>38</li></ul>';
									}
									
								if(cur_match.isRank==1){
									$("#dc_list_cont").html(tmpHTML+tmpHTML2);
									$("#dc_list ul:first").show();
								}else{
									$("#dc_list_cont").html(nodata);
									//$("#dc_list ul:first").hide();
									//$("#dc_list").addClass("list2");
								}
							}
						}else{
							alert(desc);
						}
					},
					error:function(){
						$("#dc_list").html(nodata);
					}
				})
			}
			
	}
	
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	}
	
	 //确认竞猜
	var confirmQuiz=function(){
		var data=dodata;
		$.ajax({
			url:"/grounder/fbuyviagoldenbean.go",
			dataType:'xml',
			data:data,
			cache:true,
			success: function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==0){//投注成功
					alert("参与竞猜成功");
					$("#tzCont").hide();
					$(".mask").hide();
					quiz.getGolden();
					//$("#qrjc").html("确认竞猜");
				}else if(code==1){
					window.location.href="login.html";
				}else{
					alert(desc);
				}
			}
		});
	}
	
	
	
	var bindEvent=function(){
		$(".up").bind("click",function(){
			$(this).parent().next().toggle();
			$(this).toggleClass("down");
		});
		
		
		
		$("#help").bind("click",function(){
			window.localtion.href("wfgz.html");
		});
	
		
		
		
		$(".gqnav span").bind("click",function(){
			var index=$(this).index();
			
			if(index!=2){
				window.clearInterval(window.zb)
			}else{
				Model.load_live_wzzb()
			}
			
			if(index==4){
				Model.phb();
			}
			$(this).addClass("cur").siblings().removeClass("cur");
			$("article.nav_cont:eq("+index+")").show();
			$("article.nav_cont:eq("+index+")").siblings("article.nav_cont").hide();
		});
		
		
		//积分切换
		$("#tzCont ul li:not(:first)").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur")
			setTimeout(function(){
				$("#tzCont ul li").removeClass("cur")
			},100);
			var num = parseInt($("#in_golden").val())||0;
			var remain_jd = parseInt(delFH($("#jdyue").html()));
			var v = $(this).html();
			if(v=="全押"){
				if(remain_jd>500000){
					alert("单次竞猜最大投入500000金豆");
					$("#in_golden").val(500000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				$("#sjd").hide();
			}else{
				if(parseInt(v)+num>500000){
					alert("单次竞猜最大投入500000金豆");
					$("#in_golden").val(500000);
				}else{
					if(remain_jd>parseInt(v)+num){
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").hide();
					}else{
						$("#in_golden").val(parseInt(v)+num);
						$("#sjd").show();
					}
				}
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			if(newnum>500000){
				alert("单次竞猜最大投入500000金豆");
				return;
			}
			
			var pl = $("#pkCont cite").text();
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));

			
			
		});
		
		
		$("#in_golden").blur(function(){
			var v = $(this).val();
			if(!v || v==""){
				$(this).val(50);
				//$(this).next().hide();
			}
		});
		
		//返还值
		$("#in_golden").keyup(function(){
			var v = parseInt($(this).val())||0;
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			if(!v){
				$("fh").html(0);
			}else if(v>500000){
				$("#in_golden").val(500000)
				alert("单次竞猜最大投入500000金豆");
			}else{
				$("#fh").html(Math.ceil(v*pl));
				$("#sjd").hide();
			}
		});
		
		
		
		
		//确认竞猜
		$(".qrjc").bind("click",function(){
			var remain_jd = delFH($("#jdyue").html());
			var tMoney=parseInt($("#in_golden").val())||0;
			
			var type = $("#tzCont").attr("type");
			var opt = $("#tzCont").attr("opt");
			var curCode = $("#tzCont").attr("curCode");
			var oddsid = $('#ks ul[type="'+type+'"][curCode="'+curCode+'"]').attr('oddsid');
			
			dodata.oddsid=oddsid;
			dodata.itmoney=tMoney;
			
			if(!tMoney){
				alert("输入金豆");
				return;
			}
			
			if(tMoney<50){
				alert("请至少输入50个金豆")
				return;
			}
			
			if(remain_jd>=tMoney){
				confirmQuiz();
			}else{
				$("#sjd").show();
			}
			
		});
		
		
		//关闭购买层
		
		$("#tzCont b").bind("click",function(){
			$("#tzCont").hide();
			$(".mask").hide();
		});
		
		
		$('#scroller span').bind("click",function(){
			var dValue = $("#popup2 .nr").defaultValue;
			D.sendConfirm(function(){
				$("#popup2 .nr").val(dValue);
			}, function(){
				var str = $("#popup2 .nr").val();
				str = $.trim(str);
				if(!str){
					alert("内容不能为空");
					return;
				}
				
				
				chat.sendMsg();
			})
			$("#popup2 .nr").focus();
		})
		
		
		
		//获得金豆
		$("#obtain").bind("click",function(){
			window.location.href="hdjd.html"
		})
		
		
	};
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	//初始化
	var init = function(){
		if(CP.MobileVer.android){//android
			try {
				dodata.mtype=1;
			} catch (e){
				
			}
		}else if(CP.MobileVer.ios || CP.MobileVer.ipad){//ios
			try {
				dodata.mtype=2;
			} catch (e){
				
			}
		}else if(CP.MobileVer.wp){//ios
			try {
				dodata.mtype=3;
			} catch (e){
				
			}
		}else{//4g
			dodata.mtype=4;
		}
		
		remove_header();
		//判断是否有加奖
		if(cur_match.isRank==1){//有加奖
			$(".gqnav span:last em").addClass("jjico");
		}
		
		chat.init();
		quiz.getGolden();
		//talk.initCore();
		o.node();
		
		
		bindEvent()
		Model.loadData()
	};
	
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
})