var XHC={};
var game_info={}
var item="";//存放资料库id

var url = window.location.href;
if(url.indexOf("?")!=-1){
	item = url.split("?")[1];
}

var tmp_data = JSON.parse(localStorage.getItem("tmp_data"));
sign_up_success_param.periodid=tmp_data.periodid;


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


XHC.JCLQ=(function(){
	var nodata='<article class="list" style="display:"><article class="lqend" style="display: ;"><figure><img align="" src="/gq2/img/nodatalq.png" width="200" height="200"></figure><p>暂无数据</p></article>';
	var d = new Date();
	var y = d.getFullYear();
	var m1 = d.getMonth()+1;
	m1=m1<10?"0"+m1:m1;
	var day =d.getDate();
	day=day<10?"0"+day:day;
	var P1 = y+""+m1+""+day;
	
	//比赛状态
	var st={
			 '0': '开赛',
		    '13': '第一节',
		    '14': '第二节',
		    '15': '第三节',
		    '16': '第四节',
		    '20': '进行中',
		    '30': '暂停',
		    '31': '第二节',
		    '32': '中场',
		    '33': '第四节',
		    '34': '加时',
		    '35': '加时',
		    '40': '加时',
		    '60': '延期',
		    '61': '推迟开赛',
		    '70': '取消',
		    '80': '中断',
		    '90': '弃赛',
		    '100': '已完赛',
		    '110': '已完赛'
		};
	
	/***
	//投注所需要的参数对象
	var dodata={
			mtype:4,//终端类型 no
			appversion:"",//客户端版本号，触屏可为空
			ccodes:3,//投注内容  3/0
			cperiodid:"",//期次编号
			cquizname:"",//竞猜名称
			itmoney:0,//投注金额
			oddsid:"",//盘口赔率表id
			section:5,//投注节数 第1，2，3，4节，或5-全场
			type:2,//玩法让分 1，总分 2，奇偶 3
			hTName:game_info.hn,//主队名
			vTName:game_info.gn//客队名称
	};
	***/
	
	
	
	//投注参数对象
	var dodata={
			mtype:"4",//终端类型
			appversion:"",//客户端版本号
			itmoney:"",//投注金额
			opt:"",//投注选项  0-主负   3-主胜
			oddsid:"",//赔率id
			type:"",
			curCode:"",
			
			matchid:game_info.mid,
			flag:6,
			gameid:2,//场次id
			periodid:tmp_data.periodid,
	};
	
	$(function(){
		$.ajax({
			url:"/nbajc/matchs/"+P1+"/"+item+".json?"+Math.random(),
			dataType:'json',
			cache:true,
			success:function(data){
				var t_ ={};
				
				var g1 = data["g1"];
				var g2 = data["g2"];
				var g3 = data["g3"];
				var g4 = data["g4"];
				var h1 = data["h1"];
				var h2 = data["h2"];
				var h3 = data["h3"];
				var h4 = data["h4"];
				var gjs = data["gjs"];//客队加时阶段比分
				var hjs = data["hjs"];//主队加时阶段比分
				var mtime = game_info.mtime = data["mtime"];//开始时间
				var mid = dodata.matchid=game_info.mid = data["mid"];//主站赛事id
				var gr = game_info.gr = data["gr"];//客队排名
				var hr = game_info.hr = data["hr"];//主队排名
				var gn = game_info.gn = data["gn"];//客队名称
				var hn = game_info.hn = data["hn"];//主队名称
				var gid = game_info.gid = data["gid"];//客队id
				var hid = game_info.hid = data["hid"];//主队id
				
				
				
				
				t_.statusCode = data["statusCode"];
				t_.hsc = data["hsc"];//主队比分
				t_.gsc = data["gsc"];//客队比分
				t_.id = data["id"];//比赛id
				t_.mtime = data["mtime"];//倒计时器
				t_.time = data["time"];//倒计时器
				
				gain(t_);
				
				//var socket = io.connect('192.168.1.240:8185');//210.14.67.5:8185  192.168.1.240:8185
				socket.emit('changeMid',game_info.mid);//建立网络连接
				o.node();
				
				phb();
				// 加载聊天室选项
    			$('body').bind('initChat', function(){
    				
    				/***
    				chat.room && chat.room.leave();
    				chat.rt && chat.rt.close();
    				***/
    				var t = "LQ"+game_info.mid
    				
    				$.ajax({
    					type: 'post',
    					async: false,
//    					url: 'http://mobile.9188.com  /trade/chathomepage.go',
    					url: '/trade/chathomepage.go',
    					dataType: 'xml',
    					data:{itemid: t, bdStage: null,sort: null},
    					success : function(xml) {
    						var row = $(xml).find('row');
    						
    						chat.rid = row.attr('rid');
    						chat.roomId = row.attr('convid');
    						//chat.roomId = '5575f1cde4b06a320970e7f2';
    						
    					}
    				});
    			});
    			$('body').trigger('initChat');
    			chat.init();
    			
    			if(game_info.isRank==1){//有加奖
    				$(".gqnav span:last em").addClass("jjico");
    			}
				$("#jcbf1 li:eq(1) span").html(game_info.gn.substr(0,4));//客队名称
				$("#jcbf1 li:eq(2) span").html(game_info.hn.substr(0,4));//客队名称
				$("#update li:eq(0)").html(game_info.gn);
				$("#update li:eq(2)").html(game_info.hn)
				$("#jcbf1 li:eq(1) cite:eq(0)").html(g1?g1:"&nbsp;");
				$("#jcbf1 li:eq(2) cite:eq(0)").html(h1?h1:"&nbsp;");
				$("#jcbf1 li:eq(1) cite:eq(1)").html(g2?g2:"&nbsp;");
				$("#jcbf1 li:eq(2) cite:eq(1)").html(h2?h2:"&nbsp;");
				$("#jcbf1 li:eq(1) cite:eq(2)").html(g3?g3:"&nbsp;");
				$("#jcbf1 li:eq(2) cite:eq(2)").html(h3?h3:"&nbsp;");
				$("#jcbf1 li:eq(1) cite:eq(3)").html(g4?g4:"&nbsp;");
				$("#jcbf1 li:eq(2) cite:eq(3)").html(h4?h4:"&nbsp;");
				$("#jcbf1 li:eq(1) cite:eq(5)").html(t_.gsc?t_.gsc:"&nbsp;");
				$("#jcbf1 li:eq(2) cite:eq(5)").html(t_.hsc?t_.hsc:"&nbsp;");
				
				
				if(t_.statusCode==0){
					$("#jcbf1 li:eq(0) cite:eq(4)").hide();
					$("#jcbf1 li:eq(1) cite:eq(4)").hide();
					$("#jcbf1 li:eq(2) cite:eq(4)").hide();
					
					$("#jcbf1").removeClass("sjtj1");
				}else {
					if(gjs || hjs){
						$("#jcbf1").addClass("sjtj1");
						$("#jcbf1 li:eq(0) cite:eq(4)").show();
						$("#jcbf1 li:eq(1) cite:eq(4)").show();
						$("#jcbf1 li:eq(2) cite:eq(4)").show();
						$("#jcbf1 li:eq(1) cite:eq(4)").html(gjs?gjs:"&nbsp;");
						$("#jcbf1 li:eq(2) cite:eq(4)").html(hjs?hjs:"&nbsp;");
					}else{
						$("#jcbf1 li:eq(0) cite:eq(4)").hide();
						$("#jcbf1 li:eq(1) cite:eq(4)").hide();
						$("#jcbf1 li:eq(2) cite:eq(4)").hide();
						$("#jcbf1").removeClass("sjtj1");
					}
				}
				$(".hmHeader h1").html(gn+"vs"+hn)
				if(t_.statusCode!=100){
					//及时调用头部(5s)
	    			_timeId=setInterval(function(){
	    				$.ajax({
	    					url:"/nbajc/matchs/change.xml?"+Math.random(),
	    					dataType:'xml',
	    					cache:true,
	    					success: function(xml) {
	    						var R = $(xml).find("Rows");
	    						var row = R.find("row");
	    						if(row.length){
	    							row.each(function(){
	    								var t = {};
	    								t.id = $(this).attr('id');
		    				    		if(item==t.id){//改变当前比赛的比分
			    							t.mid = $(this).attr('mid');
			    							t.statusCode = $(this).attr('code');
			    							t.hs = $(this).attr('hs');//当前节主队比分
			    				    		t.gs = $(this).attr('gs');
			    				    		t.hsc = $(this).attr('hsc');
			    				    		t.gsc = $(this).attr('gsc');
			    				    		t.time = $(this).attr('time');//倒计时器
		    								if(t.statusCode==100){
		    									clearInterval(_timeId);//清楚定时器
		    								}else{
		    									gain(t);
		    									
		    									var tt = {13:'0',14:'1',15:'2',16:'3',40:"4"}[t.statusCode];
		    									if(t.statusCode==40){
		    										$("#jcbf1").addClass("sjtj1");
		    										$("#jcbf1 li:eq(0) cite:eq(4)").show();
		    										$("#jcbf1 li:eq(1) cite:eq(4)").show();
		    										$("#jcbf1 li:eq(2) cite:eq(4)").show();
		    									}
		    									$("#jcbf1 li:eq(1) cite:eq("+tt+")").html(t.gs?t.gs:"&nbsp;");
		    									$("#jcbf1 li:eq(2) cite:eq("+tt+")").html(t.hs?t.hs:"&nbsp;");
		    									$("#jcbf1 li:eq(1) cite:eq(5)").html(t.gsc?t.gsc:"&nbsp;");
		    									$("#jcbf1 li:eq(2) cite:eq(5)").html(t.hsc?t.hsc:"&nbsp;");
		    								}
		    				    		}
		    						})
	    						}
	    					}
	    				});
	    			},5000)
				}
				
			},
			error:function(){
			//	alert("网络异常,请刷新后重试2")
			}
		});
	});
	
	var gain=function(game_info){
		//初始化头部
		if(game_info.statusCode==0){
			$("#update li:eq(1)").html('<strong>--</strong><cite>'+st[game_info.statusCode].substring(0,3)+'</cite>')
		}else{
			$("#update li:eq(1)").html('<strong>'+(game_info.gsc?game_info.gsc:"0")+':'+(game_info.hsc?game_info.hsc:"0")+'</strong><cite>'+st[game_info.statusCode].substring(0,3)+'  '+game_info.time+'</cite>')
		}
	};
	
	var socket = io.connect('210.14.67.5:8185');//210.14.67.5:8185  192.168.1.240:8185
	//socket.emit('changeMid',68436);//建立网络连接68436
	var o = {//公用的对象
		node : function(){
			socket.on('loadMatch', function(arr){//拉取单场全部赔率(主队请求)
				quiz.render(arr);
			});
			socket.on('changeNode', function(data){//有变化的单节赔率(被动推送)
				if(data.mid == game_info.mid){
					changeText(data);
				}
			});
			socket.on('stopNode', function(data){//单节有截止的赔率(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					stopNode(data);	
				}
			});
			socket.on('startNode', function(data){//单节开始的赔率(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					startNode(data);	
				}
			});
			socket.on('resultNode', function(data){//单节赛果(被动推送)
				var data = data;
				if(data.mid == game_info.mid){
					resultNode(data)
				}
			});
			
			socket.on('differenceNode', function(mid){//单节赛果(被动推送)
				if(mid == game_info.mid){
					socket.emit('changeMid', mid);
				}
			});
			
			socket.on('reLoadNode', function(arr){
				quiz.render(arr);
			});
		    }
		};
	
	//赔率有改变时
	var changeText=function(data){
		
		var rf1=0;
		var rf2=0;
		var base = Math.abs(data.rf);
		
		if (parseFloat(data.rf) > 0) {
			rf1 = '-' + base;
			rf2 = '+' + base;
			color1 = 'green';
			color2 = 'red';
		} else {
			rf1 = '+' + base;
			rf2 = '-' + base;
			color1 = 'red';
			color2 = 'green';
		}
		
		$('#options ul[node="'+data.node+'"] .zf').text(data.zf);//更新总分
		$('#options ul[node="'+data.node+'"] li[opt="0"] .rf').text("("+rf1+")");//跟新让分
		$('#options ul[node="'+data.node+'"] li[opt="3"] .rf').text("("+rf2+")");//跟新让分
		
		$('#options ul[node="'+data.node+'"] li[opt="3"] .rf').removeClass('red green').addClass(color2);
		$('#options ul[node="'+data.node+'"] li[opt="0"] .rf').removeClass('red green').addClass(color1);
		
		$('#options ul[node="' + data.node + '"][typename="2"]').attr('code', data.zf);
        $('#options ul[node="' + data.node + '"][typename="1"]').attr('code', '('+data.rf+')');
        $('#options ul[node="' + data.node + '"][typename="2"]').attr('oddsid', data.id2);
        $('#options ul[node="' + data.node + '"][typename="1"]').attr('oddsid', data.id1);
        $('#options ul[node="' + data.node + '"][typename="3"]').attr('oddsid', data.id1);
        $('#options ul[node="' + data.node + '"][typename="2"] li[opt="3"] cite').text(data.hzo);
        $('#options ul[node="' + data.node + '"][typename="2"] li[opt="0"] cite').text(data.gzo);
        $('#options ul[node="' + data.node + '"][typename="1"] li[opt="3"] cite').html("胜"+data.hro);
        $('#options ul[node="' + data.node + '"][typename="1"] li[opt="0"] cite').html("胜"+data.gro);
		
	};
	
	//让分截止
	var differenceNode=function(data) {
		$('#options ul[typeName="1"]').remove().map(function(){
			$(this).prev().remove();
			var node=$(this).attr("node");
			
			if(node == 5){
				jie = '全场';
			}else{
				jie = '【第<cite class="red">'+node+'</cite>节】';
			}
			
			//var difference = data.difference;
			var m1=m2=m3="等待开奖";
			var c="";
			var c1="";
			if(htScore){
				var hsc = data["htScore"];
				var gsc = data["vtScore"];
				
				m1=gsc+":"+hsc;
				m2=parseInt(hsc)+parseInt(gsc);
				c="<i></i>";
				c1="red";
			}
    		$('#endOption').append('<p>猜'+jie+'让分胜负</p><ul>\
					<li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li>\
					</ul>');
		});

	};
	
	//单节截止了让分,基偶,大小
	var stopNode=function(data){
		if(data.node == 5){
			jie = '全场';
		}else{
			jie = '【第<cite class="red">'+data.node+'</cite>节】';
		}
		
		var htScore = data.htScore;
		var m1=m2=m3="等待开奖";
		var c="";
		var c1="";
		if(htScore){
			var hsc = data["htScore"];
			var gsc = data["vtScore"];
			
			m1=gsc+":"+hsc;
			m2=parseInt(hsc)+parseInt(gsc);
			m3=m2%2==0?"偶":"奇";
			c="<i></i>";
			c1="red";
		}
		
		if(data.type == 1){//截止了让分、基偶
			$('#options ul[node="'+data.node+'"][typename!="2"]').prev("p").remove()
			$('#options ul[node="'+data.node+'"][typename!="2"]').remove();//截止了让分，奇偶
			
			$('#endOption').append('<p>猜'+jie+'让分胜负</p><ul>\
					<li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li>\
					</ul>');
			$('#endOption').append('<p>猜'+jie+'总分奇偶</p><ul>\
					<li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m3+'</cite>'+c+'</li>\
					</ul>');
		}else{
			$('#options ul[node="'+data.node+'"][typename="2"]').prev().remove()
			$('#options ul[node="'+data.node+'"][typename="2"]').remove();//截止了总分大小
			$('#endOption').append('<p>猜'+jie+'总分大小</p><ul>\
					<li><span>两队总分之和</span><cite class="'+c1+'">'+m2+'</cite>'+c+'</li>\
					</ul>');
		}
		$('#options ul').length || $('#options').hide();
	};
	//单节开始
	var startNode=function(data){
		//data.playName = data.nodeName = '全场';
		var difference = data.difference;
		if(data.node == 5){
			jie = '全场';
		}else{
			jie = '【第<cite class="red">'+data.node+'</cite>节】';
		}
		
		var rf1=0;
		var rf2=0;
		var base = Math.abs(data.rf)
		
		if (parseFloat(data.rf) > 0) {
			rf1 = '-' + base;//客队
			rf2 = '+' + base;
			color1 = 'green';
			color2 = 'red';
		} else {
			rf1 = '+' + base;
			rf2 = '-' + base;
			color1 = 'red';
			color2 = 'green';
		}
		
		
		var rf1=0;
		var rf2=0;
		var base = Math.abs(data.rf)
		
		if (parseFloat(data.rf) > 0) {
			rf1 = '-' + base;//客队
			rf2 = '+' + base;
			color1 = 'green';
			color2 = 'red';
		} else {
			rf1 = '+' + base;
			rf2 = '-' + base;
			color1 = 'red';
			color2 = 'green';
		}
		
		$('#options').prepend('<p>猜'+jie+'总分奇偶</p><ul node="'+data.node+'" oddsid="'+data.id1+'" typename="3">\
		        <li opt="3"><span>奇数</span><cite>1.80</cite></li>\
		        <li opt="0"><span>偶数</span><cite>1.80</cite></li>\
			</ul>');
		
		
		if(difference){//有差异
			$('#options ul[node="'+data.node+'"][typename="1"]').prev().remove();
			$('#options ul[node="'+data.node+'"][typename="1"]').remove();//截止了让分
		}else{
			$('#options').prepend('<p>猜'+jie+'让分胜负</p><ul node="'+data.node+'" oddsid="'+data.id1+'" code="'+data.rf+'" typename="1">\
		            <li opt="0"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+data.gro+'</cite></li>\
		            <li opt="3"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜 '+data.hro+'</cite></li>\
		 		</ul>');
			
		}
		
		$('#options').prepend('<p>猜'+jie+'总分大小</p><ul node="'+data.node+'" oddsid="'+data.id2+'" typename="2" code="'+data.zf+'">\
		        <li opt="3"><span>总分&gt;<em class="zf">'+(data.zf?data.zf:"0")+'</em></span><cite>'+(data.hzo?data.hzo:"")+'</cite></li>\
		        <li opt="0"><span>总分&lt;<em class="zf">'+(data.zf?data.zf:"0")+'</em></span><cite>'+(data.gzo?data.gzo:"")+'</cite></li>\
			   </ul>');
		
		
		pn_fun();
	};
	
	
	
	
	var resultNode=function(data){
		//$('#endOption ul[node="'+data.node+'"]>p').append();
		
		var hsc = data["htScore"];
		var gsc = data["vtScore"];
		 
		var t = parseInt(hsc)+parseInt(gsc);
		
		$('#endOption ul[node="'+data.node+'"][typename="1"] cite').html(gsc+":"+hsc);//截止了让分
		
		$('#endOption ul[node="'+data.node+'"][typename="2"] cite').html(t);//截止了让分
		
		$('#endOption ul[node="'+data.node+'"][typename="3"] cite').html(t%2==0?"偶":"奇");//截止了让分
		
		
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
				//alert(JSON.stringify(game_info))
				var mtime = new Date(game_info.mtime.replace(/-/g, '/'));//当前比赛开始时间
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
										if(data && data!=null && data.length!=0){
											$('#talk').empty();
											chat.lastTime = data[0].timestamp;//获取更多用
											$.each(data, function() {
												chat.addMsg(this);
											});
											$("#talk").append('<div style="height:3.8rem">&nbsp;</div>')
										}
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
	};
	
	var myjj_param={
			flag:"3",
			cnickid:username,
			periodid:tmp_data.periodid
			/***
			psize:10,
			pnum:1,
			date1:"2015-10-01",
			date2:time_str
			***/
	};
	//获取筹码余额信息
	var getGolden = function(){
		$.ajax({
			async:false,
			data:myjj_param,
			url:'/grounder/takeinaccout.go',
			type: 'GET',
			dataType: 'xml',
			timeout: 1000,
			success: function(xml){
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				
				//userinfo code="0" desc="查询成功" source="null" total="1" tpage="1" balance="6101407.0"
				if(code==0){//查询成功
					var  r = R.find("row")
					var chipnum = r.attr("chipnum");
					/***
					var userinfo  = R.find("userinfo ");
					var balance = userinfo.attr("balance");
					balance=parseInt(balance);
					$("#jdyue").html(balance?balance:0);
					***/
					$("#jdyue").html('筹码：&nbsp;<i id="cm">'+(chipnum?chipnum:"0")+'</i>');
				}else{
					$("#jdyue").html('筹码：&nbsp;<i id="cm">'+(chipnum?chipnum:"0")+'</i>');
				}
			}
		})
	}
	//单节赛果
	var pn_fun=function(){
		$("#options").delegate("ul li","click",function(){
			dodata.opt = $(this).attr("opt");
			dodata.curCode=$(this).parent("ul").attr("node");//节数
			dodata.oddsid=$(this).parent("ul").attr("oddsid");//盘口赔率	表id  如:13477
			//dodata.ccodes = $(this).attr("opt");//投注内容    如:3  0
			dodata.type = $(this).parent("ul").attr("typename");
			var typename=$(this).parent("ul").prev().text().substring(1);
			var wfhtml = $(this).html()
			
			/***
			 * 解决比赛过期问题
			 */
			$("#tzCont").attr("type",dodata.type);
			$("#tzCont").attr("opt",dodata.ccodes);
			$("#tzCont").attr("node",dodata.curCode);
			
			//dodata.cperiodid=game_info.mid;
			//dodata.cquizname=encodeURIComponent(game_info.hn+""+typename);
			//dodata.hTName=encodeURIComponent(game_info.hn);
			//dodata.vTName=encodeURIComponent(game_info.gn);
			
			if(dodata.curCode==4){
				//$("#js").show();
				wfhtml = $(this).html()+"&nbsp;&nbsp;<i>(第4节投注含加时)</i>";//玩法内容
			}else{
				//$("#js").hide();
				wfhtml = $(this).html()
			}
			//var wfhtml = $(this).html()+"<em>(第4节投注含加时)</em>";//玩法内容
			$("#pkCont").html(''+wfhtml);
			
			$("#pop").show();
			$(".mask").show();
			$("#tzCont").show()
			
			var newnum = parseInt($("#in_golden").val())||0;
			
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));
			
			/***
			$.ajax({
				url:"/grounder/goldenbeanaccount.go?flag=0&qtype=3",
				dataType:'xml',
				cache:true,
				success: function(xml) {
					var R = $(xml).find("Resp");
					var code = R.attr("code");
					var desc = R.attr("desc");
					
					
					if(code==0){//查询成功
						var r = R.find("row");
						var balance = r.attr("balance");//筹码账户余额
						var daward = r.attr("daward");//当日盈亏
						var taward = r.attr("taward");//总盈利
						var dpm = r.attr("dpm");//当日排名
						var tpm = r.attr("tpm");//总排名
						var isqd = r.attr("isqd");//是否签到
						var nickid = r.attr("nickid")||"用户名";//用户名
						
						//$("#jdyue").html(balance);
						$("#pop").show();
						$(".mask").show();
						$("#tzCont").show()
						
						var newnum = parseInt($("#in_golden").val())||0;
						
						var pl = $("#pkCont cite").text();
						pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
						pl=parseFloat(pl);
						$("#fh").html(Math.ceil(newnum*pl));
						
					}else{//未登录
						var url = window.location.href;
						if(url.indexOf("?")!=-1){
							var it = url.split("?")[1];
							if(it){
								window.location.href="login.html"+"?"+it;
							}else{
								window.location.href="login.html";
							}
						}else{
							window.location.href="login.html";
						}
						//window.location.href="login.html";
					}
				}
			})
			***/
		})
			
	}
	
	//竞猜信息(模块)
	var quiz = {
			//渲染竞彩页面
			render : function(arr){
				if(arr && arr.length){//不为空
					var ks = [], ts = [];
					ks.push('<article  class="spfzpk" id="options">');
					ts.push('<article class="spfzpk long" id="endOption">');
					for(var s in arr){
						var obj_ = arr[s];
						
						var color = obj_.color;//盘口颜色
						var gro = obj_.gro;//客队让分赔率
						var gzo = obj_.gzo;//客队总分赔率
						var hro = obj_.hro;//主队让分赔率
						var hzo = obj_.hzo;//主队总分赔率
						var id1 = obj_.id1;//让分，基数赔率id
						var id2 = obj_.id2;//大小赔率id
						var mid = obj_.mid;//比赛id
						var node = obj_.node;//当前节 5：全场
						var playName = obj_.playName;//第几节
						var difference = obj_.difference;//第几节
						var rf = obj_.rf;//盘口
						var status = obj_.status;//当前是否可以购买
						var type = obj_.type;//2 当前节截止（1-让分[奇偶] 2-大小分）
						var zf = obj_.zf;//大小分
						
						var color1="";
						var color2="";
						var rf1=0;
						var rf2=0;
						var base = Math.abs(rf)
						
						if (parseFloat(rf) > 0) {
							rf1 = '-' + base;
							rf2 = '+' + base;
							color1 = 'green';
							color2 = 'red';
						} else {
							rf1 = '+' + base;
							rf2 = '-' + base;
							color1 = 'red';
							color2 = 'green';
						}

						
						var htScore = obj_.htScore;
						
						
						var m1=m2=m3="等待开奖";
						var c="";
						var c1=""
						if(htScore){
							var hsc = obj_["htScore"];
							var gsc = obj_["vtScore"];
							
							m1=gsc+":"+hsc;
							m2=parseInt(hsc)+parseInt(gsc);
							m3=m2%2==0?"偶":"奇";
							c="<i></i>";
							c1="red"
						}
//						0 0 没开始卖 1 0 全部开卖 1 1 截止了让分、奇偶 1 2 截止了大小 0 2、0 1 全部截止
						var jie = '';
						if(node == 5){
							jie = '全场';
						}else{
							jie = '【第<cite class="red">'+node+'</cite>节】';
						}
						if(status == 0){//全部截止
							if(type == 0){//未开售
								
								
							}else{
								
								ts.push('<p>猜'+jie+'总分大小</p><ul  node="'+node+'"  typename="2"><li><span>两队总分之和</span><cite class="'+c1+'">'+m2+'</cite>'+c+'</li></ul>')
				                
								ts.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" typename="1"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li></ul>')
								
								ts.push('<p>猜'+jie+'总分奇偶</p><ul  node="'+node+'"  typename="3"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m3+'</cite>'+c+'</li></ul>');
							}						
						}else if(status == 1){//有开售的
							if(type == 0){// 全开售
								ks.push('<p>猜'+jie+'总分大小</p><ul node="'+node+'" oddsid="'+id2+'" typename="2" code="'+zf+'">\
						                   <li opt="3"><span>总分&gt;<em class="zf">'+(zf?zf:"0")+'</em></span><cite>'+(hzo?hzo:"")+'</cite></li>\
						                   <li opt="0"><span>总分&lt;<em class="zf">'+(zf?zf:"0")+'</em></span><cite>'+(gzo?gzo:"")+'</cite></li>\
						       		   </ul>');
						      
								 if(difference){
									 ts.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" typename="1"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li></ul>')
								 }else{
									 ks.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1">\
							                  <li opt="0"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+gro+'</cite></li>\
							                  <li opt="3"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜 '+hro+'</cite></li>\
							       		</ul>');
								 }
						       
						       	ks.push('<p>猜'+jie+'总分奇偶</p><ul node="'+node+'" oddsid="'+id1+'" typename="3">\
					                   <li opt="3"><span>奇数</span><cite>1.80</cite></li>\
					                   <li opt="0"><span>偶数</span><cite>1.80</cite></li>\
					       		</ul>')
							}else if(type == 1){//截止了让分、奇偶
								
								ks.push('<p>猜'+jie+'总分大小</p><ul node="'+node+'" oddsid="'+id2+'" typename="2"><li><span>总分&gt;<em class="zf">'+zf+'</em></span><cite>'+hzo+'</cite></li><li><span>总分&lt;<em class="zf">'+zf+'</em></span><cite>'+gzo+'</cite></li></ul>');
								ts.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" typename="1"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li></ul>');
								ts.push('<p>猜'+jie+'总分奇偶</p><ul class="long" node="'+node+'" typename="3"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m2+'</cite>'+c+'</li></ul>');
							}else if(type == 2){//截止了大小
								
								ts.push('<p>猜'+jie+'总分大小</p><ul class="long" node="'+node+'" typename="2"><li><span>两队总分之和</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li></ul>');
								
								
								
								 if(difference){
									 ts.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" typename="1"><li><span>'+game_info.gn+' VS '+game_info.hn+'</span><cite class="'+c1+'">'+m1+'</cite>'+c+'</li></ul>')
								 }else{
									 ks.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" oddsid="'+id1+'" code="'+rf+'" typename="1">\
							                  <li opt="0"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+gro+'</cite></li>\
							                  <li opt="3"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜 '+hro+'</cite></li>\
							       		</ul>');
								 }
								 
								/***
								ks.push('<p>猜'+jie+'让分胜负</p><ul node="'+node+'" oddsid="'+id1+'" typename="1" code="'+rf+'">\
										<li opt="0"><span>'+game_info.gn+'<em class="'+color1+' rf">('+rf1+')</em></span><cite>胜'+gro+'</cite></li>\
										<li opt="3"><span>'+game_info.hn+'<em class="'+color2+' rf">('+rf2+')</em></span><cite>胜'+hro+'</cite></li>\
										</ul>');
										***/
								 
								ks.push('<p>猜'+jie+'总分奇偶</p><ul node="'+node+'" oddsid="'+id1+'" typename="3">\
										<li opt="3"><span>奇数</span><cite>1.80</cite></li>\
										<li opt="0"><span>偶数</span><cite>1.80</cite></li>\
										</ul>');
							}
						}
					}
					ks.push('</article>');
					ts.push('</article>');
					var html = ks.join('')+ts.join('');
					$('#odds').html(html);
					
					pn_fun();
					
					
				}else{
					alert('error');
				}
			},
			
			//确认竞猜
			confirmQuiz:function(){
				var data=dodata;
				$.ajax({
					url:"/grounder/takeinaccout.go",
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
							getGolden();//重新加载筹码
							$("#in_golden").val(50);
						}else if((code==-1 || code==2) && ((!isNaN(desc)))){
							alert("您本场比赛最多还可以投注"+desc+"筹码");
						}else{
							alert(desc);
						}
					}
				});
			}
	};
	
	
	var phb=function(){
		//var html=$("#dc_list").html();
		var html="";
		//单场排行
		var yzArr=[];
		var tempstr="";
		$.ajax({
			//url:"/grounder/fgoldenbeanaccount.go?flag=0&qtype=4&phtype=s&mid="+cur_match.sid,
			url:"/grounder/goldenbeanaccount.go?flag=0&qtype=4&phtype=s&mid="+game_info.mid,
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

				/**
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
				***/
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
						
						if(game_info.isRank==1){
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
						var tmpHTML="";
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
							
						if(game_info.isRank==1){
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
	
	//报名成功所需参数
	var is_bm_param={
			  flag:1,//操作标识，用来判断查询的逻辑，1表示查询用户是否报名过此期次，2表示进行报名操作 
			  cnickid:username,//当前登录用户名
			  periodid:tmp_data.periodid,//当前的期次号
			  visit:3500//主要验证visit(来源)字段
	};
	
	var is_bm_flag=false;
	var is_bm=function(){
		$.ajax({
			url : '/grounder/takeinaccout.go',
			type : "POST",
			data:is_bm_param,
			dataType : "xml",
			success : function(xml) {
				var R = $(xml).find("Resp");
				var code = R.attr("code");
				var desc = R.attr("desc");
				if(code==3){//处理成功
					is_bm_flag=true;
					$(".cs_btn").hide();
					$("#sjd").hide();
				}else{
					$(".cs_btn").show();
					$("#sjd").html("请先报名获取投注所需筹码");
				}
			}
		});
	}
	
	var remove_header=function(){
		var arg = localStorage.getItem("from");
		if(arg){
			$(".tzHeader").hide();
		}else{
			$(".tzHeader").show();
		}
	}
	
	var init=function(){
		//o.node();
		//判断是否有加奖
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
		is_bm();
		remove_header();
		getGolden();
		//chat.init();
		bindEvent();
	};
	
	var delFH = function(str){
		str = str.replace(/,/g,'');
		return str;
	}
	
	var bindEvent=function(){
		//直播，数据统计，竞猜切换
		$(".gqnav span").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur").siblings().removeClass("cur");
			
			$("#content").children("article:eq('"+index+"')").show()
			$("#content").children("article:eq('"+index+"')").siblings().hide();
			
			
			if(index==2){
				phb();
			}
			
		});
		
		//关闭购买层
		$("#close").bind("click",function(){
			
			$("#sjd").hide();
			$("#tzCont").hide()
			$(".mask").hide();
			
		});
		
		//积分切换
		$("#tzCont ul li:not(:first)").bind("click",function(){
			$(this).addClass("cur").siblings().removeClass("cur")
			setTimeout(function(){
				$("#tzCont ul li").removeClass("cur")
			},100);
			var num = parseInt($("#in_golden").val())||0;
			var remain_jd = parseInt(delFH($("#cm").html()));
			var v = $(this).html();
			if(v=="全押"){
				if(remain_jd>2000000){
					alert("单次竞猜最大投入200万筹码");
					$("#in_golden").val(2000000);
				}else{
					$("#in_golden").val(remain_jd);
				}
				
				$("#sjd").hide();
			}else{
				if(parseInt(v)*10000+num>2000000){
					alert("单次竞猜最大投入200万筹码");
					$("#in_golden").val(2000000);
				}else{
					if(remain_jd>parseInt(v)*10000+num){
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
				alert("单次竞猜最大投入200万筹码");
				return;
			}
			
			var pl = $("#pkCont cite").text();
			pl = pl.indexOf("胜")!=-1?pl.substring(1,pl.length):pl;
			pl=parseFloat(pl);
			$("#fh").html(Math.ceil(newnum*pl));

			
			
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
				alert("单次竞猜最大投入200万筹码");
			}else{
				$("#fh").html(Math.ceil(v*pl));
				$("#sjd").hide();
			}
			
			var jdyue=$("#cm").html();//显示隐藏余额不足			
			if(parseInt(jdyue)<parseInt($("#in_golden").val())){
				$("#sjd").show();
			}else{
				$("#sjd").hide();
			}	
		});
		
		$(".bcjj").bind("click",function(){
			var mid = $(this).attr("mid");
			var hn = $(this).attr("hn");
			var gn = $(this).attr("gn");
			window.location.href="dcph.html?mid="+mid+"&gn="+gn+"&hn="+hn;
		});
		
		//确认竞猜
		$("#sure").bind("click",function(){
			var remain_jd = delFH($("#cm").html());
			var tMoney=parseInt($("#in_golden").val())||0;
			
			/***
			 * oddsid变化时
			 */
			
			var type = $("#tzCont").attr("type");
			var opt = $("#tzCont").attr("opt");
			var node = $("#tzCont").attr("node");
			 var oddsid = $('#options ul[node="' +node + '"][typename="'+type+'"]').attr('oddsid');
			dodata.oddsid=oddsid;
			
			
			//盘口
			var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"]');
			var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"]');
			
			if(type==2){//总分
				var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] .zf').html();
				var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] cite').html();
				
				var oldpkv = $("#pkCont .zf").html();
				var oldplv = $("#pkCont cite").html();
				
				if(pkv != oldpkv || plv != oldplv){
					//$("#js").hide();
					$("#bh").show();
					setTimeout(function(){
						$("#bh").hide();
					},3000)
					$("#pkCont .zf").html(pkv);
					$("#pkCont cite").html(plv);
				}else{
					$("#bh").hide();
				}
			}else if(type==1){
				var pkv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] .rf').html();
				var plv = $('#options ul[node="' +node + '"][typename="'+type+'"] li[opt="'+opt+'"] cite').html();
				
				var oldpkv = $("#pkCont .rf").html();
				var oldplv = $("#pkCont cite").html();
				
				if(pkv != oldpkv || plv != oldplv){
					$("#js").hide();
					$("#bh").show();
					setTimeout(function(){
						$("#bh").hide();
					},3000)
					$("#pkCont .rf").html(pkv);
					$("#pkCont cite").html(plv);
				}else{
					$("#bh").hide();
				}
			}
			
			
			dodata.itmoney=tMoney;
			
			if(!tMoney){
				alert("输入筹码");
				return;
			}
			
			if(tMoney<50){
				alert("请至少输入50个筹码")
				return;
			}
			
			if(remain_jd>=tMoney){
				quiz.confirmQuiz();
			}else{
				$("#sjd").show();
				if(is_bm_flag){
					$("#sjd").html("筹码不足");
				}else{
					$("#sjd").html("请先报名获取投注所需筹码");
				}
			}
			
			
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
		});
		
		//获得筹码
		$("#obtain").bind("click",function(){
			window.location.href="hdjd.html"
		})
		
		
		//获得筹码
		$("#obtain").bind("click",function(){
			window.location.href="hdjd.html"
		})
		
		//奖券、积分切换
		$("#tz_cont div.pdLeft1").bind("click",function(){
			var index = $(this).index();
			$(this).addClass("cur");
			$(this).siblings().removeClass("cur");
			if(index==0){
				sign_up_success_param.stype=1;//积分
			}else{
				sign_up_success_param.stype=2;//奖券
			}
		});
		
		
		//报名成功
		$("#toSignUp").bind("click",function(){
			//sign_up_success_param.pointRemain=g.integral;
			
			if(sign_up_success_param.stype==1){//积分
				if(parseInt(g.integral)<parseInt(bm_jf_jq.integral)){
					$("#lack_of_balance").show();
					return;
				}
			}else{
				if(parseInt(g.award)<parseInt(bm_jf_jq.award)){
					$("#lack_of_balance").show();
					$("#lack_of_balance").html("奖券余额不足")
					return;
				}
			}
			bm_success(getGolden);
			
		});
		
		//参与报名
		$(".cs_btn").bind("click",function(){
			var integral = bm_jf_jq.integral=tmp_data.integral ;//积分
			var ticket =bm_jf_jq.award= tmp_data.award;//奖券
			D.confirm_tz(integral,ticket);
		});
	}
	
	
	//**********统计球员信息***********
	var statistics = {
			//获取信息内容
			gain : function(item){
				$.ajax({
					url:'/nbajc/tech/'+'js_'+item+'.txt',
					type:'get',
					success: function(txt){
						var txt_ = txt;
						var tj = txt_.split('$');
						$('#teamMember').html('');
						if(tj.length>0 && tj){
							statistics.render(tj);
						}else{
							$('#teamMember').html(noGame);
						}
					},error:function(){
						//alert('网络异常，请刷新页面');
						alert('暂无数据');
					}
				});
			},
			/**
			 * 渲染  队员数据
			 * @param txt
			 * txt 是个数组
			 * txt[0] 直接无视
			 * txt[1] 主 - 队员
			 * txt[2] 客 - 队员
			 * **********************************/
			render : function(txt){
				$.each(txt,function(i, v){
					var _out = [];
					if(i != 0){
						//$('#teamMember').remove(noGame);
						//$("#jcbf2").show();
						var v1 = v.split('!');
						
						var dy = '';//队员
						var dysj = '';//队员的数据
						var html_ = '';
						
						html = '<article class="touch">'+(i==1 && game_info.hn ||game_info.gn)+'</article><div class="clearfix">';
						dy = '<ul class="sjtjqy"><li>球员</li>';
						dysj = '<article class="qytext wscroll"><ul class="clearfix">';
						dysj += '<li><cite>得分</cite><cite>篮板</cite><cite>助攻</cite><cite>抢断</cite><cite>盖帽</cite><cite>时间</cite><cite>失误</cite><cite>犯规</cite><cite>投篮</cite><cite>3分</cite><cite>罚球</cite><cite>前场板</cite><cite>后场板</cite></li>';
						for(var s=0,m=v1.length; s<m-2; s++){
							var txt_ = v1[s];
							var t = txt_.split('^');
							/**
							 * @param t
							 * 0 1 队员名 2 3 4 5 位置 6 时间 7 投篮 8 投篮 9 3分 10 3分 11 罚球 12 罚球 13 篮板-进攻 
							 * 14 篮板-防守 15 篮板-总 16 助攻 17 犯规 18 抢断 19 失误 20 盖帽 21 得分
							 * */
							if(t[5] != '?' && t[5] != 0){
								dy += '<li>'+t[1].substring(0,6)+'</li>';
							}else{
								dy += '<li class="gray">'+t[1].substring(0,6)+'</li>';
							}
							dysj += '<li><cite>'+t[21]+'</cite><cite>'+t[15]+'</cite><cite>'+t[16]+'</cite><cite>'+t[18]+'</cite><cite>'+t[20]+'</cite><cite>'+t[6]+'</cite><cite>'+t[19]+'</cite><cite>'+t[17]+'</cite><cite>'+t[7]+'/'+t[8]+'</cite><cite>'+t[9]+'/'+t[10]+'</cite><cite>'+t[11]+'/'+t[12]+'</cite><cite>'+t[13]+'</cite><cite>'+t[14]+'</cite></li>';
						}
						dy += '</ul>';
						dysj += '</ul></article>';
						
						html = html + dy + dysj;
						html += '</div>';
						
						$('#teamMember').prepend(html);
					}else{
						//$("#jcbf2").hide();
						//$('#teamMember').prepend(noGame);
					}
				});
			},
			
			/***
			 * autor:ahu
			 */
			//及时改变球员数据的方法
			change:function(){
				$.ajax({
					url: '/nbajc/live/'+item+'Cg.txt',
					success:function(txt){
						statistics.render(txt.split('!'), true);
					}
				});
			}
	}
	
	return {
		init:init
	};
})()


$(function(){
	XHC.JCLQ.init();
})