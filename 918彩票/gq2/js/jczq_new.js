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

//当前比赛对象
var cur_match={};
cur_match = JSON.parse(localStorage.getItem("cur_match"));

//连接池对象
var socket;
var tt_ = 0;
var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="img/lqend.png" width="200" heigth="200"></figure><p>暂无数据</p></article>';
XHC.JCZQ=(function(){
	var today="";
	var date = new Date();
	var y = date.getFullYear();
	var m = date.getMonth()+1;
	m = m<10?"0"+m:m;
	var d = date.getDate();
	d = d<10?"0"+d:d;
	today=y.toString()+m.toString()+d.toString();
	
	var stMap={'17':'未开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'}
	
	$(function(){
		var t = cur_match.itemId;
		if(t==0){
			t="ZC"+cur_match.sid;
		}
		/***
		$.ajax({
			type: 'post',
			async: false,
			//url: 'http://mobile.9188.com  /trade/chathomepage.go',
			url: '/trade/chathomepage.go',
			dataType: 'xml',
			data:{itemid: t, bdStage: null,sort: null},
			success : function(xml) {
				var row = $(xml).find('row');
				chat.rid = row.attr('rid');
				chat.roomId = row.attr('convid');
			}
		});
		***/
		update_header(cur_match);//更新头部方法
		news_cont();
	});
		
	//更新头部比分
	var update_header=function(obj){
		$("#update li:eq(0)").html('<span>'+obj.hn.substring(0,5)+'</span><cite>'+(obj.hr?'['+obj.hr+']':"")+'</cite>')
		$("#update li:eq(1)").html('<strong>'+(obj.hsc?obj.hsc:"0")+':'+(obj.gsc?obj.gsc:"0")+'</strong><cite>'+stMap[obj.code]+'</cite>')
		$("#update li:eq(2)").html('<span>'+obj.gn.substring(0,5)+'</span><cite>'+(obj.gr?'['+obj.gr+']':"")+'</cite>')
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
							
							tt_=st;
							var hsc = $(this).attr("hsc");
							var gsc = $(this).attr("gsc");
							var hrd = $(this).attr("hrd");
							var grd = $(this).attr("grd");
							var halfScore = $(this).attr("halfScore");//半场比分
//'17':'未开赛','1':'上半场','2':'中场','3':'下半场','4':'完场','5':'中断','8':'加时','11':'点球','13':'延期','14':'腰斩','15':'待定'							
							cur_match["code"]=code;//更新状态
							
							if(code==17 ||code==5 ||code==13 ||code==14 ||code==15||code==4){
								clearInterval(window.ud);//清除定时调用
								$("#update li:eq(1)").html('<strong>'+(obj.hsc?obj.hsc:"0")+':'+(obj.gsc?obj.gsc:"0")+'</strong><cite>'+stMap[obj.code]+'</cite>')
							}else{
								st = parseInt((n_-htime)/60000);
								if(code==1){//上
									st=st<=45?st:45+"+";
									st+='<em class="fen">\'</em>';
								}else if(code==2){//中
									st="";
								}else if(code==3){//下
									st=st<=45?(45+st):(90+"+");
									st+='<em class="fen">\'</em>';
								}
								$("#update li:eq(1)").html('<strong>'+hsc+':'+gsc+'</strong><cite>'+stMap[code]+"&nbsp;<b>"+st+'</b></cite>')
							}
							//$("#update li:eq(1)").html('<strong>'+hsc+':'+gsc+'</strong><cite>'+stMap[code]+"&nbsp"+((stMap[code]==17||stMap[code]==13||stMap[code]==14||stMap[code]==15)?"":st)+'</cite>')
						}
					});
				}
			});
		},1000);
	};
	
	
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
							
							a<10 && (html+='<li>'+strtime+'&nbsp;<cite>'+cnickid+'</cite>兑换了<em>'+itemRemark+'</em></li>')
							
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
	
	//服务器端推送过来数据
	var o = {//公用的对象
		node : function(){
			socket = io.connect('210.14.67.5:8186');//210.14.67.5:8186  192.168.1.240:8185
			socket.emit('changeMid',cur_match["sid"]);//建立网络连接
			
			//加载数据
			socket.on('loadMatch', function(data){
				quiz.render(data)
			});
			
			//有变化的赔率(被动推送) 	进球或让球对象
			socket.on('changeNode', function(data){
				if(data['mid'] == cur_match.sid){
					option.showChangeOdds(data);
				}
			});
			
			//截止推送
			socket.on('stopNode', function(data){
				if(data.rq && data.rq.mid == cur_match.sid || data.jqs && data.jqs.mid == cur_match.sid || data.single_jqs && data.single_jqs.mid == cur_match.sid){
					option.stopNode(data);	
				}
			});
			
			//比赛开停售(比赛页面是否显示)
			socket.on('matchNode', function(data){
				quiz.render(data);
			});
			
			//赛果推送
			socket.on('resultNode', function(data){
				quiz.render(data);
			});
		}
	};
	
	//盘口变化时需调用的方法
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
				}else {//大小球
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
						}else {
							single_codeStr = this.getPanStr(data.instantDxf, 2);
						}
						$('#ks ul[type="2"][curCode="1"]').attr('oddsid', data.id);
						$('#ks ul[type="2"][curCode="1"] li[opt="3"] cite').text(data.htDOdds);
						$('#ks ul[type="2"][curCode="1"] li[opt="0"] cite').text(data.vtDOdds);
						$('#ks ul[type="2"][curCode="1"] li.mid').text(single_codeStr);
					}
				}
			},
			
			//截止方法
			stopNode: function(data){
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
		};
	
	
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
					
					var rqpan = rq.startPan||rq.instantPan;
					var dxpan = jqs.startDxf||jqs.instantDxf;
					var single_dxpan = single_jqs.startDxf||single_jqs.instantDxf;
					
					//让球及时盘
					if (rq.status == 1) {
						rqpan = rq.instantPan;
					}
					//大小球及时盘(全场)
					if (jqs.status == 1) {
						dxpan = jqs.instantDxf;
					}
					
					//大小球及时盘(半场)
					if (single_jqs.status == 1) {
						single_dxpan = single_jqs.instantDxf;
					}
					
					//开售让球
					var rqCodeStr = '<p>猜<cite class="red">全场</cite>让球胜负</p>';
						rqCodeStr += '<ul  oddsid="'+rq.id+'" type="1" cperiodid="'+rq.mid+'" curCode="'+rq.curCode+'">';
						rqCodeStr += '<li opt="3"><span>主胜</span><cite>'+rq.htPOdds+'</cite></li>';
						rqCodeStr += '<li class="mid">';
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
					
					//停售大小球(半场)
					var p_single_jqjzCodeStr='<p>猜上半场总进球（暂停投注）<b></b></p><ul type="2" curCode="1"><li><span>上半场总进球</span><cite class="red">等待开奖</cite></li></ul>';
					
					//停售大小球
					var p_jqjzCodeStr='<p>猜全场总进球（暂停投注）</p><ul type="2" curCode="0"><li><span>全场总进球</span><cite class="red">等待开奖</cite></li></ul>';
					
					//停售让球
					var p_rqjzCodeStr='<p>猜全场让球（暂停投注）</p><ul type="1" curCode="0"><li><span>'+jqs.hTName+' VS '+jqs.vTName+'</span><cite class="red">等待开奖</cite></li></ul>'
					
					
					
					$("#ks").html("");
					$("#jz").html("");
					
					/***
					if(single_jqs.position==1){
						$("#ks").append(single_jqCodeStr);
					}else{
						if(cur_match.code==1||cur_match.code==2||cur_match.code==3){
							$("#jz").append(p_single_jqjzCodeStr);
						}else{
							$("#jz").append(single_jqjzCodeStr);
						}
					}
					***/
					if(single_jqs.position==1){
						$("#ks").append(single_jqCodeStr);
					}else{
						if( single_jqs.position==2  && jqs.position==2  &&  rq.position==2 && (cur_match.code==1 || cur_match.code==2 || cur_match.code==3) && (tt_<35) ){
							$("#jz").append(p_single_jqjzCodeStr);
						}else{
							if(single_jqs.position==0){
								$("#jz").append('');
							}else{
								$("#jz").append(single_jqjzCodeStr);
							}
							
						}
					}
					

					/***
					if(jqs.position==1){
						$("#ks").append(jqCodeStr);
					}else{
						$("#jz").append(jqjzCodeStr);
					}
					***/
					
					
					if(jqs.position==1){
						$("#ks").append(jqCodeStr);
					}else{
						if( single_jqs.position==2  && jqs.position==2  &&  rq.position==2 && (cur_match.code==1 || cur_match.code==2 || cur_match.code==3) && (tt_<35) ){
							$("#jz").append(p_jqjzCodeStr);
						}else{
							if(jqs.position==0){
								$("#jz").append('');
							}else{
								$("#jz").append(jqjzCodeStr);
							}
						}
					}
					
					
					/***
					if(rq.position==1){
						$("#ks").append(rqCodeStr);
					}else{
						$("#jz").append(rqjzCodeStr);
					}
					***/
					
					
					if(rq.position==1){
						$("#ks").append(rqCodeStr);
					}else{
						if( single_jqs.position==2  && jqs.position==2  &&  rq.position==2 && (cur_match.code==1 || cur_match.code==2 || cur_match.code==3) && (tt_<35) ){
							$("#jz").append(p_rqjzCodeStr);
						}else{
							if(rq.position==0){
								$("#jz").append('');
							}else{
								$("#jz").append(rqjzCodeStr);
							}
						}
					}
					//总进球(半场)
					data.single_htScore && $("#jz ul[type=2][curCode=1] li").html('<span>猜上半场总进球大小</span><cite class="red">'+(parseInt(data.single_htScore)+parseInt(data.single_vtScore))+'</cite><i></i>')
					
					//总进球(全场)
					data.htScore && $("#jz ul[type=2][curCode=0] li").html('<span>猜全场总进球大小</span><cite class="red">'+(parseInt(data.htScore)+parseInt(data.vtScore))+'</cite><i></i>');
					
					//让球
					(data.htScore || data.htScore==0) && $("#jz ul[type=1][curCode=0] li").html('<span>'+cur_match.hn+' VS '+cur_match.gn+'</span><cite class="red">'+data.htScore+'-'+data.vtScore+'</cite><i></i>');
					
					P.betting_fn();//投注方法
				}
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
				});
			}
	};
	
	//当前比赛排行榜
	var phb_module={
			phb:function(){
				//var html=$("#dc_list").html();
				var html="";
				//单场排行
				var yzArr=[];
				var tempstr="";
				$.ajax({
					url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=4&phtype=s&mid="+cur_match.sid,
					dataType:'xml',
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
								});
								
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
								}
							}
						}else{
							alert(desc);
						}
					},
					error:function(){
						$("#dc_list").html(nodata);
					}
				});
			}
	};
	
	
	//比赛数据信息
	var gameInfo_module={
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
											}else if(eventType==6){//换人
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
			}
	};
	
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	};
	
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
	};
	
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
			},
			//去掉逗号
			delFH : function(str){
				str = str.replace(/,/g,'');
				return str;
			},
			//确认竞猜
			confirmQuiz:function(){
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
							quiz.getGolden();//重新加载金豆
							$("#in_golden").val(50);
						}else if(code==1){
							window.location.href="login.html";
						}else if((code==-1 || code==2) && ((!isNaN(desc)))){
							alert("您本场比赛最多还可以投注"+desc+"金豆");
						}else{
							alert(desc);
						}
					}
				});
			}
	}
	
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	}
	
	var bindEvent=function(){
		$(".up").bind("click",function(){
			$(this).parent().next().toggle();
			$(this).toggleClass("down");
		});
		
		$(".jsbfTitle").bind("click",function(){
			$(this).next().toggle();
			$(this).find("em").toggleClass("down");
		});
		
		//模块切换
		$(".gqnav span").bind("click",function(){
			var index=$(this).index();
			
			
			if(index==2){
				phb_module.phb();
			}
			
			if(index==1){
				gameInfo_module.loadData();
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
				if(remain_jd>2000000){
					alert("单次竞猜最大投入200万金豆");
					$("#in_golden").val(2000000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				$("#sjd").hide();
			}else{
				if(parseInt(v)*10000+num>2000000){ //+10万 改成汉字加10万了
					alert("单次竞猜最大投入200万金豆");
					$("#in_golden").val(2000000);
				}else{
					if(remain_jd>=parseInt(v)*10000+num){
						$("#in_golden").val(parseInt(v)*10000+num);
						$("#sjd").hide();
					}else{
						$("#in_golden").val(parseInt(v)*10000+num);
						$("#sjd").show();
					}
				}
			}
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			if(newnum>2000000){
				alert("单次竞猜最大投入200万金豆");
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
			}else if(v>2000000){
				$("#in_golden").val(2000000)
				alert("单次竞猜最大投入200万金豆");
			}else{
				$("#fh").html(Math.ceil(v*pl));
				$("#sjd").hide();
			}
			
			var jdyue=$("#jdyue").html();//显示隐藏余额不足			
			if(parseInt(jdyue)<parseInt($("#in_golden").val())){
				$("#sjd").show();
			}else{
				$("#sjd").hide();
			}			
			
		});
		
		//确认竞猜
		$(".qrjc").bind("click",function(){
			var remain_jd = P.delFH($("#jdyue").html());
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
				P.confirmQuiz();
			}else{
				$("#sjd").show();
			}
		});
		
		
		//关闭购买层
		$("#tzCont b").bind("click",function(){
			$("#tzCont").hide();
			$(".mask").hide();
		});
		
		//暂停投注的提示
		$("#jz").delegate("p:first b","click",function(){
			$(".jcpop").show();
			$("#zhezhao").show();
		})
		
		$(".jcpop div.ture").bind("click",function(){
			$(".jcpop").hide();
			$("#zhezhao").hide();
		});
		
		//获得金豆
		$("#obtain").bind("click",function(){
			window.location.href="hdjd.html"
		})
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
		P.getGolden();
		//gameInfo_module.loadData();
		bindEvent();
		//update_header(cur_match);//更新头部方法
		o.node();
	};
	
	return {
		init:init
	}
})()

$(function(){
	XHC.JCZQ.init();
})
